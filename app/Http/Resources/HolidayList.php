<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HolidayList extends JsonResource
{
    protected $descriptionName;

    public function descriptionName($value)
    {
        $this->descriptionName = $value;
        return $this;
    }

    public function toArray($request)
    {
        return [
            'date' => $this->date,
            'description' =>  $this->{$this->descriptionName}
        ];
    }

    public static function collection($resource){
        return new HolidayListCollection($resource);
    }
}