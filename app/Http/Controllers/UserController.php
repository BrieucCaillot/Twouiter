<?php

namespace App\Http\Controllers;

use App\User;
use App\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('user.user');
    }

    /**
     * @param null $username
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user($username = null)
    {
        if ($username !== null) {
            $user = User::where('username', $username)->first();
            $user->countPosts = $user->posts->count();
            $user->countFollowings = $user->followings->count();
            $user->countFollowers = $user->followers->count();
            $user->paginateFollowings = $user->followings()->paginate(10);
            $user->paginateFollowers = $user->followers()->paginate(10);
        } else {
            $user = Auth::user();
            $user->countPosts = $user->posts->count();
            $user->countFollowings = $user->followings->count();
            $user->countFollowers = $user->followers->count();
            $user->paginateFollowings = $user->followings()->paginate(10);
            $user->paginateFollowers = $user->followers()->paginate(10);
        }
        return $user;
    }

    /**
     * @param Follower $follower
     * @param Request $request
     */
    public function follow(Follower $follower, Request $request) {
        $request->validate([
            'userId' => 'required'
        ]);

        $follower->follower_id = Auth::user()->id;
        $follower->user_id = $request->userId;
        $follower->save();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unfollow(Request $request) {
        $request->validate([
            'userId' => 'required'
        ]);

        $unfollow = Follower::where('user_id', '=', $request->userId)->where('follower_id', '=', Auth::user()->id)->delete();
        return $unfollow;
    }
}
