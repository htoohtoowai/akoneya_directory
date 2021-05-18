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

    public function directoryServiceCount()
    {
    	$directoryService = config("directory_services.codes.$this->service_code");
    	$serviceModelClassName = $directoryService["model"];
        $serviceModel = new $serviceModelClassName();
    	return $serviceModel->where('deleted_status', config('enums.disableDeletedStatus'))->count();
    }
}

