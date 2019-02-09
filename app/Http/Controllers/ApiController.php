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
            $post->human_date = Carbon::parse($post->created_at)->diffForHumans();
            $post->user = User::find($post->user_id);
        }
        return $posts;
    }

    public function user($username = null)
    {
        if ($username !== null) {
            $user = User::where('username', 'like', $username)->first();
            $user->countPosts = $user->posts->count();
            $user->countFollowings = $user->followings->count();
            $user->countFollowers = $user->followers->count();
        } else {
            $user = Auth::user();
            $user->countPosts = $user->posts->count();
            $user->countFollowings = $user->followings->count();
            $user->countFollowers = $user->followers->count();
        }
        return $user;
    }

    public function posts($username = null)
    {
        if ($username !== null) {
            $user = User::where('username', 'like', $username)->first();
            $userPosts = $user->posts;

            foreach ($userPosts as $post) {
                $post->human_date = Carbon::parse($post->created_at)->diffForHumans();
                $post->user = User::find($post->user_id);
            }
        } else {
            $user = Auth::user();
            $userPosts = $user->posts;
        }
        return $userPosts;
    }

    public function followings($username = null)
    {
        if ($username !== null) {
            $user = User::where('username', 'like', $username)->first();
            $userFollowings = $user->followings;
            foreach ($userFollowings as $userFollow) {
                $userFollow->user = User::find($userFollow->user_id);
            }
        } else {
            $user = Auth::user();
            $userFollowings = $user->followings;
        }
        return $userFollowings;
    }

    public function followers($username = null)
    {
        if ($username !== null) {
            $user = User::where('username', 'like', $username)->first();
            $userFollowers = $user->followers;
        } else {
            $user = Auth::user();
            $userFollowers = $user->followers;
        }
        return $userFollowers;
    }
}