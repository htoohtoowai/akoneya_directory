<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FoodSavedBlog extends Model
{
    protected $table = "food_saved_blogs";

    protected $guarded = [];

    public $timestamps = false;

    public function foodBlog()
    {
        return $this->belongsTo(FoodBlog::class, 'food_id', 'id');
    }

}
