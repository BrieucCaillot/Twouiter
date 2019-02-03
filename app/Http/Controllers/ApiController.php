<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Auth;

class ApiController extends PostController
{
    public function allPosts() {
        $posts = Post::orderBy('created_at', 'DESC')->paginate(10);
        foreach ($posts as $post) {
            Carbon::setLocale('fr');
            $post->human_date = Carbon::parse($post->created_at)->diffForHumans();
            $post->user = User::find($post->user_id);
        }
        return $posts;
    }

    public function user() {
        return Auth::user();
    }

    public function posts() {
        $user = Auth::user()->posts;
        foreach ($user as $post) {
            Carbon::setLocale('fr');
            $post->human_date = Carbon::parse($post->created_at)->diffForHumans();
            $post->user = User::find($post->user_id);
        }
        return $user;
    }

    public function userById($id) {
        return User::find($id);
    }

    public function userPostsById($id) {
        $user = User::find($id);
        return $user->posts;
    }

    public function test() {
        $post = Post::find(1);
        return $post->user;
    }
}
