<?php

namespace App\Filters;

class FoodBlogFilter extends Filter
{
    protected $filters = ['title', 'categoryId'];

    public function title($value)
    {
        return $this->builder
            ->where(function ($query) use ($value) {
                $query->orwhere('title', 'LIKE', "%{$value}%")->orwhere('title_mm', 'LIKE', "%{$value}%")->orwhere('title_zh', 'LIKE', "%{$value}%");
            });
    }

    public function categoryId($value)
    {
        return $this->builder->where('category_id', $value);
    }
}
