<ul class="nav nav-tabs margin-top-40">

    <li class="{{ request()->routeIs(['user_profile']) ? 'active' : '' }}">
        <a href="{{ request()->routeIs(['user_profile']) ? 'javascript:void(0)' : route('user_profile') }}">اطلاعات کاربری</a>
    </li>

    <li class="{{ request()->routeIs(['user_reserves']) ? 'active' : '' }}">
        <a href="{{ request()->routeIs(['user_reserves']) ? 'javascript:void(0)' : route('user_reserves') }}">نوبت‌های رزرو شده</a>
    </li>

    <li class="{{ request()->routeIs(['user_questions']) ? 'active' : '' }}">
        <a href="{{ request()->routeIs(['user_questions']) ? 'javascript:void(0)' : route('user_questions') }}">سوالات</a>
    </li>

    <li class="{{ request()->routeIs(['user_create_questions']) ? 'active' : '' }}">
        <a href="{{ request()->routeIs(['user_create_questions']) ? 'javascript:void(0)' : route('user_create_questions') }}">ایجاد سوال</a>
    </li>

</ul>
