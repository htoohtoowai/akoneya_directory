<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryList extends JsonResource
{
    protected $categoryName;

    public function categoryName($value){
        $this->categoryName = $value;
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
            'name' => $this->{$this->categoryName},
            'logo' => $this->image ? getFileUrlFromAkoneyaMedia($this->image) : null,
            'totalContent' => $this->subCategoryCount()
        ];
    }

    public static function collection($resource){
        return new CategoryListCollection($resource);
    }
}
