<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    protected $table = 'directory_townships';

    protected $guarded = [];

    public $timestamps = false;

    public function scopeFilter($query,$filters)
    {
        $filters->apply($query);
    }
}
