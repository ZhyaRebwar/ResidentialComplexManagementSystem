<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApartmentResidents extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartment_id',
        'resident_id',
    ];
    
    public function apartment_residents(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resident_id');
    }

    public function apartments(): BelongsTo
    {
        return $this->belongsTo(Apartment::class,'apartment_id');
    }

}
