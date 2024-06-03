<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $table ='orders';

protected $fillable=[
    'full_name',
    'payment_method_id',
    'transaction_id',
    'address',
    'city',
    'zip',
    'phone',
    'user_id',
    'total_price',
    'status',
    'comment'
];
public function user():BelongsTo{
    return $this->belongsTo(User::class);
}
public function orderProductSizes():HasMany{
    return $this->hasMany(OrderProductSize::class);
}
public function orderProductSize():BelongsTo{
    return $this->belongsTo(OrderProductSize::class);
}
}
