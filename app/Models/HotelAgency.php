<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelAgency extends Model
{
    protected $table = 'directory_hotel_agencies';

    protected $guarded = [];

    public $timestamps = false;

    public function scopeFilter($query,$filters)
    { 
        $filters->apply($query);
    }

    public function township()
    {
    	return $this->belongsTo(Township::class,'township_id','id');
    }
}
