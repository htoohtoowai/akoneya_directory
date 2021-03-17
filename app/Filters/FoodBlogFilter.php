<?php

namespace App\Filters;

class FoodBlogFilter extends Filter
{
    protected $filters = ['title', 'category'];

    public function title($value)
    {
        return $this->builder->where('title', 'LIKE', "%{$value}%");
    }

    public function category($value)
    {
        return $this->builder->where('category_id', $value);
    }
}
