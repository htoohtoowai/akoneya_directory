<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodBlogCategoryResource extends JsonResource
{
    public function toArray($request)
    {

        switch ($request->header('Content-Language')) {
            case 'mm':
                $categoryName = $this->name_mm;
                break;
            case 'zh':
                $categoryName = $this->name_zh;
                break;
            default:
                $categoryName = $this->name;
                break;
        }

        return [
          
                'id' => $this->id,
                'name' => $categoryName
        ];
    }
}
