<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HouseResidents extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_id',
        'resident_id',
    ];

    public function house_residents(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resident_id');
    }

    public function houses(): BelongsTo
    {
        return $this->belongsTo(House::class,'house_id');
    }
}
