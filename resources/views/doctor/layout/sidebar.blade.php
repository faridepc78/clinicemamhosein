<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{asset('assets/common/images/logo/favicon-96x96.png')}}" alt="Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"
              style="font-size: 9.5px;font-weight: bold">پنل دکتر درمانگاه شبانه روزی امام حسین (ع)</span>
    </a>

    <div class="sidebar">
        <div>

            @if (auth()->user()['role']==\App\Models\User::DOCTOR)

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{auth()->user()->getProfileAttribute()}}"
                             class="img-circle elevation-2" alt="Profile">
                    </div>
                    <div class="info">
                        <a href="javascript:void(0)" class="d-block">{{auth()->user()->getFullNameAttribute()}}</a>
                    </div>
                </div>

            @elseif(auth()->user()['role']==\App\Models\User::CLERK)

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{$doctor->getProfileAttribute()}}"
                             class="img-circle elevation-2" alt="Profile">
                    </div>
                    <div class="info">
                        <a href="javascript:void(0)" class="d-block">{{$doctor->getFullNameAttribute()}}</a>
                    </div>
                </div>

            @endif

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <li class="nav-item">
                        <a target="_blank" href="{{ route('home') }}"
                           class="nav-link">
                            <i class="nav-icon fa fa-home"></i>
                            <p>
                                خانه
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('doctor_dashboard') }}"
                           class="nav-link {{ request()->routeIs('doctor_dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                داشبورد
                            </p>
                        </a>
                    </li>

                    @can('checkDoctor',[\App\Models\User::class,auth()->id()])
                        <li class="nav-item">
                            <a href="{{ route('doctor_profile') }}"
                               class="nav-link {{ request()->routeIs('doctor_profile') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    پروفایل
                                </p>
                            </a>
                        </li>
                    @endcan

                    <li class="nav-item has-treeview {{ request()->routeIs(['gallery.index']) ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs(['gallery.index']) ? 'active' : '' }}">
                            <i class="nav-icon fa fa-image"></i>
                            <p>
                                گالری
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('gallery.index') }}"
                                   class="nav-link {{ request()->routeIs(['gallery.index']) ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>مدیریت گالری</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->routeIs(['times.index',
'times.create',
'times.edit']) ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs(['times.index',
'times.create',
'times.edit']) ? 'active' : '' }}">
                            <i class="nav-icon fa fa-clock-o"></i>
                            <p>
                                زمان ها
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('times.index') }}"
                                   class="nav-link {{ request()->routeIs(['times.index']) ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>مدیریت زمان ها</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('times.create') }}"
                                   class="nav-link {{ request()->routeIs('times.create') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>ایجاد زمان ها</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->routeIs(['reserves.index']) ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs(['reserves.index']) ? 'active' : '' }}">
                            <i class="nav-icon fa fa-database"></i>
                            <p>
                                نوبت ها
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('reserves.index') }}"
                                   class="nav-link {{ request()->routeIs(['reserves.index']) ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>مدیریت نوبت ها</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->routeIs(['questions.index','questions.details']) ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs(['questions.index','questions.details']) ? 'active' : '' }}">
                            <i class="nav-icon fa fa-question"></i>
                            <p>
                                پرسش ها
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('questions.index') }}"
                                   class="nav-link {{ request()->routeIs(['questions.index','questions.details']) ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>مدیریت پرسش ها</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">

                        <a href="{{route('logout')}}"
                           class="nav-link">
                            <i class="nav-icon fa fa-close"></i>
                            <p>
                                خروج
                                <i class="fa right"></i>
                            </p>
                        </a>

                    </li>

                </ul>
            </nav>

        </div>
    </div>

</aside>
