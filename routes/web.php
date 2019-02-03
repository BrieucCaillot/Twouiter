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

use Illuminate\Support\Facades\Auth;

Route::middleware('web')->group(function () {
    Auth::routes();
});

Route::middleware('auth')->group(function () {
    Route::get('/', 'PostController@index');
    Route::get('/user/{username}', 'UserController@index');

    Route::get('/user', function () {
        return redirect()->back();
    });

    Route::get('/api/user', 'ApiController@user');
    Route::get('/api/posts', 'ApiController@posts');

    Route::get('/api/user/{id}', 'ApiController@userById');
    Route::get('/api/user/{id}/posts', 'ApiController@userPostsById');

    Route::get('/api/allposts', 'ApiController@allPosts');
    Route::post('/post', 'PostController@store');
});

