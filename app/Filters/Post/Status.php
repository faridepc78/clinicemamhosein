<?php


namespace App\Filters\Post;


use App\Filters\Filter;

class Status extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('status', request($this->filterName()));
    }
}
