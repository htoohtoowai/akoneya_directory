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

    public function toArray($request)
    {
        return [
            'resultCount' => $this->total(),
            'data' => $this->collection,
            'pagination' => $this->pagination
        ];    
    }
}
