<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentHistoriqShow extends Component
{
    public int $paymentId;
    public Payment $payment;

    public function cancelPayment()
    {
        if (Auth::user()->role_id !== 1) {
            session()->flash('error', 'Action non autorisée.');
            return;
        }

        $this->payment->delete(); // ou soft delete
        session()->flash('success', 'Paiement annulé avec succès.');
        return redirect()->route('admin.paymentHistoriq.index');
    }

    public function mount(int $paymentId)
    {
        $this->paymentId = $paymentId;

        $this->payment = Payment::with([
            'student',
            'paymentMethod',
            'allocations.installment'  // <-- ici la relation correcte
        ])->findOrFail($paymentId);
    }

    public function render()
    {
        return view('livewire.admin.payment-historiq-show');
    }
}
