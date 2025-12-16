<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TuitionFee extends Model
{
    use HasFactory;

    /**
     * Champs autorisés en écriture
     */
    protected $fillable = [
        'level_id',
        'total_amount',
        'installments',
    ];

    /**
     * Casts automatiques
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'installments' => 'integer',
    ];

    /* =======================
     |        RELATIONS
     |======================= */

    /**
     * Un TuitionFee appartient à un Niveau
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Un TuitionFee possède plusieurs échéances
     */
    public function installments()
    {
        return $this->hasMany(TuitionInstallment::class);
    }

    /**
     * Un TuitionFee est lié à plusieurs inscriptions
     * (indirectement via level_id)
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'level_id', 'level_id');
    }

    /* =======================
     |     LOGIQUE MÉTIER
     |======================= */

    /**
     * Montant d'une échéance
     */
    public function installmentAmount(): float
    {
        if ($this->installments <= 0) {
            return 0;
        }

        return round($this->total_amount / $this->installments, 2);
    }

    /**
     * Vérifie si les échéances sont générées
     */
    public function hasInstallments(): bool
    {
        return $this->installments()->count() > 0;
    }
}
