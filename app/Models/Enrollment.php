<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'academic_year_id',
        'program_id',
        'level_id',
        'mode_etude',
        'statut',
        'date_inscription'
    ];

    protected $casts = [
        'date_inscription' => 'datetime',
    ];

    /* ======= RELATIONS ======= */

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /* ======= LOGIQUE MÉTIER (optionnel, UML) ======= */

    public function validateEnrollment()
    {
        $this->update(['statut' => 'validee']);
    }


    public function cancel()
    {
        $this->statut = 'CANCELLED';
        $this->save();
    }

    public function isValid()
    {
        return $this->statut === 'VALID';
    }
}
