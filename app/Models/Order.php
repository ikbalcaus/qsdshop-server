<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table ='orders';

protected $fillable=[
    'address',
    'city',
    'zip',
    'phone',
    'transaction_id',
    'user_id',
    'total_price',
];
public function user():BelongsTo{
    return this->belongsTo(User::class);
}
public function orderProductSize():HasMany{
    return $this->hasMany(OrderProductSize::class);
}

}
