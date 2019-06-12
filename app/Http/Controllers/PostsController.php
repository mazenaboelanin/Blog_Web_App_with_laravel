<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB; // to use SQL instead of elqount

class PostsController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth' , ['except' => ['index' , 'show'] ]); // block any action in dashboard if user is not authenticated
        // we make here exception for index and show views because we want to be able to show them even if we arent authenticated
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        //$posts = Post::all(); // fetching all the data in this model = post table
        //return  Post::where('title' , 'Post Two')->get();
        //$posts = Post::orderBy('title' , 'desc')->take(1)->get(); // to limit the data showed -> here one record will appear only 
        $posts = Post::orderBy('created_at' , 'desc')->paginate(10); // to show every post in one page and make paginate to navigate to other posts
        //$posts = Post::orderBy('title' , 'desc')->get(); // fetching all but with order by title in desc order
        return view ('posts.index')->with('posts' , $posts);

        /**** SQL COMMANDS INSTEAD OF ELEQOUNT ****
            $posts=DB::select('SELECT * FROM posts ');
        */
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) // for VALIDATION
    {
        //VALIDATE TITLE AND BODY AND MAKE THEM REQUIRED
        $this->validate($request , [
            'title' => 'required',
            'body' => 'required' , 
            'cover_image' => 'image|nullable|max:1999' ,//nullabel to be optional , max for size 
        ]);

       //handle file upload
       if($request->hasFile('cover_image'))
       {
            //Get file name with the extension

            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();

            //Get filename 
            $fileName = pathinfo ($fileNameWithExt , PATHINFO_FILENAME) ; //php 
            //Get Extension
            $extension = $request->file('cover_image')->getClientOriginalExtension(); //laravel

            //File name to store 
            $fileNameToStore = $fileName . '_' . time(). '.'.$extension;
            //Upload Image

            $path = $request->file('cover_image')->storeAs('public/cover_images' , $fileNameToStore);
       }
       else{
           $fileNameToStore = 'noimage.jpg'; //if there is no image uploaded , it give the default image 
       }

       //create Post
       $post = new Post;
       $post->title = $request->input('title');
       $post->body  = $request->input('body');
       $post->user_id = auth()->user()->id; //Because it doesnt come from request 
       $post->cover_image = $fileNameToStore;
       $post->save();

       return redirect('/posts')->with('success' , 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id); //showing the record of this id 
        return view('posts.show')->with('post' , $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //check for correct user 
        if( auth()->user()->id !== $post->user_id ){
            return redirect('/posts')->with( 'error', 'Unauthorized Page' );
        }

        return view('posts.edit')->with( 'post', $post );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request , [
            'title' => 'required' , 
            'body' => 'required'
        ]);

        //handle file upload
       if($request->hasFile('cover_image'))
       {
            //Get file name with the extension

            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();

            //Get filename 
            $fileName = pathinfo ($fileNameWithExt , PATHINFO_FILENAME) ; //php 
            //Get Extension
            $extension = $request->file('cover_image')->getClientOriginalExtension(); //laravel

            //File name to store 
            $fileNameToStore = $fileName . '_' . time(). '.'.$extension;
            //Upload Image

            $path = $request->file('cover_image')->storeAs('public/cover_images' , $fileNameToStore);
       }
      

        //update post 
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image'))
        {
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('\posts')->with('success' , 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find the post 
        $post = Post::find($id);

        //check correct user 

        if ( auth()->user()->id !== $post->user_id)
        {
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        if($post->cover_image != 'noimage.jpg')
        {
            //delete image
            Storage::delete('public\cover_images'.$post->cover_image);
        }


        $post->delete();
        return redirect('\posts')->with('success' , 'Post Removed');

    }
}
