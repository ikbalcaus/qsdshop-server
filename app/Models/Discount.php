<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Discount extends Model
{
    use HasFactory;

    protected $table = "discount";
    protected $fillable = [
        "name",
        "discount",
        "valid_from",
        "valid_to",
        "deleted_at"
    ];

    public function productDiscounts(): BelongsTo
    {
        return $this->belongsTo(ProductDiscount::class, 'discount_id', 'id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_discount', 'discount_id', 'product_id');
    }

    public function brands()
    {
        return $this->belongsTo(Brand::class);
    }

    public function colors()
    {
        return $this->belongsTo(Color::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function sizes()
    {
        return $this->belongsTo(Size::class);
    }
}
