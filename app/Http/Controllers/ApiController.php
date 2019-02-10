<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use App\User;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends PostController
{
    public function allPosts()
    {
        $id = Auth::id();
        $posts = Post::whereIn('user_id', function ($query) use ($id) {
            $query->select('user_id')
                ->from('followers')
                ->where('follower_id', $id);
        })->orWhere('user_id', $id)->latest()->get();
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
            foreach ($userPosts as $post) {
                $post->human_date = Carbon::parse($post->created_at)->diffForHumans();
                $post->user = User::find($post->user_id);
            }
        }
        return $userPosts;
    }

    public function deletePost($postId) {
        $post = Post::where('id', 'like', $postId)->delete();
        return $post;
    }
}