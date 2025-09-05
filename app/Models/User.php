<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, HasRoles, SoftDeletes;

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'nom_utilisateur',
        'email',
        'password',           // ✅ correspond bien à ta colonne
        'type_utilisateur',
        'statut',
        'date_creation',
        'dernier_login',
    ];

    protected $hidden = [
        'password',           // ✅ colonne correcte
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_creation' => 'datetime',
        'dernier_login' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $attributes = [
        'statut' => 'ACTIF',
        'type_utilisateur' => 'INTERNE',
    ];

    /**
     * Mutateur pour hacher automatiquement le mot de passe
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = bcrypt($value);
        }
    }



}



