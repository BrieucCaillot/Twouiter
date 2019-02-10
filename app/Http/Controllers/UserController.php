<?php

namespace App\Http\Controllers;

use App\User;
use App\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('user.user');
    }

    public function follow(Follower $follower, Request $request) {
        $request->validate([
            'userId' => 'required'
        ]);

        $follower->follower_id = Auth::user()->id;
        $follower->user_id = $request->userId;
        $follower->save();
    }

    public function unfollow(Request $request) {
        $request->validate([
            'userId' => 'required'
        ]);

        $unfollow = Follower::where('user_id', '=', $request->userId)->where('follower_id', '=', Auth::user()->id)->delete();
        return $unfollow;
    }
}
