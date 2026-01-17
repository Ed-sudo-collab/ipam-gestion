<?php

namespace App\Events;

use App\Models\Student;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InscriptionValidee
{
    use Dispatchable, SerializesModels;

    public Student $student;

    /**
     * Crée un nouvel événement
     *
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }
}
