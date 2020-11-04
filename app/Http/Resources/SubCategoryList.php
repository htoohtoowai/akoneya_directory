<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryList extends JsonResource
{
    protected $subCategoryName;

    public function subCategoryName($value){
        $this->subCategoryName = $value;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->{$this->subCategoryName},
            'logo' => $this->image,
            'totalContent' => $this->directoryServiceCount()
        ];
    }

    public static function collection($resource){
        return new SubCategoryListCollection($resource);
    }
}
