<?php

namespace App\Notifications\WhatsApp;

use App\Models\Student;
use Carbon\Carbon;

class RetardNotification
{
    protected Student $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function message(): string
    {
        // Chercher la première échéance passée et non payée
        $overdue = $this->student->enrollments()
            ->with(['tuitionFee.tuitionInstallments' => function ($q) {
                $q->whereDate('due_date', '<', Carbon::today());
            }])
            ->get()
            ->pluck('tuitionFee')
            ->flatten()
            ->pluck('tuitionInstallments')
            ->flatten()
            ->first();

        if (!$overdue) {
            return "Bonjour {$this->student->prenom}, vous n'avez pas de paiement en retard.";
        }

        $date = Carbon::parse($overdue->due_date)->format('d/m/Y');
        $montant = $overdue->amount;

        return "Bonjour {$this->student->prenom}, votre paiement de {$montant} était dû le {$date} et est en retard. Merci de régulariser rapidement.";
    }
}
