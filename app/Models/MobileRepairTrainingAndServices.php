<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileRepairTrainingAndServices extends Model
{
    protected $table = 'directory_mobile_repair_training_and_services';

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
