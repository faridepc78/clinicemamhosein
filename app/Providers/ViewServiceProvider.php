<?php

namespace App\Providers;

use App\Http\View\Composers\BlogComposer;
use App\Http\View\Composers\DoctorComposer;
use App\Http\View\Composers\SettingComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer(
            [
                'site.blog.index',
                'site.blog.search.index',
                'site.blog.category.index',
                'site.blog.post.index'
            ], BlogComposer::class);

        View::composer('doctor.layout.sidebar', DoctorComposer::class);

        View::composer(
            [
                'site.layout.footer',
                'site.terms-and-conditions.index',
                'site.about-us.index',
                'site.support.index'
            ], SettingComposer::class);
    }
}
