<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentProfessional extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'profession_actuelle',
        'employeur',
        'experience',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
