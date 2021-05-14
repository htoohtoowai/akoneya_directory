<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SavedBlogList extends JsonResource
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
                $title = $this->travelBlogInfo->title_mm;
                break;
            case 'zh':
                $title = $this->travelBlogInfo->title_zh;
                break;
            default:
                $title = $this->travelBlogInfo->title;
                break;
        }
        return [
            'savedBlogId' => $this->id,
            'blogId' => $this->travelBlogInfo->id,
            'title' => $title,
            'location' => config('zones.zoneSelections.'.$this->travelBlogInfo->zone_id.'.name') ,
            'photo' => $this->travelBlogInfo->main_image ? getFileUrlFromAkoneyaMedia($this->travelBlogInfo->main_image) : "",
        ];
    }
}
