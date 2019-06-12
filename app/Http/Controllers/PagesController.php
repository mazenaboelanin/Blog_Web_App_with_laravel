<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $title = 'Welcome To laravel';
        /* FIRST METHOD TO PASS VARIABLE */
       // return view('pages.index' , compact ('title')); // index.blade.php
       
       /* SECOND METHOD TO PASS VARIABLE */ // it's better when we pass array of vaiables
       return view('pages.index') -> with('title' , $title);
    }

    public function about()
    {
        $title = 'About Us';
        return view('pages.about' , compact ('title'));
    }

    public function services()
    {
        $data = array(
            'title' => 'Services',
            'services' => ['Web Design' , 'Programming' , 'SEO']
        );
        return view('pages.services') -> with($data);
    }
}
