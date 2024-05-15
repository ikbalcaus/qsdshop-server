<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $table = 'SizeName';

    protected $fillable = [
        'size'
    ];

    public function productSize(): BelongsTo {
           return $this->belongsTo(ProductSize::class);
    }
}
