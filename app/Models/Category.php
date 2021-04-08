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

    public function subCategories()
    {
    	return $this->hasMany(SubCategory::class,'category_id','id');
    }

    public function subCategoryCount()
    {
    	return $this->subCategories()->where('publish_status', config('enums.enablePublishStatus'))->count();
    }
}
