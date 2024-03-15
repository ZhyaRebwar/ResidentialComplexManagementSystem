<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'age',
        'job_title',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function house(): HasOne
    {
        return $this->hasOne(House::class,'owner_id');
    }


    public function apartment(): HasOne
    {
        return $this->hasOne(Apartment::class, 'owner_id');
    }


    public function house_residency_residents(): HasMany
    {
        return $this->hasMany(HouseResidents::class, 'resident_id');
    }

    public function apartment_residency_residents(): HasMany
    {
        return $this->hasMany(ApartmentResidents::class,'resident_id');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'user_id');
    }

    public function protest(): HasMany
    {
        return $this->hasMany(Protest::class, 'made_by');
    }
}
