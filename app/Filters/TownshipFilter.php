<?php

namespace App\Filters;

class TownshipFilter extends Filter
{
    protected $filters = ['township'];

    public function township($value)
    {
        return $this->builder
            ->where(function ($query) use ($value) {
                $query->orwhere('township_name', 'LIKE', "%{$value}%")->orwhere('township_name_mm', 'LIKE', "%{$value}%")->orwhere('township_name_zh', 'LIKE', "%{$value}%");
            });
    }
}
