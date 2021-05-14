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
        switch ($request->header('Content-Language')) {
            case 'mm':
                $title = $this->title_mm;
                $overview = $this->overview_mm;
                $history = $this->history_mm;
                $check_in_point = $this->check_in_point_mm;

                break;
            case 'zh':
                $title = $this->title_zh;
                $overview = $this->overview_zh;
                $history = $this->history_zh;
                $check_in_point = $this->check_in_point_zh;

                break;
            default:
                $title = $this->title;
                $overview = $this->overview;
                $history = $this->history;
                $check_in_point = $this->check_in_point;
                break;
        }

        return [
            'id' => $this->id,
            'title'=> $title,
            'location' => config('zones.zoneSelections.'.$this->zone_id.'.name') ,
            'photo' => $this->main_image ? getFileUrlFromAkoneyaMedia($this->main_image) : "",
            'overView' => $overview,
            'history' => $history,
            'checkInPoint' => $check_in_point,
            'mediaList' => TravelBlogMediaResource::collection($this->mediaList),
            'isSaved' => $this->isSaved,
       ];
    }
}
