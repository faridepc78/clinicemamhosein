<?php


namespace App\Filters\Time;


use App\Filters\Filter;
use Illuminate\Support\Carbon;

class Status extends Filter
{
    protected function applyFilter($builder)
    {
        $keyword = request($this->filterName());

        if ($keyword == 'active') {
            return $builder->where('date', '>=', Carbon::now()->toDateString());
        } elseif ($keyword == 'not-capacity') {
            return $builder->where('capacity', '=', 0);
        } elseif ($keyword == 'expire-date') {
            return $builder->where('date', '<', Carbon::now()->toDateString());
        }
    }
}
