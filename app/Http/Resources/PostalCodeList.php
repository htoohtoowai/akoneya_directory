<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostalCodeList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'township' => changeLanguage($request, $this->township_name, $this->township_name_mm, $this->township_name_zh),
            'area' => changeLanguage($request, $this->area_name, $this->area_name_mm, $this->area_name_zh),
            'postalCode' => $this->area_postal_code
        ];
    }
}
