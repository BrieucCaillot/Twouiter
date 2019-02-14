<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('user.profile');
    }

    public function update(User $user, Request $request) {

        $request->validate([
           'name' => 'required',
           'username' => 'required|min:2'
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->username = $request->username;

        if (isset($request->image)) {
            $avatarName = $user->id.'_'.time().'.'.request()->image->getClientOriginalExtension();
            $request->file('image')->storeAs('avatars',$avatarName);
            $user->image = $avatarName;
        }

        $user->save();

        return $user;
    }
}
