<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'floor',
        'name',
        'electricity_unit',
        'building_id',
        'owner_id',
    ];

    protected $uniqueKeys = [
        'floor',
        'name', 
        'building_id'
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function apartment_residency_apartment(): HasMany
    {
        return $this->hasMany(ApartmentResidents::class, 'apartment_id');
    }
}
