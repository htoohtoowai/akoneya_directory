<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryListCollection extends ResourceCollection
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
