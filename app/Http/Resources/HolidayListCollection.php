<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HolidayListCollection extends ResourceCollection
{
    protected $descriptionName;

    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    public function descriptionName($value)
    {
        $this->descriptionName = $value;
        return $this;
    }

    public function toArray($request)
    {
        return [
            'holidays' => $this->collection->map(function(HolidayList $resource) use($request){
                    return $resource->descriptionName($this->descriptionName)->toArray($request);
            })
        ];    
    }
}