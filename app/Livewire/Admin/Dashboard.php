<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\TuitionFee;
use App\Models\Level;

class Dashboard extends Component
{
    // 📊 Indicateurs
    public $totalStudents = 0;
    public $studentsThisYear = 0;
    public $enrollmentsValidated = 0;
    public $enrollmentsPending = 0;
    public $totalFees = 0;
    public $totalCollected = 0;
    public $totalRemaining = 0;
    public $collectionRate = 0;

    // 📈 Graphiques
    public $enrollmentsByMonth = [];
    public $paymentsByMonth = [];
    public $studentsByProgram = [];

    // ⚠️ Alertes
    public $studentsLatePayments = [];
    public $enrollmentsPendingPayment = [];

    public function mount()
    {
        $currentYear = now()->year;

        // ------------------------
        // Indicateurs clés
        // ------------------------
        $this->totalStudents        = Student::count();
        $this->studentsThisYear     = Enrollment::whereYear('date_inscription', $currentYear)->count();
        $this->enrollmentsValidated = Enrollment::where('statut', 'validee')->count();
        $this->enrollmentsPending   = Enrollment::where('statut', 'annulee')->count();

        $this->totalFees = Enrollment::with('level.tuitionFees')
            ->get()
            ->sum(function($enrollment) {
                $fee = $enrollment->level->tuitionFees->first(); // on prend le 1er fee du niveau
                return $fee ? $fee->total_amount : 0;
            });

        $this->totalCollected = Payment::sum('total_amount');
        $this->totalRemaining = max(0, $this->totalFees - $this->totalCollected);
        $this->collectionRate = $this->totalFees > 0
            ? round(($this->totalCollected / $this->totalFees) * 100, 2)
            : 0;

        // ------------------------
        // Graphiques
        // ------------------------
        $this->enrollmentsByMonth = Enrollment::selectRaw('MONTH(date_inscription) as month, COUNT(*) as count')
            ->whereYear('date_inscription', $currentYear)
            ->groupBy('month')
            ->pluck('count','month')
            ->toArray();

        $this->paymentsByMonth = Payment::selectRaw('MONTH(payment_date) as month, SUM(total_amount) as total')
            ->whereYear('payment_date', $currentYear)
            ->groupBy('month')
            ->pluck('total','month')
            ->toArray();

        $this->studentsByProgram = Enrollment::with('level.programs')->get()
            ->groupBy(function ($e) {
                return $e->level && $e->level->programs->first()
                    ? $e->level->programs->first()->name
                    : 'Non défini';
            })
            ->map(fn($group) => $group->count())
            ->toArray();

        // ------------------------
        // Alertes
        // ------------------------
        $this->studentsLatePayments = Student::where('statut_id', 5)->get();
        $this->enrollmentsPendingPayment = Enrollment::where('statut', 'En_cours_paiement')->get();


    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
