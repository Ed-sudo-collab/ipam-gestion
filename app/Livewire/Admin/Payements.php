<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Enrollment;
use App\Events\PaiementEnregistre;


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
        $this->students = Student::orderBy('nom')->get();
        $this->paymentMethods = PaymentMethod::all();
    }

    /* ===============================
     | PREVIEW DES ÉCHÉANCES
     |=============================== */
    public function updatedStudentId()
    {
        $this->installmentsPreview = [];

        if (!$this->student_id) return;

        $student = Student::with([
            'enrollments.level.tuitionFees.installments.paymentAllocations.payment'
        ])->find($this->student_id);

        if (!$student) return;

        foreach ($student->enrollments as $enrollment) {
            foreach ($enrollment->level?->tuitionFees ?? [] as $fee) {
                foreach ($fee->installments()->orderBy('id')->get() as $inst) {

                    $paid = $inst->paymentAllocations()
                        ->whereHas('payment', fn ($q) =>
                            $q->where('student_id', $student->id)
                        )
                        ->sum('amount');

                    $this->installmentsPreview[] = [
                        'enrollment_id' => $enrollment->id,
                        'label'         => $inst->label,
                        'amount'        => $inst->amount,
                        'paid'          => $paid,
                        'remaining'     => $inst->amount - $paid,
                        'status'        => $paid >= $inst->amount
                            ? 'PAYÉE'
                            : ($paid > 0 ? 'PARTIELLE' : 'IMPAYÉE'),
                    ];
                }
            }
        }
    }

    protected function rules()
    {
        return [
            'student_id'        => 'required|exists:students,id',
            'amount_paid'       => 'required|numeric|min:1',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ];
    }

    /* ===============================
     | ENREGISTREMENT DU PAIEMENT
     |=============================== */
    public function save()
    {
        $this->validate();

        $student = Student::with([
            'enrollments.level.tuitionFees.installments.paymentAllocations.payment'
        ])->findOrFail($this->student_id);

        DB::transaction(function () use ($student) {

            $remainingAmount = $this->amount_paid;

            /** 🔹 Création du paiement */
            $payment = Payment::create([
                'student_id'        => $student->id,
                'payment_method_id' => $this->payment_method_id,
                'total_amount'      => $this->amount_paid,
                'payment_date'      => now(),
            ]);

            /** 🔹 Paiement progressif */
            foreach ($student->enrollments as $enrollment) {

                foreach ($enrollment->level?->tuitionFees ?? [] as $fee) {

                    $installments = $fee->installments()->orderBy('id')->get();

                    foreach ($installments as $index => $inst) {

                        if ($remainingAmount <= 0) break 3;

                        $alreadyPaid = $inst->paymentAllocations()
                            ->whereHas('payment', fn ($q) =>
                                $q->where('student_id', $student->id)
                            )
                            ->sum('amount');

                        $rest = $inst->amount - $alreadyPaid;
                        if ($rest <= 0) continue;

                        $toAllocate = min($remainingAmount, $rest);

                        $payment->allocations()->create([
                            'installment_id' => $inst->id,
                            'amount'         => $toAllocate,
                        ]);

                        $remainingAmount -= $toAllocate;

                        /**
                         * ✅ SI LA 1ʳᵉ ÉCHÉANCE EST SOLDÉE → VALIDATION DE L’INSCRIPTION
                         */
                        if ($index === 0 && ($alreadyPaid + $toAllocate) >= $inst->amount) {
                            $enrollment->validateEnrollment();
                        }
                    }
                }
            }

            if ($remainingAmount > 0) {
                throw new \Exception("Le montant dépasse la dette totale.");
            }

            // 🔹 MISE À JOUR DU STATUT FINANCIER DE L'ÉTUDIANT
            $student->updateFinancialStatus();




            $student = Student::findOrFail(id: $this->student_id);

            $resteAPayer = $student->getTotalDebt();

            event(new PaiementEnregistre(
                $student,
                $payment,
                $resteAPayer
            ));







        });

        session()->flash('success', 'Paiement enregistré et inscription mise à jour.');
        $this->reset(['amount_paid']);
        $this->updatedStudentId();
    }

    public function render()
    {
        return view('livewire.admin.payements');
    }
}
