<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSize extends Model
{
    use HasFactory;

    protected $table = 'product_sizes';

    protected $fillable = [
        'product_id',
        'size_id'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function sizes()
    {
        return $this->belongsTo(Size::class,'size_id');
    }


    public function product()
    {
        return $this->hasMany(Product::class,'product_id');
    }

    public function size()
    {
        return $this->hasMany(Size::class,'size_id');
    }
}
