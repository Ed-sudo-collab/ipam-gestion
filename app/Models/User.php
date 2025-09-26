<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * Les champs assignables en masse
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role_id',
        'student_id', // nullable
        'matricule',
        'telephone',
    ];

    /**
     * Les champs à cacher pour les tableaux JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Champs supplémentaires à ajouter aux tableaux JSON
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Les casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relation vers le rôle
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relation vers l'étudiant (nullable)
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
