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
    Route::get('/panel', 'Panel\DashboardController@index')->name('panel');
    Route::get('/panel/user', 'Panel\DashboardController@user');
});


Route::post('/lockoutTime', 'Panel\LoginController@lockoutTime');
