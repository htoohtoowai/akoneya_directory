<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SavedFoodBlogResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'foodBlogId' => $this->food_id,
            'title' => $this->foodBlog->title,
            'category' => new FoodBlogCategoryResource($this->foodBlog->foodBlogCategory),
            'mediaUrl' => $this->foodBlog->media()->first() ? getFileUrlFromAkoneyaMedia($this->foodBlog->media()->first()->media_path) : ""
        ];
    }
}
