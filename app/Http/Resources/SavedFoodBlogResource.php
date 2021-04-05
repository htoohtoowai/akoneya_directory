<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SavedFoodBlogResource extends JsonResource
{
    
    public function toArray($request)
    {

        switch ($request->header('Content-Language')) {
            case 'mm':
                $title = $this->foodBlog->title_mm;
                break;
            case 'zh':
                $title = $this->foodBlog->title_zh;
                break;
            default:
                $title = $this->foodBlog->title;
                break;
        }

        return [
            'id' => $this->id,
            'foodBlogId' => $this->food_id,
            'title' => $title,
            'category' => new FoodBlogCategoryResource($this->foodBlog->foodBlogCategory),
            'mediaUrl' => $this->foodBlog->media()->first() ? getFileUrlFromAkoneyaMedia($this->foodBlog->media()->first()->media_path) : ""
        ];
    }
}
