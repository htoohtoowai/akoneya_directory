<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TravelBlogDetailResource extends JsonResource
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
            'title'=> $this->title,
            'location' => config('zones.zoneSelections.'.$this->zone_id.'.name') ,
            'photo' => $this->main_image ? getFileUrlFromAkoneyaMedia($this->main_image) : "",
            'overView' => $this->overview,
            'history' => $this->history,
            'checkInPoint' => $this->check_in_point,
            'mediaList' => TravelBlogMediaResource::collection($this->mediaList),
            'isSaved' => $this->isSaved,
       ];
    }
}
