<!DOCTYPE html>
<html lang="fa" class="ie8 no-js">
<html lang="fa" class="ie9 no-js">
<html lang="fa">
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description"
          content="درمانگاه شبانه روزی امام حسین (ع)">
    <meta name="keywords"
          content="درمانگاه شبانه روزی امام حسین (ع)">
    <meta name="author" content="info@aftabeshafa.ir">
    <meta http-equiv="content-language" content="Fa">
    <meta name="robots" content="index,follow"/>
    <meta property="og:site_name" content="درمانگاه شبانه روزی امام حسین (ع)">
    <meta property="og:title" content="درمانگاه شبانه روزی امام حسین (ع)">
    <meta property="og:description"
          content="درمانگاه شبانه روزی امام حسین (ع)">
    <meta property="og:type" content="website">
    <meta name="twitter:title" content="درمانگاه شبانه روزی امام حسین (ع)">
    <meta name="theme-color" content="#4096c3"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('site_title')

    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('assets/common/images/logo/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('assets/common/images/logo/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/common/images/logo/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/common/images/logo/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/common/images/logo/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/common/images/logo/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('assets/common/images/logo/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/common/images/logo/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/common/images/logo/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"
          href="{{asset('assets/common/images/logo/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/common/images/logo/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/common/images/logo/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/common/images/logo/favicon-16x16.png')}}">
    <link rel="icon" href="{{asset('assets/common/images/logo/favicon.ico')}}" type="image/x-icon">
    <link rel="manifest" href="{{asset('assets/common/images/logo/manifest.json')}}">

    <link rel="canonical" href="{{route('home')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('assets/frontend/css/layout.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/common/plugins/validation/css/validate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/plugins/slick/slick.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/plugins/slick/slick-theme.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('assets/common/plugins/toast/css/toast.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('assets/frontend/css/custome.css')}}"/>

    @yield('site_css')

</head>

<body>

<div class="pre-header fadeInDown">
    <div class="container">
        <div id="Header_Font" class="row">
            <div class="col-md-12 col-md-12 additional-shop-info">

                <ul class="nav-top list-unstyled list-inline pull-left" itemscope>

                    <li itemprop="name">
                        <a itemprop="url" href="{{route('home')}}"><i
                                class="fa fa-home vertically-align-middel"
                                aria-hidden="true"></i></a>
                        صفحه نخست
                    </li>

                    @auth()

                        <li>
                            <a href="{{route('user_profile')}}" class="user-nav dropdown-toggle"><img width="20px"
                                                                                                      src="{{asset('assets/frontend/images/menu.svg')}}">&nbsp;{{auth()->user()->fullName}}
                            </a>
                        </li>

                        <li>
                            <a href="{{route('user_reserves')}}" class="user-nav dropdown-toggle">لیست نوبت&zwnj;های
                                رزرو شده</a>
                        </li>

                        @if (auth()->user()['role']==\App\Models\User::ADMIN)
                            <li>
                                <a target="_blank" href="{{route('dashboard')}}" class="user-nav dropdown-toggle">پنل مدیریت</a>
                            </li>
                        @elseif(auth()->user()['role']==\App\Models\User::DOCTOR)
                            <li>
                                <a target="_blank" href="{{route('doctor_dashboard')}}" class="user-nav dropdown-toggle">پنل دکتر</a>
                            </li>
                        @endif

                        <li>
                            <a href="{{route('logout')}}" class="user-nav">خروج</a>
                        </li>

                    @else

                        <li itemprop="name">
                            <a itemprop="url" href="{{route('login')}}" class="user-nav">ورود</a>
                        </li>

                        <li itemprop="name">
                            <a itemprop="url" href="{{route('register')}}" class="user-nav ">ثبت نام</a>
                        </li>

                    @endauth

                    <li>
                        <a href="{{route('blog')}}" class="user-nav dropdown-toggle">وبلاگ</a>
                    </li>

                    <li>
                        <a href="{{route('blog')}}" class="user-nav dropdown-toggle">درباره ما</a>
                    </li>

                    <li>
                        <a href="{{route('support')}}" class="user-nav dropdown-toggle">پشتیبانی</a>
                    </li>

                    <li>
                        <a href="{{route('terms-and-conditions')}}" class="user-nav dropdown-toggle">قوانین</a>
                    </li>

                </ul>
            </div>
        </div>

    </div>

</div>

<div class="center center-block text-center">
    <img src="{{asset('assets/frontend/images/header.png')}}" alt="header">
</div>
