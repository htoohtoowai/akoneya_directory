<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubCategoryListCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private $pagination, $nextPage;

    protected $categoryName;

    public function __construct($resource)
    {   
        if(($resource->currentPage() + 1) <= $resource->lastPage()){
            $this->nextPage = $resource->currentPage() + 1;
        }
        else{
            $this->nextPage = null;
        }

        $this->pagination = [
            'perPage' => $resource->perPage(),
            'currentPage' => $resource->currentPage(),
            'nextPage' => $this->nextPage
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }

    public function subCategoryName($value){
        $this->subCategoryName = $value;
        return $this;
    }

    public function toArray($request)
    {
        return [
            'subCategories' => $this->collection->map(function(SubCategoryList $resource) use($request){
                    return $resource->subCategoryName($this->subCategoryName)->toArray($request);
            }),
            'pagination' => $this->pagination
        ];    
    }
}
