<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceResourceCollection extends ResourceCollection
{
    use BaseResourceCollection;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private $resultCount;

    public function toArray($request)
    {
        return [
            'resultCount' => $this->resultCount,
            'data' => $this->collection,
            'pagination' => $this->pagination
        ];    
    }
}
