<?php


namespace App\Filters\Reserve\User;


use App\Filters\Filter;

class Search extends Filter
{
    protected function applyFilter($builder)
    {
        $keyword = request($this->filterName());

        if ($keyword != null) {
            return $builder->whereHas('doctor', function ($query) use ($keyword) {
                $query->where('f_name', 'like', '%' . $keyword . '%')
                    ->orWhere('l_name', 'like', '%' . $keyword . '%')
                    ->orWhereRaw("concat(f_name, ' ', l_name) like '%$keyword%' ");
            });
        } else {
            return $builder;
        }
    }
}
