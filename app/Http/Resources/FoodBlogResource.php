<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodBlogResource extends JsonResource
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
            'title' => $this->title,
            'category' => new FoodBlogCategoryResource($this->foodBlogCategory),
            'mediaUrl' =>  $this->media()->first() ? getFileUrlFromAkoneyaMedia($this->media()->first()->media_path) : "",
            'isSaved' => $this->isSaved,
        ];
    }
}
