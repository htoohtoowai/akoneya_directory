<?php

namespace App\Filters;

class DirectoryServiceFilter extends Filter
{

    protected $filters = ['name', 'zone_id','township_id'];

    public function name($value) 
    {
        return $this->builder->where('name', 'LIKE', "%{$value}%");
    }

    public function zone_id($value) 
    {
        return $this->builder->where('zone_id',$value);
    }

    public function township_id($value) 
    {
        return $this->builder->where('township_id',$value);
    }

}