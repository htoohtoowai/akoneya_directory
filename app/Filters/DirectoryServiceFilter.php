<?php

namespace App\Filters;

class DirectoryServiceFilter extends Filter
{
    protected $filters = ['name', 'zoneId','townshipId'];

    public function name($value)
    {
        return $this->builder->where('name', 'LIKE', "%{$value}%");
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
