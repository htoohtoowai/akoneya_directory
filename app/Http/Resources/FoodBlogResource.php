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
        switch ($request->header('Content-Language')) {
            case 'mm':
                $title = $this->title_mm;
                break;
            case 'zh':
                $title = $this->title_zh;
                break;
            default:
                $title = $this->title;
                break;
        }

        return [
            'id' => $this->id,
            'title' => $title,
            'category' => new FoodBlogCategoryResource($this->foodBlogCategory),
            'mediaUrl' =>  $this->media()->first() ? getFileUrlFromAkoneyaMedia($this->media()->first()->media_path) : "",
            'isSaved' => $this->isSaved,
        ];
    }
}
