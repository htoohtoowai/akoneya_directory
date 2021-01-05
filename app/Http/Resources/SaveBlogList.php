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
        return [
            'savedBlogId' => $this->id,
            'blogId' => $this->travelBlogInfo->id,
            'title' => $this->travelBlogInfo->title,
            'photo' => $this->main_image ? getFileUrlFromAkoneyaMedia($this->main_image) : "",
        ];
    }
}
