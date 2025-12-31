<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class PaymentHistoriqIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public bool $showFilters = false;


    /* ===========================
     * 🔎 FILTRES
     * =========================== */

    // 👤 Étudiant
    public $search_student = '';

    // 📅 Dates
    public $payment_date = null;
    public $start_date   = null;
    public $end_date     = null;
    public $month        = null;
    public $year         = null;
    public $academic_year_id = null;

    // 💰 Montants
    public $amount_exact = null;
    public $amount_min   = null;
    public $amount_max   = null;

    // 💳 Mode de paiement
    public $payment_method_id = null;

    /* ===========================
     * DATA POUR FILTRES
     * =========================== */
    public $paymentMethods;
    public $academicYears;

    /* ===========================
     * LIFECYCLE
     * =========================== */
    public function mount()
    {
        $this->paymentMethods = PaymentMethod::where('is_active', true)->get();
        $this->academicYears  = AcademicYear::orderBy('libelle')->get();
    }

    /* ===========================
     * ACTIONS
     * =========================== */

    public function resetFilters()
    {
        $this->reset([
            'search_student',
            'payment_date',
            'start_date',
            'end_date',
            'month',
            'year',
            'academic_year_id',
            'amount_exact',
            'amount_min',
            'amount_max',
            'payment_method_id',
        ]);

        $this->resetPage();
    }

    public function cancelPayment($id)
    {
        if (Auth::user()->role_id !== 1) {
            session()->flash('error', 'Action non autorisée.');
            return;
        }

        $payment = Payment::findOrFail($id);
        $payment->delete(); // ou soft delete

        session()->flash('success', 'Paiement annulé avec succès.');
        $this->resetPage();
    }

    /* ===========================
     * RENDER
     * =========================== */
    public function render()
    {
        $payments = Payment::with([
                'student',
                'paymentMethod',
                'allocations.installment',
            ])

            /* 👤 Étudiant (nom / prénom / matricule) */
            ->when($this->search_student, function (Builder $q) {
                $q->whereHas('student', function (Builder $sq) {
                    $sq->where('nom', 'like', "%{$this->search_student}%")
                       ->orWhere('prenom', 'like', "%{$this->search_student}%")
                       ->orWhere('matricule', 'like', "%{$this->search_student}%");
                });
            })

            /* 💳 Mode de paiement */
            ->when($this->payment_method_id,
                fn ($q) => $q->where('payment_method_id', $this->payment_method_id)
            )

            /* 📅 Date exacte */
            ->when($this->payment_date,
                fn ($q) => $q->whereDate('payment_date', $this->payment_date)
            )

            /* 📅 Intervalle de dates */
            ->when($this->start_date && $this->end_date,
                fn ($q) => $q->whereBetween('payment_date', [
                    $this->start_date,
                    $this->end_date
                ])
            )

            /* 📅 Mois */
            ->when($this->month,
                fn ($q) => $q->whereMonth('payment_date', $this->month)
            )

            /* 📅 Année */
            ->when($this->year,
                fn ($q) => $q->whereYear('payment_date', $this->year)
            )

            /* 🎓 Année académique (via inscriptions étudiant) */
            ->when($this->academic_year_id, function (Builder $q) {
                $q->whereHas('student.enrollments', function (Builder $eq) {
                    $eq->where('academic_year_id', $this->academic_year_id);
                });
            })

            /* 💰 Montant exact */
            ->when($this->amount_exact !== null,
                fn ($q) => $q->where('total_amount', $this->amount_exact)
            )

            /* 💰 Intervalle montant */
            ->when($this->amount_min !== null && $this->amount_max !== null,
                fn ($q) => $q->whereBetween('total_amount', [
                    $this->amount_min,
                    $this->amount_max
                ])
            )

            ->orderByDesc('payment_date')
            ->paginate(10);

        return view('livewire.admin.payment-historiq-index', compact('payments'));
    }
}
