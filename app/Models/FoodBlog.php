<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodBlog extends Model
{
    protected $table = "food";

    protected $guarded = [];
    
    public function media()
    {
        return $this->hasMany(FoodBlogMedia::class, 'food_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(FoodBlogCategory::class,'category_id','id');
    }

    public function scopeFilter($query,$filters)
    {
        $filters->apply($query);
    }
}
