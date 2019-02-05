<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Auth;

class ApiController extends PostController
{
    public function allPosts()
    {
        $posts = Post::orderBy('created_at', 'DESC')->paginate(10);
        foreach ($posts as $post) {
            Carbon::setLocale('fr');
            $post->human_date = Carbon::parse($post->created_at)->diffForHumans();
            $post->user = User::find($post->user_id);
        }
        return $posts;
    }

    public function user($username = null)
    {
        if ($username !== null) {
            $user = User::where('username', 'like', $username)->first();
            $user->countPosts = sizeof($user->posts);
            $user->countFollowings = sizeof($user->followings);
            $user->countFollowers = sizeof($user->followers);
        } else {
            $user = Auth::user();
            $user->countPosts = sizeof($user->posts);
            $user->countFollowings = sizeof($user->followings);
            $user->countFollowers = sizeof($user->followers);
        }
        return $user;
    }

    public function posts($username = null)
    {
        if ($username !== null) {
            $user = User::where('username', 'like', $username)->first();
            $userPosts = $user->posts;

            foreach ($userPosts as $post) {
                Carbon::setLocale('fr');
                $post->human_date = Carbon::parse($post->created_at)->diffForHumans();
                $post->user = User::find($post->user_id);
            }
        } else {
            $user = Auth::user();
            $userPosts = $user->posts;
        }
        return $userPosts;
    }

    public function followers()
    {
        return Auth::user()->followers;
    }

    public function followings()
    {
        return Auth::user()->followings;
    }
}
