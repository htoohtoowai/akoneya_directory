<?php

namespace App\Filters;

class TownshipFilter extends Filter
{
    protected $filters = ['township'];

    public function township($value)
    {
        return $this->builder->where('township_name', 'LIKE', "%{$value}%");
    }
}
