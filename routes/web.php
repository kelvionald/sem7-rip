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

Route::get('/logout', 'App\Http\Controllers\SpaController@logout')->name('logout');

Route::get('/admin', 'App\Http\Controllers\SpaController@admin')->name('admin');
Route::get('/admin/{any}', 'App\Http\Controllers\SpaController@admin')->where('admin.any', '.*');
Route::get('/adminlogin', 'App\Http\Controllers\SpaController@adminlogin');

Route::post('/ulogin', 'App\Http\Controllers\SpaController@ulogin');
Route::get('/', 'App\Http\Controllers\SpaController@index')->name('auth');
Route::get('/{any}', 'App\Http\Controllers\SpaController@index')->where('any', '.*');
