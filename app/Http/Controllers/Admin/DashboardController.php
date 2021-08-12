<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\StatisticsRepository;

class DashboardController extends Controller
{
    private $statisticsRepository;

    public function __construct(StatisticsRepository $statisticsRepository)
    {
        $this->statisticsRepository = $statisticsRepository;
    }

    public function index()
    {
        $getCountExpertises = $this->statisticsRepository->getCountExpertises();
        $getCountUsers = $this->statisticsRepository->getCountUsers();
        $getCountPosts = $this->statisticsRepository->getCountPosts();
        $getCountReserves = $this->statisticsRepository->getCountReserves();

        return view('admin.dashboard.index',
            compact('getCountExpertises', 'getCountUsers',
                'getCountPosts', 'getCountReserves'));
    }
}
