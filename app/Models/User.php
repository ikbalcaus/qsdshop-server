<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Hasmany;
use Illuminate\Database\Eloquent\Relations\Hasone;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'role',
        'status',
        'password',
        'city',
        'address',
        'zip_code',
        'phone'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (is_null($user->role)) {
                $user->role = 3;
            }
            if (is_null($user->status)) {
                $user->status = true;
            }
        });
    }

    protected $hidden = [
        'password'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function favorite(): HasOne
    {
        return $this->hasOne(Favorite::class);
    }

    public function rating(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
