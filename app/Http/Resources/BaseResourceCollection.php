<?php

namespace App\Http\Resources;

trait BaseResourceCollection
{
    private $pagination;
    private $nextPage;
    private $totalResultCount;

    public function __construct($resource, $nextId, $totalResultCount = 0)
    {
        $this->nextId = $nextId;
        $this->totalResultCount = $totalResultCount;

        $this->pagination = [
            'nextId' => $this->nextId
        ];

        parent::__construct($resource);
    }
}
