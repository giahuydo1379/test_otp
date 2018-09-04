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

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

// Two Factor Authentication
Route::middleware('auth')->group(function () {
    Route::get('2fa', 'TwoFactorController@showTwoFactorForm');
    Route::post('2fa', ['middleware' => ['two_factor'], 'uses' => 'TwoFactorController@verifyTwoFactor']);
   // Route::get('admin', 'TwoFactorController@showAdmin');
    Route::get('/home', 'TwoFactorController@showAdmin');
});