<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
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

    public function updatedStudentId()
    {
        $this->installmentsPreview = [];

        if (!$this->student_id) return;

        $student = Student::with([
            'enrollments.level.tuitionFees.installments.paymentAllocations'
        ])->find($this->student_id);

        if (!$student) return;

        foreach ($student->enrollments as $enrollment) {
            if (!$enrollment->level) continue;

            foreach ($enrollment->level->tuitionFees as $fee) {
                foreach ($fee->installments()->get() as $inst) {
                    $paid = $inst->paymentAllocations->sum('amount');
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

    protected function rules()
    {
        return [
            'student_id'        => 'required|exists:students,id',
            'amount_paid'       => 'required|numeric|min:1',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ];
    }

public function save()
{
    $this->validate();


    $student = Student::with([
        'enrollments.level.tuitionFees.installments.paymentAllocations'
    ])->findOrFail($this->student_id);

    DB::transaction(function () use ($student) {

        $remainingAmount = $this->amount_paid;

        // Collecte toutes les échéances de l'étudiant
        $installments = collect();
        foreach ($student->enrollments as $enrollment) {
            if (!$enrollment->level) continue;
            foreach ($enrollment->level->tuitionFees as $fee) {
                foreach ($fee->installments()->get() as $inst) {
                    $installments->push($inst);
                }
            }
        }

        // Tri par date d'échéance
        $installments = $installments->sortBy('due_date');

        // Créer un paiement global pour ce montant
        $payment = Payment::create([
            'student_id'        => $student->id,
            'payment_method_id' => $this->payment_method_id,
            'total_amount'      => (float) $this->amount_paid, // <- conversion
            'reference'         => null,
            'status'            => 'CONFIRMED',
            'payment_date'      => now(),
        ]);


        foreach ($installments as $inst) {
            if ($remainingAmount <= 0) break;

            $alreadyAllocated = $inst->paymentAllocations->sum('amount');
            $rest = $inst->amount - $alreadyAllocated;

            if ($rest <= 0) continue;

            $toAllocate = min($remainingAmount, $rest);

            // Créer l'allocation
            $payment->allocations()->create([
                'installment_id' => $inst->id,
                'amount'         => $toAllocate,
            ]);

            $remainingAmount -= $toAllocate;
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
