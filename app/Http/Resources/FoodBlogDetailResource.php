<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodBlogDetailResource extends JsonResource
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
            'category' => new FoodBlogCategoryResource($this->foodBlogCategory),
            'ingredient' => $this->ingredients,
            'direction' => $this->directions,
            'note' => $this->note,
            'credit' => $this->credit,
            'mediaList' => FoodBlogMediaResource::collection($this->mediaList),
            'isSaved' => $this->isSaved,
       ];
    }
}
