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

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard');

    Route::get('/api/user/current', 'Dashboard\UserController@current')->middleware('throttle:100');
    Route::get('/api/user/roles', 'Dashboard\UserController@roles')->middleware('throttle:100');
    Route::resource('/api/user', 'Dashboard\UserController',
        ['except' => ['create', 'edit']])->middleware('throttle:50');
});