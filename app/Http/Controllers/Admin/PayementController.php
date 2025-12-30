<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PayementController extends Controller
{
        public function index()
        {
            return view('admin.payement.index');
        }

        /**
         * 🧾 Génération du reçu de paiement (version simple, sans logique métier)
         */
        public function receipt($paymentId)
        {
            $payment = Payment::with([
                'student.enrollments.academicYear',
                'student.enrollments.program',
                'student.enrollments.level',
                'paymentMethod',
                'allocations.installment',
            ])->findOrFail($paymentId);

            return view('admin.payement.receipt', compact('payment'));
        }




}
