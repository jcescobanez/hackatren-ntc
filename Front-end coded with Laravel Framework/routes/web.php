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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/cloud', 'FirebaseController@cloudMessaging');
Route::get('/station/status', 'StationController@index');

Auth::routes();
Route::get('/station', 'FirebaseController@try');
Route::get('/station/status/update', 'StationController@timeUpdate');

Route::get('/home', 'HomeController@index')->name('home');
