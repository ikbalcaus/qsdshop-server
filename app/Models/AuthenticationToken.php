<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthenticationToken extends Model
{
    use HasFactory;

    protected $table = 'authentication_token';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
