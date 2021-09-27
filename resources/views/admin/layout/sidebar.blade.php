<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{asset('assets/common/images/logo/favicon-96x96.png')}}" alt="Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"
              style="font-size: 9.5px;font-weight: bold">پنل مدیریت درمانگاه شبانه روزی امام حسین (ع)</span>
    </a>

    <div class="sidebar">
        <div>

            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{auth()->user()->getProfileAttribute()}}"
                         class="img-circle elevation-2" alt="Profile">
                </div>
                <div class="info">
                    <a href="{{route('profile')}}" class="d-block">{{auth()->user()->getFullNameAttribute()}}</a>
                </div>
            </div>

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
                        <a href="{{ route('dashboard') }}"
                           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                داشبورد
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('profile') }}"
                           class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                پروفایل
                            </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview {{ request()->routeIs(['expertises.index',
'expertises.create',
'expertises.edit']) ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs(['expertises.index',
'expertises.create',
'expertises.edit']) ? 'active' : '' }}">
                            <i class="nav-icon fa fa-database"></i>
                            <p>
                                تخصص ها
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('expertises.index') }}"
                                   class="nav-link {{ request()->routeIs(['expertises.index']) ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>مدیریت تخصص ها</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('expertises.create') }}"
                                   class="nav-link {{ request()->routeIs('expertises.create') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>ایجاد تخصص ها</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->routeIs(['users.index',
'users.create',
'users.edit',
'management_doctor',
'management_doctor_about',
'management_doctor_gallery',
'management_doctor_times_index',
'management_doctor_times_create',
'management_doctor_times_edit',
'management_doctor_reserves_index']) ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs(['users.index',
'users.create',
'users.edit',
'management_doctor',
'management_doctor_about',
'management_doctor_gallery',
'management_doctor_times_index',
'management_doctor_times_create',
'management_doctor_times_edit',
'management_doctor_reserves_index']) ? 'active' : '' }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                کاربران
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('users.index') }}"
                                   class="nav-link {{ request()->routeIs(['users.index']) ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>مدیریت کاربران</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('users.create') }}"
                                   class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>ایجاد کاربران</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->routeIs(['categories.index',
'categories.create',
'categories.edit']) ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs(['categories.index',
'categories.create',
'categories.edit']) ? 'active' : '' }}">
                            <i class="nav-icon fa fa-tasks"></i>
                            <p>
                                دسته بندی ها
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}"
                                   class="nav-link {{ request()->routeIs(['categories.index']) ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>مدیریت دسته بندی ها</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('categories.create') }}"
                                   class="nav-link {{ request()->routeIs('categories.create') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>ایجاد دسته بندی ها</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->routeIs(['posts.index',
'posts.create',
'posts.edit',
'post_media_index']) ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs(['posts.index',
'posts.create',
'posts.edit',
'post_media_index']) ? 'active' : '' }}">
                            <i class="nav-icon fa fa-paper-plane"></i>
                            <p>
                                پست ها
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('posts.index') }}"
                                   class="nav-link {{ request()->routeIs(['posts.index']) ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>مدیریت پست ها</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('posts.create') }}"
                                   class="nav-link {{ request()->routeIs('posts.create') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>ایجاد پست ها</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->routeIs(['blacklists.index',
'blacklists.create',
'blacklists.edit']) ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs(['blacklists.index',
'blacklists.create',
'blacklists.edit']) ? 'active' : '' }}">
                            <i class="nav-icon fa fa-lock"></i>
                            <p>
                                کاربران لیست سیاه
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('blacklists.index') }}"
                                   class="nav-link {{ request()->routeIs(['blacklists.index']) ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p style="font-size: 14px">مدیریت کاربران لیست سیاه</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('blacklists.create') }}"
                                   class="nav-link {{ request()->routeIs('blacklists.create') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p style="font-size: 14px">ایجاد کاربران لیست سیاه</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->routeIs(['settings.index']) ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs(['settings.index']) ? 'active' : '' }}">
                            <i class="nav-icon fa fa-cogs"></i>
                            <p>
                                تنظیمات
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('settings.index') }}"
                                   class="nav-link {{ request()->routeIs(['settings.index']) ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>مدیریت تنظیمات</p>
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
