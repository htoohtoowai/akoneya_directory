<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodBlogCategory extends Model
{
    protected $table = "food_categories";

    protected $guarded = [];
    
    public $timestamps = false;
}
