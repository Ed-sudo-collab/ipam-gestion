<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class TuitionInstallment extends Model
{
    use HasFactory;

    protected $table = 'tuition_installments';

    /**
     * Champs autorisés en écriture
     */
    protected $fillable = [
        'tuition_fee_id',
        'label',
        'amount',
        'due_date',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'amount'   => 'decimal:2',
        'due_date' => 'date',
    ];

    /* =====================================================
     * RELATIONS
     * ===================================================== */

    /**
     * Une échéance appartient à un tuition fee
     */
    public function tuitionFee()
    {
        return $this->belongsTo(TuitionFee::class);
    }

    /**
     * Une échéance peut avoir plusieurs paiements
     * (paiement partiel ou complet selon ta logique)
     */


    /* =====================================================
     * LOGIQUE MÉTIER
     * ===================================================== */

    /**
     * Montant total payé pour cette échéance
     */


    /**
     * Solde restant à payer
     */


    /**
     * L’échéance est-elle totalement payée ?
     */


    /**
     * L’échéance est-elle en retard ?
     */


    /**
     * Statut lisible (utile pour UI)
     */


    /* =====================================================
     * SCOPES (REQUÊTES UTILES)
     * ===================================================== */

    /**
     * Échéances en retard
     */
    public function scopeOverdue($query)
    {
        return $query->whereDate('due_date', '<', now());
    }

    /**
     * Échéances non soldées
     */
    public function scopeUnpaid($query)
    {
        return $query->whereDoesntHave('payments')
                     ->orWhereHas('payments', function ($q) {
                         $q->havingRaw('SUM(amount_paid) < tuition_installments.amount');
                     });
    }
}
