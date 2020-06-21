<?php

use Illuminate\Support\Facades\Route;

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
Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::get('{code}', 'Api\ShortUrlController@redirectTo')->where('code', '[a-zA-Z0-9]{5}')->middleware('checkpwd');
Route::get('{code}/password', 'Api\ShortUrlController@confirmPassword')->where('code', '[a-zA-Z0-9]{5}')->name('confirm.password');
Route::post('{code}/password/check', 'Api\ShortUrlController@checkPassword')->where('code', '[a-zA-Z0-9]{5}')->name('confirm.check');
Route::get('/home', 'HomeController@index')->name('home');

Route::fallback(function () {
    return abort(404);
});
