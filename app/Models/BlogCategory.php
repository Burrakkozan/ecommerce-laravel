<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function blogpost(){
        return $this->hasMany(BlogPost::class,'category_id','id');
    }
}
