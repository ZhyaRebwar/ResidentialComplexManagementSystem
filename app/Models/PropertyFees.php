<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyFees extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_id',
        'property',
        'start_date',
        'end_date'
    ];
}
