<?php


namespace App\Filters\User;


use App\Filters\Filter;

class Search extends Filter
{
    protected function applyFilter($builder)
    {
        $keyword = request($this->filterName());

        if ($keyword != null) {

            return $builder->where('f_name', 'like', '%' . $keyword . '%')
                ->orWhere('l_name', 'like', '%' . $keyword . '%')
                ->orWhereRaw("concat(f_name, ' ', l_name) like '%$keyword%' ")
                ->orWhere('national_code', $keyword)
                ->orWhere('mobile', $keyword);
        } else {
            return $builder;
        }
    }
}
