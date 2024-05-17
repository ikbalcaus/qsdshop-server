<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discount extends Model
{
    use HasFactory;
    protected $table = "discount";
    protected $fillable = [
        "DiscountName",
        "DiscountValue",
        "ValidFrom",
        "ValidTo"
        ];

    public function productDiscounts():BelongsTo{
        return $this->belongsTo(ProductDiscount::class,'discount_id','id');
    }

}
