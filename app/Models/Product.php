<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'gender',
        'description',
        'total_rating',
        'average_rating',
        'is_favorite',
        'brand_id',
        'color_id',
    ];

    public function productSizes(): BelongsToMany {
        return $this->belongsToMany(ProductSize::class);
    }

    public function brands(): BelongsTo {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function colors(): BelongsTo {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function rating(): HasMany {
        return $this->hasMany(Rating::class);
    }

    public function favorite(): HasMany {
        return $this->hasMany(Favorite::class);
    }

    public function images(): HasMany {
        return $this->hasMany(Image::class);
    }

    public function productCategories(): BelongsTo {
        return $this->belongsTo(ProductCategory::class);
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany(Category::class, 'product_categories','product_id', 'category_id');
    }

}
