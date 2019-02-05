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
    Route::get('/', 'PostController@index');
    Route::get('/user/{username}', 'UserController@index');
    Route::get('/user', function () { return redirect()->back(); });

    Route::prefix('api')->group(function () {
        Route::get('test/{username?}', 'ApiController@user');
        Route::get('ok/posts/{username}', 'ApiController@posts');
        Route::get('f1/followers', 'ApiController@followers');
        Route::get('followings', 'ApiController@followings');
        Route::get('allposts', 'ApiController@allPosts');
    });



//    Route::post('profile/{profileId}/follow', 'ProfileController@followUser')->name('user.follow');
//    Route::post('/{profileId}/unfollow', 'ProfileController@unFollowUser')->name('user.unfollow');



    Route::post('/post', 'PostController@store');
});

