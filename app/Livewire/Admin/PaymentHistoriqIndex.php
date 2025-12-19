<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentHistoriqIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $methodId = null;
    public $startDate = null;
    public $endDate = null;

    protected $paginationTheme = 'tailwind';

    public function cancelPayment($id)
    {
        if (Auth::user()->role_id !== 1) {
            session()->flash('error', 'Action non autorisée.');
            return;
        }

        $payment = Payment::findOrFail($id);
        $payment->delete(); // ou soft delete selon ta structure

        session()->flash('success', 'Paiement annulé avec succès.');
        $this->resetPage();
    }

    public function render()
    {
        $payments = Payment::with(['student', 'paymentMethod', 'allocations.installment'])
            ->when($this->search, function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('first_name', 'like', "%{$this->search}%")
                      ->orWhere('last_name', 'like', "%{$this->search}%")
                      ->orWhere('matricule', 'like', "%{$this->search}%");
                });
            })
            ->when($this->methodId, fn($q) => $q->where('payment_method_id', $this->methodId))
            ->when($this->startDate && $this->endDate, fn($q) =>
                $q->whereBetween('payment_date', [$this->startDate, $this->endDate])
            )
            ->orderByDesc('payment_date')
            ->paginate(10);

        return view('livewire.admin.payment-historiq-index', compact('payments'));
    }
}
