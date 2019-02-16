<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($username)
    {
        if (Auth::user()->username == $username) {
            return view('user.profile');
        }
        return redirect()->route('user.profile', ['username' => Auth::user()->username]);
    }

    public function update(Request $request) {
        if (Auth::check()) {

            $user = Auth::user();

            $request->validate([
                'name' => ['required', 'string', 'max:25'],
                'username' => ['required', 'string', 'max:18', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed']
            ]);

            if (Hash::check($request->oldpassword, $user->password)) {
                $user->name = $request->name;
                $user->username = $request->username;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);

                if (isset($request->image)) {
                    $avatarName = $user->id.'_'.time().'.'.request()->image->getClientOriginalExtension();
                    $request->file('image')->storeAs('avatars',$avatarName);
                    $user->image = $avatarName;
                }

                $user->save();

                return "Profile updated";
            } else {
                return response()->json(['errors' => ['password' => ["Your current password isn't valid"]]], 422);
            }
        }
    }
}
