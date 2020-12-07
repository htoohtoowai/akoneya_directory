<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryListCollection extends ResourceCollection
{
    use BaseResourceCollection;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    protected $categoryName;

    public function categoryName($value){
        $this->categoryName = $value;
        return $this;
    }

    public function toArray($request)
    {
        return [
            'categories' => $this->collection->map(function(CategoryList $resource) use($request){
                    return $resource->categoryName($this->categoryName)->toArray($request);
            }),
            'pagination' => $this->pagination
        ];    
    }
    
}
