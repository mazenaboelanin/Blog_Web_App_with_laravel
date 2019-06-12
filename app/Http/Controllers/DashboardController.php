<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // block any action in dashboard if user is not authenticated
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->user()->id; //getting the log id 
        $user = User::Find($user_id);
        return view('dashboard')->with('posts' , $user->posts); // we can do $user->post because we have now a relation between user and posts
    }
}
