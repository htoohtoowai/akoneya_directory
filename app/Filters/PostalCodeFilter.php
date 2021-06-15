<?php

namespace App\Filters;
use App\Models\Township;

class PostalCodeFilter extends Filter
{
    protected $filters = ['zoneId','township'];

    public function zoneId($value)
    {
        return $this->builder->where('zone_id',$value);
    }

    public function township($value)
    {
        $townshipIds = Township::orwhere('township_name', 'LIKE', "%{$value}%")->orwhere('township_name_mm', 'LIKE', "%{$value}%")->orwhere('township_name_zh', 'LIKE', "%{$value}%")->pluck('id');

        return $this->builder->whereIn('directory_township_id',$townshipIds);
    }
}
