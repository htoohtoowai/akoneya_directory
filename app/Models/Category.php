<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table="directory_categories";

    protected $guarded = [];

    public function scopeFilter($query,$filters)
    {
        $filters->apply($query);
    }
}
