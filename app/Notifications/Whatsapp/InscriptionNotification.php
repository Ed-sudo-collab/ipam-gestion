<?php

namespace App\Notifications\WhatsApp;

use App\Models\Student;

class InscriptionNotification
{
    protected Student $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function message(): string
    {
        return "Bonjour {$this->student->prenom} {$this->student->nom}, votre inscription a été validée avec succès !";
    }
}
