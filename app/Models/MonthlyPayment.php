<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount_paid',
        'payment_date',
        'payment_method',
        'is_paid',
        'property_fee_id',
        'paid_by',
    ];
}
