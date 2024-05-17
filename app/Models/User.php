<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Hasmany;
use Illuminate\Database\Eloquent\Relations\Hasone;


class User extends Model
{
    use HasFactory;

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

    protected $hidden = [
        'password'
    ];

    public function order(): HasMany {
        return $this->hasMany(Order::class);
    }

    public function favorite(): HasOne {
        return $this->hasOne(Favorite::class);
    }

    public function rating(): HasMany {
        return $this->hasMany(Rating::class);
    }
}
