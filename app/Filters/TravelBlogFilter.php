<?php

namespace App\Filters;

class TravelBlogFilter extends Filter
{
    protected $filters = ['title', 'location'];

    public function title($value)
    {
        return $this->builder->where('title', 'LIKE', "%{$value}%");
    }

    public function location($value)
    {
        return $this->builder->where('zone_id', $value);
    }
}
