<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table="directory_subcategories";

    protected $guarded = [];

    public function scopeFilter($query,$filters)
    {
        $filters->apply($query);
    }

}

