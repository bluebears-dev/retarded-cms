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

Route::get('/login', 'Panel\LoginController@showForms')->name('login');
Route::post('/login', 'Panel\LoginController@login')->middleware('throttle:5');

Route::get('/logout', 'Panel\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard');
    Route::resource('/api/users', 'Dashboard\UserController')->middleware('throttle:10');
});


Route::post('/lockoutTime', 'Panel\LoginController@lockoutTime');
