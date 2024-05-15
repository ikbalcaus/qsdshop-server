<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    use HasFactory;
    protected $table ='colors';
    protected $fillable=[
        'color_name',
        'hex_code'
    ];
    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
