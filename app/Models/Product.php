<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory,Sluggable;

    protected $table = 'products';
    protected $guarded = [];

    protected $casts = [
        'hot_deals' => 'boolean',
        'featured' => 'boolean',
        'special_offer' => 'boolean',
        'special_deals' => 'boolean',
        'is_active' => 'boolean',
        'product_color' => 'array',
        'product_size' => 'array',
        'product_qty' => 'integer',
        'alt_image' => 'array',

    ];



    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'product_name'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id','id');
    }


}
