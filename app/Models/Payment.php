<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'student_id',
        'fee_id',
        'installment_id',
        'payment_method_id',
        'amount_paid',
        'payment_date',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
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

    public function installment()
    {
        return $this->belongsTo(TuitionInstallment::class, 'installment_id');
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
