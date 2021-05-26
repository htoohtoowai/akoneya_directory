<?php

namespace App\Filters;

class TravelBlogFilter extends Filter
{
    protected $filters = ['title', 'location'];

    public function title($value)
    {
        return $this->builder
            ->where(function ($query) use ($value) {
                $query->orwhere('title', 'LIKE', "%{$value}%")->orwhere('title_mm', 'LIKE', "%{$value}%")->orwhere('title_zh', 'LIKE', "%{$value}%");
            });
    }

    public function location($value)
    {
        return $this->builder->where('zone_id', $value);
    }
}
