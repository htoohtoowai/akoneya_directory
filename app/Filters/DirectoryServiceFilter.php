<?php

namespace App\Filters;

class DirectoryServiceFilter extends Filter
{
    protected $filters = ['name', 'zoneId','townshipId'];

    public function name($value)
    {
        return $this->builder
            ->where(function ($query) use ($value) {
                $query->orwhere('name', 'LIKE', "%{$value}%")->orwhere('name_mm', 'LIKE', "%{$value}%")->orwhere('name_zh', 'LIKE', "%{$value}%");
            });
    }

    public function zoneId($value)
    {
        return $this->builder->where('zone_id', $value);
    }

    public function townshipId($value)
    {
        return $this->builder->where('township_id', $value);
    }
}
