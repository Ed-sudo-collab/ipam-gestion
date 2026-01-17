<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TuitionInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tuition_fee_id',
        'label',
        'amount',
        'due_date',
    ];

    protected $casts = [
        'amount'   => 'decimal:2',
        'due_date' => 'date',
    ];

    /* ==========================
       RELATIONS
    ========================== */

    public function tuitionFee()
    {
        return $this->belongsTo(TuitionFee::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'installment_id');
    }

    // 🔹 Nouvelle relation
    public function paymentAllocations()
    {
        return $this->hasMany(PaymentAllocation::class, 'installment_id');
    }











    public function getRemainingAmountForStudent(int $studentId): float
    {
        $paid = $this->paymentAllocations()
            ->whereHas('payment', fn ($q) =>
                $q->where('student_id', $studentId)
            )
            ->sum('amount');

        return max(0, $this->amount - $paid);
    }

}
