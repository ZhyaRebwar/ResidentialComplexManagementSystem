<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Protest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'compliant',
        'picture',
        'status',
        'location',
        'made_by',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'made_by');
    }
}
