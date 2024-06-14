<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    protected $table = 'product_discount';

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function discount()
    {
        return $this->hasMany(Discount::class);
    }
}
