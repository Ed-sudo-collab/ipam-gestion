<?php

namespace App\Notifications\WhatsApp;

use App\Models\Student;

class PaiementNotification
{
    protected Student $student;
    protected float $montant;

    public function __construct(Student $student, float $montant)
    {
        $this->student = $student;
        $this->montant = $montant;
    }

    public function message(): string
    {
        return "Bonjour {$this->student->prenom} {$this->student->nom}, votre paiement de {$this->montant} a été enregistré avec succès.";
    }
}
