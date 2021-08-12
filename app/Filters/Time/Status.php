<?php


namespace App\Filters\Time;


use App\Filters\Filter;
use Illuminate\Support\Carbon;

class Status extends Filter
{
    protected function applyFilter($builder)
    {
        $search = request($this->filterName());

        if ($search == 'active') {
            return $builder->where('date', '>=', Carbon::now()->toDateString());
        } elseif ($search == 'not-capacity') {
            return $builder->where('capacity', '=', 0);
        } elseif ($search == 'expire-date') {
            return $builder->where('date', '<', Carbon::now()->toDateString());
        }
    }
}
