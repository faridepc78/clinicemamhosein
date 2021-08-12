<?php


namespace App\Http\View\Composers;


use App\Repositories\SettingRepository;
use Illuminate\View\View;

class SettingComposer
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function compose(View $view)
    {
        $view->with([
            'setting' => $this->settingRepository->show()
        ]);
    }
}
