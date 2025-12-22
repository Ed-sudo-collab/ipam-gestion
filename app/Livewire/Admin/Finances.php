<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Student;

class Finances extends Component
{
    /* =======================
     |     PROPRIÉTÉS
     |======================= */

    public $students;
    public $student_id;

    public $summary = [];
    public $feesDetails = [];
    public $paymentsHistory = [];

    /* =======================
     |     INITIALISATION
     |======================= */

    public function mount()
    {
        $this->students = Student::orderBy('nom')->get();
    }

    /* =======================
     |   RÉACTIVITÉ LIVEWIRE
     |======================= */

    public function updatedStudentId()
    {
        $this->loadStudentFinances();
    }

    /* =======================
     |   CHARGEMENT DES DONNÉES
     |======================= */

    private function loadStudentFinances()
    {
        // 🔄 Reset complet
        $this->summary = [];
        $this->feesDetails = [];
        $this->paymentsHistory = [];

        if (!$this->student_id) {
            return;
        }

        $student = Student::with([
            'enrollments.academicYear',
            'enrollments.level.tuitionFees.installments.paymentAllocations.payment.paymentMethod',
        ])->find($this->student_id);

        if (!$student) {
            return;
        }

        foreach ($student->enrollments as $enrollment) {

            if (!$enrollment->academicYear || !$enrollment->level) {
                continue;
            }

            $yearId    = $enrollment->academicYear->id;
            $yearLabel = $enrollment->academicYear->libelle;

            // 🔹 Initialisation annuelle
            if (!isset($this->summary[$yearId])) {
                $this->summary[$yearId] = [
                    'label'     => $yearLabel,
                    'total'     => 0,
                    'paid'      => 0,
                    'remaining' => 0,
                ];

                $this->feesDetails[$yearId] = [];
                $this->paymentsHistory[$yearId] = [];
            }

            foreach ($enrollment->level->tuitionFees as $fee) {
                foreach ($fee->installments()->get() as $inst) {

                    // 🔥 FILTRAGE STRICT PAR ÉTUDIANT
                    $allocations = $inst->paymentAllocations
                        ->filter(fn ($allocation) =>
                            $allocation->payment &&
                            $allocation->payment->student_id === $student->id
                        );

                    $paid = $allocations->sum('amount');
                    $remaining = max(0, $inst->amount - $paid);

                    // 🔹 Résumé annuel
                    $this->summary[$yearId]['total']     += $inst->amount;
                    $this->summary[$yearId]['paid']      += $paid;
                    $this->summary[$yearId]['remaining'] += $remaining;

                    // 🔹 Détails des échéances
                    $this->feesDetails[$yearId][] = [
                        'label'     => $inst->label,
                        'amount'    => $inst->amount,
                        'paid'      => $paid,
                        'remaining' => $remaining,
                        'due_date'  => $inst->due_date,
                        'status'    => $remaining <= 0
                            ? 'PAYÉE'
                            : ($paid > 0 ? 'PARTIELLE' : 'IMPAYÉE'),
                    ];

                    // 🔹 Historique des paiements
                    foreach ($allocations as $allocation) {
                        $payment = $allocation->payment;

                        $this->paymentsHistory[$yearId][] = [
                            'date'   => $payment->payment_date,
                            'amount' => $allocation->amount,
                            'method' => $payment->paymentMethod->name ?? '-',
                            'label'  => $inst->label,
                        ];
                    }
                }
            }
        }

        // 🔽 Tri des paiements par date décroissante
        foreach ($this->paymentsHistory as $yearId => $history) {
            usort($this->paymentsHistory[$yearId], fn ($a, $b) =>
                strtotime($b['date']) <=> strtotime($a['date'])
            );
        }
    }

    /* =======================
     |       RENDER
     |======================= */

    public function render()
    {
        return view('livewire.admin.finances');
    }
}
