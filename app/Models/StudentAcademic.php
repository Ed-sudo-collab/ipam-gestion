<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentAcademic extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'dernier_diplome',
        'etablissement',
        'annee_obtention',
        'mention',
        'path_diplome',
        'path_releves',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
