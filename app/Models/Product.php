<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'ar_name',
        'en_name',
        'category_id', // Reference to the category
        'price',
        'ar_description',
        'en_description',
        'quantity',
        'ar_features',
        'en_features',
        'ar_manufacturer',
        'en_manufacturer',
        'images',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ar_features' => 'array',
        'en_features' => 'array',
        'images' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
