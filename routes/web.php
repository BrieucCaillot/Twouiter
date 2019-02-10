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
    Route::get('/user/{username}', 'UserController@index');
    // @TODO NOT WORKING WHEN NOT CONNECTED - 401 UNAUTHORIZED
    Route::get('api/userc/{username?}', 'ApiController@user');
    Route::get('/user', function () { return redirect()->route('home'); });
});

Route::middleware('auth')->group(function () {

    Route::get('/', 'PostController@index')->name('home');
    Route::post('/post', 'PostController@store');

    Route::prefix('api')->group(function () {
        Route::get('userc/{username?}', 'ApiController@user');
        Route::get('user/posts/{username?}', 'ApiController@posts');
        Route::get('user/delete-post/{postId}', 'ApiController@deletePost');
        Route::post('user/follow', 'UserController@follow');
        Route::post('user/unfollow', 'UserController@unfollow');
        Route::get('allposts', 'ApiController@allPosts');
    });

});