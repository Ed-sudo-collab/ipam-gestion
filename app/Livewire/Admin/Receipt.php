<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Payment;

class Receipt extends Component
{
    /* =======================
     |   PROPRIÉTÉS
     |======================= */

    public int $paymentId;

    public $payment;
    public $student;
    public $academicYear;
    public $program;
    public $level;

    public float $remainingAmount = 0;

    /* =======================
     |   INITIALISATION
     |======================= */

    public function mount(int $paymentId)
    {
        $this->paymentId = $paymentId;

        $this->loadReceiptData();
    }

    /* =======================
     |   LOGIQUE MÉTIER
     |======================= */

    private function loadReceiptData(): void
    {
        $this->payment = Payment::with([
            'student.enrollments.academicYear',
            'student.enrollments.program',
            'student.enrollments.level.tuitionFees.installments',
            'paymentMethod',
            'allocations.installment',
        ])->findOrFail($this->paymentId);

        $this->student = $this->payment->student;

        /**
         * 🔹 Inscription la plus récente (logique standard)
         */
        $enrollment = $this->student->enrollments
            ->sortByDesc('created_at')
            ->first();

        if (!$enrollment) {
            abort(404, 'Aucune inscription trouvée pour cet étudiant');
        }

        $this->academicYear = $enrollment->academicYear;
        $this->program      = $enrollment->program;
        $this->level        = $enrollment->level;





        /**
         * 🔹 Calcul du reliquat AU MOMENT du paiement
         */

        // Total de la scolarité
        $totalDue = $this->level->tuitionFees
            ->flatMap(fn ($fee) => $fee->installments()->get())
            ->sum('amount');

        // Total payé jusqu'à ce paiement (date <= paiement courant)
        $totalPaidUntilThisPayment = $this->student->payments()
            ->where('payment_date', '<=', $this->payment->payment_date)
            ->sum('total_amount');

        // Reliquat à l’instant T
        $this->remainingAmount = max(0, $totalDue - $totalPaidUntilThisPayment);




    }

    /* =======================
     |   RENDER
     |======================= */

    public function render()
    {
        return view('livewire.admin.receipt');
    }
}
