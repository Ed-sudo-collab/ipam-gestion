<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentHistoriq extends Controller
{
    /**
     * 📄 HISTORIQUE DES PAIEMENTS
     */
    public function index()
    {
        return view('admin.paymentHistoriq.index');
    }

    /**
     * 🔍 DÉTAIL D’UN PAIEMENT
     */
    public function show($paymentId)
    {
        $payment = Payment::with([
            'student',
            'paymentMethod',
            'allocations.installment', // <-- important !
        ])->findOrFail($paymentId);

        return view('admin.paymentHistoriq.show', compact('payment'));
    }

}
