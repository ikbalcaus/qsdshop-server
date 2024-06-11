<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'gender',
        'description',
        'total_rating',
        'average_rating',
        'brand_id',
        'color_id',
    ];

    public function productSizes(): BelongsToMany
    {
        return $this->belongsToMany(ProductSize::class);
    }

    public function brands(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id')->withTrashed();
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class)->withTrashed();
    }

    public function rating(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function favorite(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function productDiscounts(): BelongsTo
    {
        return $this->belongsTo(ProductDiscount::class, 'product_id', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function productCategories(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class)->withTrashed();
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id')->withTrashed();
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'product_sizes')->withPivot('amount')->withTrashed();
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'product_discount', 'product_id', 'discount_id');
    }
}
