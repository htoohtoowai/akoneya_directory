<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'name' => changeLanguage($request, $this->name, $this->name_mm, $this->name_zh),
            'address' => changeLanguage($request, $this->address, $this->address_mm, $this->address_zh),
            'phone' => explode(",", $this->phone)
        ];
    }
}
