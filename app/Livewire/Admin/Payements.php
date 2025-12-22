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
        // Charger tous les étudiants et méthodes de paiement
        $this->students = Student::orderBy('nom')->get();
        $this->paymentMethods = PaymentMethod::all();
    }

    /**
     * Mise à jour du preview des installments quand un étudiant est sélectionné
     */
    public function updatedStudentId()
    {
        $this->installmentsPreview = [];

        if (!$this->student_id) return;

        $student = Student::with([
            'enrollments.level.tuitionFees.installments.paymentAllocations.payment'
        ])->find($this->student_id);

        if (!$student) return;

        foreach ($student->enrollments as $enrollment) {
            if (!$enrollment->level) continue;

            foreach ($enrollment->level->tuitionFees as $fee) {
                // Tri stable par id pour conserver l’ordre des installments
                foreach ($fee->installments()->orderBy('id')->get() as $inst) {
                    // 🔹 Montant déjà payé pour cet étudiant
                    $paid = $inst->paymentAllocations()
                        ->whereHas('payment', fn($q) => $q->where('student_id', $student->id))
                        ->sum('amount');

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

    /**
     * Enregistrer un paiement
     */
    public function save()
    {
        $this->validate();

        $student = Student::with([
            'enrollments.level.tuitionFees.installments.paymentAllocations.payment'
        ])->findOrFail($this->student_id);

        DB::transaction(function () use ($student) {

            $remainingAmount = $this->amount_paid;

            // 🔹 Collecte toutes les installments pour cet étudiant dans l'ordre
            $installments = collect();
            foreach ($student->enrollments as $enrollment) {
                if (!$enrollment->level) continue;

                foreach ($enrollment->level->tuitionFees as $fee) {
                    foreach ($fee->installments()->orderBy('id')->get() as $inst) {
                        $installments->push($inst);
                    }
                }
            }

            // 🔹 Créer un paiement global
            $payment = Payment::create([
                'student_id'        => $student->id,
                'payment_method_id' => $this->payment_method_id,
                'total_amount'      => (float) $this->amount_paid,
                'reference'         => null,
                'status'            => 'CONFIRMED',
                'payment_date'      => now(),
            ]);

            // 🔹 Allocation progressive sur les installments
            foreach ($installments as $inst) {
                if ($remainingAmount <= 0) break;

                $alreadyAllocated = $inst->paymentAllocations()
                    ->whereHas('payment', fn($q) => $q->where('student_id', $student->id))
                    ->sum('amount');

                $rest = $inst->amount - $alreadyAllocated;

                if ($rest <= 0) continue;

                $toAllocate = min($remainingAmount, $rest);

                $payment->allocations()->create([
                    'installment_id' => $inst->id,
                    'amount'         => $toAllocate,
                ]);

                $remainingAmount -= $toAllocate;
            }

            if ($remainingAmount > 0) {
                throw new \Exception("Le montant dépasse la dette totale de cet étudiant.");
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
