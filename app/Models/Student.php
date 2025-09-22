<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

   protected $fillable = [
        'user_id','matricule','nom','prenom','date_naissance','lieu_naissance',
        'sexe','telephone','situation_matrimoniale','nombre_enfants',
        'adresse','email','telephone_parent','statut_id'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statut()
    {
        return $this->belongsTo(StudentStatut::class, 'statut_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function academic()
    {
        return $this->hasOne(StudentAcademic::class);
    }

    public function professional()
    {
        return $this->hasOne(StudentProfessional::class);
    }

    public function documents()
    {
        return $this->hasMany(StudentDocument::class);
    }
}
