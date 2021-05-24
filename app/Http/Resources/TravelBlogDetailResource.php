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
            'title'=> changeLanguage($request, $this->title, $this->title_mm, $this->title_zh),
            'location' => config('zones.zoneSelections.'.$this->zone_id.'.name') ,
            'photo' => $this->main_image ? getFileUrlFromAkoneyaMedia($this->main_image) : "",
            'overView' => changeLanguage($request, $this->overview, $this->overview_mm, $this->overview_zh),
            'history' => changeLanguage($request, $this->history, $this->history_mm, $this->history_zh),
            'checkInPoint' => changeLanguage($request, $this->check_in_point, $this->check_in_point_mm, $this->check_in_point_zh),
            'credit'=>$this->credit ?? "",
            'mediaList' => TravelBlogMediaResource::collection($this->mediaList),
            'isSaved' => $this->isSaved,
       ];
    }
}
