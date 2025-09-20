<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    protected $fillable = [
        'student_id','academic_year_id','program_id','level_id',
        'mode_etude','statut','date_inscription'
    ];

    public function student() { return $this->belongsTo(Student::class); }
    public function academicYear() { return $this->belongsTo(AcademicYear::class); }
    public function program() { return $this->belongsTo(Program::class); }
    public function level() { return $this->belongsTo(Level::class); }
}

