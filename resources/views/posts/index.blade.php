@extends('layouts.app')

@section ('content')
    <h1>Posts</h1>
    @if(count($posts) > 0 )
        @foreach ($posts as $post)
            <div class="list-group">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style ="width:100%" src="storage/cover_images/{{$post->cover_image}}" alt="{{$post->cover_image}}" >
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div class="list-group-item">
                            <h3><a href="posts\{{$post->id}}" >{{$post->title}}</a></h3>
                            <!-- 
                                show written on date and name of the user 
                                NOTE: we don't be able to show username like this untill we have relational between posts and user
                                then we can here access user from posts
                            -->
                                <small>Written on {{$post->created_at}} by {{$post->user->name}} </small>   
                        </div>
                    </div>
                </div>
               
            </div>
            <hr>
        @endforeach
      
        {{$posts->links()}}
    @else
        <p> No Posts found </p>
    @endif

@endsection