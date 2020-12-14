<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubCategoryListCollection extends ResourceCollection
{
    use BaseResourceCollection;

    protected $categoryName;

    public function subCategoryName($value)
    {
        $this->subCategoryName = $value;
        return $this;
    }

    public function toArray($request)
    {
        return [
            'subCategories' => $this->collection->map(function (SubCategoryList $resource) use ($request) {
                return $resource->subCategoryName($this->subCategoryName)->toArray($request);
            }),
            'pagination' => $this->pagination
        ];
    }
}
