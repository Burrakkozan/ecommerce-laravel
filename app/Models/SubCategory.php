<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory,Sluggable;


    protected $table = "sub_categories";

    protected $fillable = [
        'subcategory_name',
        'category_id',
        'slug',
    ];
    public $timestamps = false;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'subcategory_name'
            ]
        ];
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
