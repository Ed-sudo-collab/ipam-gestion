<?php

namespace App\Notifications\WhatsApp;

use App\Models\Student;
use Carbon\Carbon;

class RappelEcheanceNotification
{
    protected Student $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function message(): string
    {
        // Chercher la première échéance non payée à venir
        $nextDue = $this->student->enrollments()
            ->with(['tuitionFee.tuitionInstallments' => function ($q) {
                $q->whereDate('due_date', '>=', Carbon::today());
            }])
            ->get()
            ->pluck('tuitionFee')
            ->flatten()
            ->pluck('tuitionInstallments')
            ->flatten()
            ->first();

        if (!$nextDue) {
            return "Bonjour {$this->student->prenom}, aucune échéance à venir pour le moment.";
        }

        $date = Carbon::parse($nextDue->due_date)->format('d/m/Y');
        $montant = $nextDue->amount;

        return "Bonjour {$this->student->prenom}, votre prochaine échéance est le {$date} pour un montant de {$montant}. Merci de régler à temps.";
    }
}
