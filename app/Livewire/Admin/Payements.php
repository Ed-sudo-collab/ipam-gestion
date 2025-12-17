<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\TuitionFee;
use App\Models\TuitionInstallment;
use App\Models\Payment;
use App\Models\PaymentMethod;

class Payements extends Component
{
    public $students;
    public $paymentMethods;

    public $student_id;
    public $amount_paid;
    public $payment_method_id;

    public $installmentsPreview = [];

    public function mount()
    {
        $this->students = Student::with(['enrollments.level.tuitionFees.installments'])->get();
        $this->paymentMethods = PaymentMethod::all();
    }

    /* =====================================================
     * PRÉVISUALISATION DE LA DETTE
     * ===================================================== */
    public function updatedStudentId()
    {
        $this->installmentsPreview = [];

        if (!$this->student_id) return;

        $student = Student::with([
            'enrollments.level.tuitionFees.installments.payments'
        ])->find($this->student_id);

        if (!$student) return;

        foreach ($student->enrollments as $enrollment) {
            foreach ($enrollment->level->tuitionFees as $fee) {
                foreach ($fee->installments()->get()->sortBy(['due_date', 'id']) as $inst) {

                    $paid = $inst->payments->sum('amount_paid');
                    $remaining = $inst->amount - $paid;

                    $this->installmentsPreview[] = [
                        'label'     => $inst->label,
                        'amount'    => $inst->amount,
                        'paid'      => $paid,
                        'remaining' => $remaining,
                        'due_date'  => $inst->due_date,
                        'status'    => $remaining <= 0
                            ? 'PAYÉE'
                            : ($paid > 0 ? 'PARTIELLE' : 'IMPAYÉE'),
                    ];
                }
            }
        }
    }

    /* =====================================================
     * VALIDATION
     * ===================================================== */
    protected function rules()
    {
        return [
            'student_id'        => 'required|exists:students,id',
            'amount_paid'       => 'required|numeric|min:1',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ];
    }

    /* =====================================================
     * LOGIQUE MÉTIER DU PAIEMENT LIBRE
     * ===================================================== */
    public function save()
    {
        $this->validate();

        $student = Student::with([
            'enrollments.level.tuitionFees.installments.payments'
        ])->findOrFail($this->student_id);

        DB::transaction(function () use ($student) {

            $remainingAmount = $this->amount_paid;

            $installments = collect();

            foreach ($student->enrollments as $enrollment) {
                foreach ($enrollment->level->tuitionFees as $fee) {
                    $installments = $installments->merge(
                        $fee->installments()->get()->sortBy(['due_date', 'id'])
                    );
                }
            }

            foreach ($installments as $inst) {
                if ($remainingAmount <= 0) break;

                $alreadyPaid = $inst->payments->sum('amount_paid');
                $rest = $inst->amount - $alreadyPaid;

                if ($rest <= 0) continue;

                $toPay = min($remainingAmount, $rest);

                Payment::create([
                    'student_id'        => $student->id,
                    'fee_id'            => $inst->tuition_fee_id,
                    'installment_id'    => $inst->id,
                    'payment_method_id' => $this->payment_method_id,
                    'amount_paid'       => $toPay,
                    'payment_date'      => now(),
                ]);

                $remainingAmount -= $toPay;
            }

            if ($remainingAmount > 0) {
                throw new \Exception("Le montant dépasse la dette totale.");
            }
        });

        session()->flash('success', 'Paiement enregistré avec succès.');

        $this->reset(['amount_paid']);
        $this->updatedStudentId();
    }

    public function render()
    {
        return view('livewire.admin.payements');
    }
}
