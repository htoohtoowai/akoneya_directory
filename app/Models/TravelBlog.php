<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelBlog extends Model
{
    protected $table = 'travel_blogs';

    protected $guarded = [];

    public $timestamps = false;

    public function scopeFilter($query,$filters)
    {
        $filters->apply($query);
    }
}
