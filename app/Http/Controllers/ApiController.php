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

    public function user($username) {
        $user = User::where('username', 'like', $username)->first();

        $obj = [
            'user' => $user,
            'following' =>$user->followings,
            'followers' => $user->followers,
        ];
        return $obj;
    }

    public function posts($username) {
        $posts = User::where('username', 'like', $username)->first()->posts;

        foreach ($posts as $post) {
            Carbon::setLocale('fr');
            $post->human_date = Carbon::parse($post->created_at)->diffForHumans();
            $post->user = User::find($post->user_id);
        }
        return $posts;
    }

    public function followers() {
        return Auth::user()->followers;
    }

     public function followings() {
        return Auth::user()->followings;
    }

    public function userById($id) {
        return User::find($id);
    }

    public function userPostsById($id) {
        $user = User::find($id);
        return $user->posts;
    }
}
