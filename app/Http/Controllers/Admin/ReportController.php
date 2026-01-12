<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * 📄 EXPORT : Liste des étudiants (PDF)
     */
    public function students(Request $request)
    {
        $students = Student::with(['statut', 'enrollments.level.programs', 'enrollments.academicYear'])
            ->when($request->filled('statut_id'), fn($q) => $q->where('statut_id', $request->statut_id))
            ->when($request->filled('program_id'), fn($q) => $q->whereHas('enrollments.level.program', fn($lq) => $lq->where('id', $request->program_id)))
            ->when($request->filled('level_id'), fn($q) => $q->whereHas('enrollments', fn($eq) => $eq->where('level_id', $request->level_id)))
            ->when($request->filled('academic_year_id'), fn($q) => $q->whereHas('enrollments', fn($eq) => $eq->where('academic_year_id', $request->academic_year_id)))
            ->orderBy('nom')
            ->get();

        $pdf = Pdf::loadView('reports.students', compact('students', 'request'))->setPaper('a4', 'portrait');

        return $pdf->download('liste_etudiants.pdf');
    }

    /**
     * 💰 EXPORT : État des paiements (PDF)
     */
    public function payments(Request $request)
    {
        $enrollments = Enrollment::with([
                'student',
                'level.programs',
                'level.tuitionFees.installments.paymentAllocations.payment.paymentMethod'
            ])
            ->when($request->filled('program_id'), fn($q) => $q->whereHas('level.program', fn($lq) => $lq->where('id', $request->program_id)))
            ->when($request->filled('level_id'), fn($q) => $q->where('level_id', $request->level_id))
            ->when($request->filled('start_date') && $request->filled('end_date'), fn($q) => $q->whereHas('level.tuitionFees.installments.paymentAllocations.payment', fn($pq) => $pq->whereBetween('payment_date', [$request->start_date, $request->end_date])))
            ->orderByDesc('created_at')
            ->get();

        $pdf = Pdf::loadView('reports.payments', compact('enrollments', 'request'))->setPaper('a4', 'landscape');

        return $pdf->download('etat_paiements.pdf');
    }

    /**
     * 📊 EXPORT : Situation financière d’un étudiant (PDF)
     */
    public function studentFinancial($studentId)
    {
        $student = Student::with([
                'enrollments.academicYear',
                'enrollments.level.tuitionFees.installments.paymentAllocations.payment.paymentMethod',
            ])->findOrFail($studentId);

        $summary = [];
        $feesDetails = [];
        $paymentsHistory = [];

        foreach ($student->enrollments as $enrollment) {
            $level = $enrollment->level;
            $year  = $enrollment->academicYear;

            if (!$level || !$year) continue;

            $yearId = $year->id;

            $summary[$yearId] = [
                'label' => $year->libelle,
                'level' => $level->name,
                'total' => 0,
                'paid' => 0,
                'remaining' => 0,
            ];

            $feesDetails[$yearId] = [];
            $paymentsHistory[$yearId] = [];

            foreach ($level->tuitionFees ?? [] as $fee) {
                foreach ($fee->installments()->get() ?? [] as $installment) {
                    $allocations = $installment->paymentAllocations
                        ->filter(fn($a) => $a->payment && $a->payment->student_id === $student->id);

                    $paid = $allocations->sum('amount');
                    $remaining = max(0, $installment->amount - $paid);

                    $summary[$yearId]['total'] += $installment->amount;
                    $summary[$yearId]['paid'] += $paid;
                    $summary[$yearId]['remaining'] += $remaining;

                    $feesDetails[$yearId][] = [
                        'label' => $installment->label,
                        'amount' => $installment->amount,
                        'paid' => $paid,
                        'remaining' => $remaining,
                        'due_date' => $installment->due_date,
                        'status' => $remaining <= 0 ? 'PAYÉE' : ($paid > 0 ? 'PARTIELLE' : 'IMPAYÉE'),
                    ];

                    foreach ($allocations as $allocation) {
                        $payment = $allocation->payment;
                        $paymentsHistory[$yearId][] = [
                            'date' => $payment->payment_date,
                            'amount' => $allocation->amount,
                            'method' => $payment->paymentMethod->name ?? '-',
                            'label' => $installment->label,
                        ];
                    }
                }
            }
        }

        $pdf = Pdf::loadView('reports.student_financial', compact('student', 'summary', 'feesDetails', 'paymentsHistory'));

        return $pdf->download("situation_financiere_{$student->nom}.pdf");
    }
}
