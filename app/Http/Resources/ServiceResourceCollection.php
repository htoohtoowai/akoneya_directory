<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private $pagination, $nextPage, $resultCount;

    public function __construct($resource,$resultCount)
    {   
        $this->resultCount = $resultCount;

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

    public function toArray($request)
    {
        return [
            'resultCount' => $this->resultCount,
            'data' => $this->collection,
            'pagination' => $this->pagination
        ];    
    }
}
