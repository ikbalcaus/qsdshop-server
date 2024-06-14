<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidationKey extends Model
{
    use HasFactory;

    protected $table = 'validation_keys';
    protected $fillable = [
        'user_id',
        'validationKey',
        'expires_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
