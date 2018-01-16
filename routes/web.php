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

        Route::get('/api/page/{name}', 'PageController@getPage');
        Route::post('/api/page/{name}/toggleState', 'PageController@toggleState');
        Route::resource('/api/page', 'PageController',
            ['except' => ['create', 'edit', 'show']]);

        Route::get('/api/chat/{time}/{amount}', 'Dashboard\ChatController@index')->where([
            'time' => '[0-9]+',
            'amount' => '[0-9]+'
        ]);
        Route::post('/api/chat', 'Dashboard\ChatController@store');

        Route::resource('/api/menu', 'Dashboard\MenuController',
            ['except' => ['create', 'edit', 'show', 'update']]);
    });
});

Route::get('/', 'PageController@home')->name('home');
Route::get('{slug}', 'PageController@fetch')->where('slug', '([A-Za-z0-9\-\/]+)');