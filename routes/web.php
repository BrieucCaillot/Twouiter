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

    // Redirect to view
    Route::get('/', 'PostController@index')->name('home');
    Route::get('/user/{username}', 'UserController@index');
    Route::get('/user/{username}/followings', 'UserController@followings');
    Route::get('/user/{username}/followers', 'UserController@followers');
    Route::get('/user', function () { return redirect()->route('home'); });

    Route::prefix('api')->group(function () {
        Route::get('userc/{username?}', 'ApiController@user');
        Route::get('user/posts/{username?}', 'ApiController@posts');
        Route::get('user/followers/{username?}', 'ApiController@followers');
        Route::get('user/followings/{username?}',  'ApiController@followings');
        Route::get('allposts', 'ApiController@allPosts');
    });

//    Route::post('profile/{profileId}/follow', 'ProfileController@followUser')->name('user.follow');
//    Route::post('/{profileId}/unfollow', 'ProfileController@unFollowUser')->name('user.unfollow');

    Route::post('/post', 'PostController@store');
});