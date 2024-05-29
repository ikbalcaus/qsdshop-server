<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;


    protected $table = 'favorites';


    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
