<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicYear extends Model
{
    protected $fillable = ['libelle', 'date_debut', 'date_fin', 'statut'];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}

