<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderProductSize extends Model
{
    use HasFactory;
    protected $table='order_product_sizes';

   protected $fillable=[
    'product_size_id',
    'order_id'
   ];

    public function order(): HasMany {
        return $this->hasMany(Order::class);
}

    public function productSize(): HasMany {
        return $this->hasMany(ProductSize::class);
}


}
