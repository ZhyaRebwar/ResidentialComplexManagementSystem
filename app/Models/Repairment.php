<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Repairment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'repairment_components',
        'description',
        'picture',
        'status',
        'request_date',
        'expiration_date',
        'completed_user',
        'requested_by',
        'accepted_by',
        'location'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
