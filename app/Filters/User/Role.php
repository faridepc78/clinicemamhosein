<?php


namespace App\Filters\User;


use App\Filters\Filter;

class Role extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('role', request($this->filterName()));
    }
}
