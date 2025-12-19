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

    public function updated($property)
    {
        if ($property === 'student_id') {
            $this->loadStudentFinances();
        }
    }

    /* =======================
     |   CHARGEMENT DES DONNÉES
     |======================= */

    private function loadStudentFinances()
    {
        // Reset
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

            // Initialisation annuelle
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

                    // 🔹 Montant payé via allocations
                    $paid = $inst->paymentAllocations->sum('amount');
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

                    // 🔹 Historique des paiements (via allocations)
                    foreach ($inst->paymentAllocations as $allocation) {
                        $payment = $allocation->payment;

                        if (!$payment) continue;

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

        // Tri historique par date décroissante
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
