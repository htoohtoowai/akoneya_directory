<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryListCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private $pagination, $nextPage;

    public function __construct($resource, $paginator)
    {   
        if(($paginator->currentPage() + 1) <= $paginator->lastPage()){
            $this->nextPage = $paginator->currentPage() + 1;
        }
        else{
            $this->nextPage = null;
        }

        $this->pagination = [
            'perPage' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
            'nextPage' => $this->nextPage
        ];

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
                'categories' => $this->collection,
                'pagination' => $this->pagination
            ];    
    }
    
}
