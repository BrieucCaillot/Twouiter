<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.posts');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post, Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $post->content = $request->message;
        $post->user_id = Auth::id();
        $post->save();
    }

    /**
     * @return mixed
     */
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

    /**
     * @param null $username
     * @return mixed
     */
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

    /**
     * @param $postId
     * @return mixed
     */
    public function deletePost($postId) {
        $post = Post::where('id', 'like', $postId)->delete();
        return $post;
    }
}
