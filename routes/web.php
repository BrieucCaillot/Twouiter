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
    Route::get('/user', function () { return redirect()->route('home'); });
});

Route::middleware('auth')->group(function () {

    Route::get('/', 'PostController@index')->name('home');
    Route::get('user/{username}', 'UserController@index')->name('user');
    Route::get('user/{username}/profile', 'ProfileController@index')->name('user.profile');
    Route::post('/post', 'PostController@store');

    Route::prefix('api')->group(function () {
        //Profile
        Route::post('user/profile', 'ProfileController@update');
        // User
        Route::get('userc/{username?}', 'UserController@user');
        Route::post('user/follow', 'UserController@follow');
        Route::post('user/unfollow', 'UserController@unfollow');
        // Posts
        Route::get('user/posts/{username?}', 'PostController@posts');
        Route::get('user/delete-post/{postId}', 'PostController@deletePost');
        Route::get('allposts', 'PostController@allPosts');
    });

});