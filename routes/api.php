<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// TODO middleware

Route::middleware('tokenAuth')->group(function () {
    Route::post('/posts.create', 'App\Http\Controllers\PostsController@create');
    Route::post('/posts.uploadImage', 'App\Http\Controllers\PostsController@uploadImage');
    Route::get('/posts.get', 'App\Http\Controllers\PostsController@get');
    Route::get('/posts.getPost', 'App\Http\Controllers\PostsController@getPost');
    Route::get('/posts.search', 'App\Http\Controllers\PostsController@search');
    Route::get('/posts.getNew', 'App\Http\Controllers\PostsController@getNew');
    Route::get('/posts.repost', 'App\Http\Controllers\PostsController@repost');
    Route::get('/posts.feed', 'App\Http\Controllers\PostsController@feed');
    Route::get('/posts.count', 'App\Http\Controllers\PostsController@count');

    Route::get('/users.get', 'App\Http\Controllers\UsersController@get');
    Route::get('/users.getAll', 'App\Http\Controllers\UsersController@getAll');
    Route::get('/users.save', 'App\Http\Controllers\UsersController@save');
    Route::post('/users.photo', 'App\Http\Controllers\UsersController@setPhoto');
    Route::get('/users.getNew', 'App\Http\Controllers\UsersController@getNew');
    Route::get('/users.search', 'App\Http\Controllers\UsersController@search');
    Route::get('/users.follow', 'App\Http\Controllers\UsersController@follow');
    Route::get('/users.unfollow', 'App\Http\Controllers\UsersController@unfollow');
    Route::get('/users.block', 'App\Http\Controllers\UsersController@block');

    Route::get('/likes.create', 'App\Http\Controllers\LikesController@like');

    Route::get('/statistics.common', 'App\Http\Controllers\StatisticsController@common');
});
