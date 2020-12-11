<?php

namespace App\Http\Resources;

trait BaseResourceCollection
{
    private $pagination;
    private $nextPage;

    public function __construct($resource, $nextId)
    {
        // if(($resource->currentPage() + 1) <= $resource->lastPage()){
        //     $this->nextPage = $resource->currentPage() + 1;
        // }
        // else{
        //     $this->nextPage = null;
        // }

        // $this->pagination = [
        //     'perPage' => $resource->perPage(),
        //     'currentPage' => $resource->currentPage(),
        //     'nextPage' => $this->nextPage
        // ];
       
        // // $resource = $resource->getCollection();

        // parent::__construct($resource);
        $this->nextId = $nextId;
    
        $this->pagination = [
            'nextId' => $this->nextId
        ];

        parent::__construct($resource);
    }
    
}
