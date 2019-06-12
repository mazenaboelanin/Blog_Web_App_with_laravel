@extends('layouts.app')

@section ('content')
<br>
    <a href="/lsapp/public/posts" class="btn btn-secondary">Go Back</a>
    <h1>{{$post->title}}</h1>
    <img style ="width:100%" src="../storage/cover_images/{{$post->cover_image}}" alt="{{$post->cover_image}}" >
    <br><br>
    <div>
        {{$post->body}}
    </div>
    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>
    @if( !auth::guest() ) <!-- if user not authenticated dont show -->
        @if( auth::user()->id == $post->user_id ) <!-- Matching user_id of the post with the auth user to show edit and delete post btn -->
        <a href="{{$post->id}}/edit" class="btn btn-primary">Edit </a>
    
        {{Form::open(['action' => ['PostsController@destroy' , $post->id ] , 'method' => 'POST' , 'class' => 'float-right' ])}}
        {{Form::hidden('_method' , 'DELETE')}}<!-- Delete to support Destroy -->
        {{Form::submit('Delete' , ['class' => 'btn btn-danger'])}}
        {{Form::close()}}
        @endif
    @endif
@endsection