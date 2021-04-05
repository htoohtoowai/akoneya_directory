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

        switch ($request->header('Content-Language')) {
            case 'mm':
                $title = $this->title_mm;
                $ingredient = $this->ingredients_mm;
                $direction = $this->directions_mm;
                $note = $this->note_mm;

                break;
            case 'zh':
                $title = $this->title_zh;
                $ingredient = $this->ingredients_zh;
                $direction = $this->directions_zh;
                $note = $this->note_zh;

                break;
            default:
                $title = $this->title;
                $ingredient = $this->ingredients;
                $direction = $this->directions;
                $note = $this->note;
                break;
        }

        return [
            'id' => $this->id,
            'title'=> $title,
            'category' => new FoodBlogCategoryResource($this->foodBlogCategory),
            'ingredient' => $ingredient,
            'direction' => $direction,
            'note' => $note,
            'credit' => $this->credit,
            'mediaList' => FoodBlogMediaResource::collection($this->mediaList),
            'isSaved' => $this->isSaved,
       ];
    }
}
