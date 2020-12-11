<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceResourceCollection extends ResourceCollection
{
    use BaseResourceCollection;
   
    public function toArray($request)
    {
        return [
            'resultCount' => count($this->collection),
            'data' => $this->collection,
            'pagination' => $this->pagination
        ];
    }
}
