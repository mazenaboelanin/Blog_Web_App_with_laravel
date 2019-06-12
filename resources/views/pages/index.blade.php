@extends('layouts.app') <!-- extends from @yield('content') in app layout -->

@section('content')
    
    

    <div class="jumbotron text-center">
        <!-- FIRST METHOD TO GET THE VARIABLE NAME -->
        <h1> {{$title}}</h1> <!-- getting the h1 from variable title which is in PagesController --> 
            <!-- SECOND METHOD TO GET THE VARIABLE NAME -->
             <!--  echo $title;  in php tag-->
        <p>This is laravel Blog application as a Beginner </p>
        <p><a class="btn btn-primary btn-lg" href="/lsapp/public/login" role="button">Login</a> <a class="btn btn-success btn-lg" href="register" role="button">Register</a></p>
    </div>
@endsection