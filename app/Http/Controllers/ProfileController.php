<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function update(Request $request)
    {
        if (Auth::check()) {

            $user = Auth::user();

            $request->validate([
                'name' => ['required', 'string', 'max:25'],
                'username' => ['required', 'string', 'max:18', 'unique:users,username,' . $user->id],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            ]);

            if (isset($request->image)) {
                $avatarName = $user->id . '_' . time() . '.' . request()->image->getClientOriginalExtension();
                $resize = Image::make($request->file('image'))->fit(300)->encode('jpg');
                Storage::put('avatars/' . $avatarName, $resize);
                $user->image = $avatarName;
                $user->save();
            }

            if (isset($request->password)) {
                if (Hash::check($request->oldpassword, $user->password)) {
                    $user->name = $request->name;
                    $user->username = $request->username;
                    $user->email = $request->email;
                    $user->password = bcrypt($request->password);
                    $user->save();
                } else {
                    return response()->json(['errors' => ['password' => ["Your current password isn't valid"]]], 422);
                }
            }

            return "Profile updated";

        }
    }
}
