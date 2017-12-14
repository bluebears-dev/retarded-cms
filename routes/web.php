<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'Dashboard\LoginController@showForms')->name('login');
Route::post('/login', 'Dashboard\LoginController@login')->middleware('throttle:5');

Route::get('/logout', 'Dashboard\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard');

    Route::group(['middleware' => 'throttle:100'], function() {
        Route::get('/api/themes', 'Dashboard\DashboardController@themes');

        Route::post('/api/user/theme', 'Dashboard\UserController@theme');
        Route::get('/api/user/current', 'Dashboard\UserController@current');
        Route::get('/api/user/roles', 'Dashboard\UserController@roles');
        Route::resource('/api/user', 'Dashboard\UserController',
            ['except' => ['create', 'edit']]);

        Route::post('/api/page/add', 'PageController@add');
    });
});

Route::get('/', 'PageController@index')->name('home');
Route::get('{slug}', 'PageController@page')->where('slug', '([A-Za-z0-9\-\/]+)');