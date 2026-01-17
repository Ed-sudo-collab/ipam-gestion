<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    protected $fillable = [
        'student_id',
        'fee_id',
        'payment_method_id',
        'total_amount',
        'payment_date',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount_paid'  => 'decimal:2',
    ];

    /* ===========================
     * RELATIONS
     * =========================== */

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function tuitionFee()
    {
        return $this->belongsTo(TuitionFee::class, 'fee_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Répartition du paiement sur les échéances
     */
    public function allocations(): HasMany
    {
        return $this->hasMany(PaymentAllocation::class);
    }

    /* ===========================
     * MÉTHODES MÉTIER
     * =========================== */

    public function isFullyAllocated(): bool
    {
        return $this->allocations->sum('amount') >= $this->amount_paid;
    }





}
