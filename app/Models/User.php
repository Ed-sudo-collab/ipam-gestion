<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

// Ajouter Spatie Permission
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, HasRoles, SoftDeletes;

    // Si tu veux utiliser le même nom de PK que ta table SQL
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    /**
     * Les attributs assignables en masse
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nom_utilisateur',
        'email',
        'password',
        'type_utilisateur',
        'statut',
        'dernier_login',
        'date_creation',
    ];

    /**
     * Les attributs cachés pour la sérialisation
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Les attributs à ajouter automatiquement au tableau
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Casts des attributs
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dernier_login' => 'datetime',
        'date_creation' => 'datetime',
        'deleted_at' => 'datetime',
        'password' => 'hashed',
    ];
}
