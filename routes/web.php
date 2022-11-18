<?php

use Illuminate\Support\Facades\Route;


/*START ADMIN*/

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth', 'check_admin', 'throttle:50,1'],
    'namespace' => 'App\Http\Controllers\Admin'], function () {

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('profile', 'ProfileController@index')->name('profile');
    Route::patch('profile', 'ProfileController@update')->name('update_profile');

    Route::resource('expertises', 'ExpertiseController')->except('show');

    Route::resource('users', 'UserController')->except('show');

    Route::get('management/doctor/{id}', 'DoctorController@index')->name('management_doctor');

    Route::get('management/doctor/{id}/about', 'DoctorController@management_about')
        ->name('management_doctor_about');
    Route::post('management/doctor/{id}/about', 'DoctorController@management_about_do')
        ->name('management_doctor_about_post');
    Route::patch('management/doctor/{id}/about/{update_id}', 'DoctorController@management_about_do')
        ->name('management_doctor_about_update');

    Route::get('management/doctor/{id}/gallery', 'DoctorController@management_gallery')
        ->name('management_doctor_gallery');
    Route::post('management/doctor/{id}/gallery', 'DoctorController@management_gallery_do')
        ->name('management_doctor_gallery_do');
    Route::delete('management/doctor/{id}/gallery/{destroy_id}', 'DoctorController@management_gallery_destroy')
        ->name('management_doctor_gallery_destroy');

    Route::get('management/doctor/{id}/times', 'DoctorController@management_times_index')
        ->name('management_doctor_times_index');
    Route::get('management/doctor/{id}/times/create', 'DoctorController@management_times_create')
        ->name('management_doctor_times_create');
    Route::post('management/doctor/{id}/times', 'DoctorController@management_times_store')
        ->name('management_doctor_times_store');
    Route::get('management/doctor/{id}/times/{time_id}/edit', 'DoctorController@management_times_edit')
        ->name('management_doctor_times_edit');
    Route::patch('management/doctor/{id}/times/{time_id}', 'DoctorController@management_times_update')
        ->name('management_doctor_times_update');
    Route::delete('management/doctor/{id}/times/{time_id}', 'DoctorController@management_times_destroy')
        ->name('management_doctor_times_destroy');

    Route::get('management/doctor/{id}/reserves', 'DoctorController@management_reserves_index')
        ->name('management_doctor_reserves_index');
    Route::get('management/doctor/{id}/reserves/change_status/{reserve_id}/{status}', 'DoctorController@management_reserves_change_status')
        ->name('management_doctor_reserves_change_status');
    Route::delete('management/doctor/{id}/reserves/{reserve_id}', 'DoctorController@management_reserves_destroy')
        ->name('management_doctor_reserves_destroy');

    Route::resource('categories', 'CategoryController')->except('show');

    Route::resource('posts', 'PostController')->except('show');

    Route::get('post/media/{id}', 'PostController@media_index')->name('post_media_index');
    Route::post('post/media/{id}', 'PostController@media_store')->name('post_media_store');
    Route::delete('post/media/{id}/{media_id}/destroy', 'PostController@media_destroy')->name('post_media_destroy');

    Route::resource('blacklists', 'BlacklistController')->except('show');

    Route::get('settings', 'SettingController@index')->name('settings.index');
    Route::post('settings', 'SettingController@do')->name('settings.store');
    Route::patch('settings', 'SettingController@do')->name('settings.update');

});

/*END ADMIN*/


/*START DOCTOR*/

Route::group(['prefix' => 'doctor', 'middleware' => ['web', 'auth', 'check_doctor_and_clerk', 'throttle:50,1'],
    'namespace' => 'App\Http\Controllers\Doctor'], function () {

    Route::get('/', function () {
        return redirect()->route('doctor_dashboard');
    });

    Route::get('dashboard', 'DashboardController@index')->name('doctor_dashboard');

    Route::get('profile', 'ProfileController@index')->name('doctor_profile');
    Route::patch('profile', 'ProfileController@update')->name('doctor_update_profile');

    Route::resource('gallery', 'GalleryController')->except(['show', 'edit', 'update', 'create']);

    Route::resource('times', 'TimeController')->except('show');

    Route::get('reserves', 'ReserveController@index')->name('reserves.index');

    Route::get('reserves/change_status/{id}/{status}', 'ReserveController@change_status')->name('reserves.change_status');

    Route::get('questions', 'QuestionController@index')->name('questions.index');

    Route::get('questions/details/{id}', 'QuestionController@details')->name('questions.details');

    Route::post('questions/answer/{id}', 'QuestionController@answer')->name('questions.answer');

    Route::delete('questions/destroy/{id}', 'QuestionController@destroy')->name('questions.destroy');

});

/*END DOCTOR*/


/*START AUTH*/

Route::group(['prefix' => '/', 'middleware' => ['web', 'throttle:50,1'],
    'namespace' => 'App\Http\Controllers\Auth'], function () {

    Route::get('register', 'RegisterController@showRegistrationForm')
        ->name('register')->middleware('check_verify');
    Route::post('register', 'RegisterController@register')
        ->name('register')->middleware('check_verify');

    Route::get('verify', 'VerificationController@show')
        ->name('verify')->middleware(['auth', 'check_verify']);
    Route::post('verify', 'VerificationController@verify')
        ->name('verify')->middleware(['auth']);
    Route::post('verify/resend', 'VerificationController@resend')
        ->name('resend')->middleware(['auth']);

    Route::get('forgot', 'ForgotPasswordController@show')
        ->name('forgot')->middleware('guest');
    Route::post('forgot', 'ForgotPasswordController@send')
        ->name('forgot')->middleware('guest');

    Route::get('login', 'LoginController@showLoginForm')
        ->name('login')->middleware('check_verify');
    Route::post('login', 'LoginController@login')
        ->name('login')->middleware(['check_verify']);

    Route::any('logout', 'LoginController@logout')
        ->name('logout')->middleware('auth');
});

/*END AUTH*/


/*START SITE*/

Route::group(['prefix' => '/', 'middleware' => ['web', 'throttle:50,1', 'block_user'],
    'namespace' => 'App\Http\Controllers\Site'], function () {

    Route::get('/', 'MainController@home')->name('home');

    Route::get('search', 'MainController@search')->name('search');

    Route::get('about-us', 'MainController@about_us')->name('about-us');

    Route::get('support', 'MainController@support')->name('support');

    Route::get('terms-and-conditions', 'MainController@terms_and_conditions')->name('terms-and-conditions');

    Route::get('expertise/{slug}', 'MainController@expertise')->name('expertise');

    Route::get('doctor/{slug}', 'MainController@doctor')->name('doctor');

    Route::post('doctor/reserve', 'MainController@reserve')->name('reserve')
        ->middleware(['auth', 'active_user']);

    Route::group(['prefix' => 'panel', 'middleware' => ['auth', 'active_user']], function () {
        Route::get('profile', 'PanelController@profile')->name('user_profile');
        Route::patch('profile', 'PanelController@update_profile')->name('user_update_profile');
        Route::patch('avatar', 'PanelController@update_avatar')->name('user_update_avatar');
        Route::get('reserves', 'PanelController@reserves')->name('user_reserves');
        Route::post('reserves/cancel', 'PanelController@cancel_reserve')->name('cancel_reserve');
        Route::get('questions', 'PanelController@questions')->name('user_questions');
        Route::get('questions/details/{id}', 'PanelController@questions_details')->name('user_questions_details');
        Route::get('questions/create', 'PanelController@create_questions')->name('user_create_questions');
        Route::post('questions/create', 'PanelController@create_questions_do')->name('user_create_questions_do');
    });

    Route::get('blog', 'BlogController@index')->name('blog');
    Route::get('blog/category/{slug}', 'BlogController@category')->name('category');
    Route::get('blog/post/{slug}', 'BlogController@post')->name('post');
    Route::get('blog/search', 'BlogController@search')->name('blog.search');

});

/*END SITE*/
