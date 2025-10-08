<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'type_document',
        'path',
    ];

    /**
     * Relation vers l'étudiant
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
