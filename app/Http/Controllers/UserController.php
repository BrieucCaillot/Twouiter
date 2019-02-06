<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.user');
    }
    public function followings()
    {
        return view('user.followings');
    }
    public function followers()
    {
        return view('user.followers');
    }
}
