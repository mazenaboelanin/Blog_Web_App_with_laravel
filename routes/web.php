<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/******  MY COMMENTS 

// " / " means its in home page 
// get is the type of request 

*****/
/*
Route::get('/hello', function () {
    // return view('welcome');
    return '<h1>hello world</h1>';
 });
 */
/*
Route::get ('/users/{id}/{name}' , function( $id , $name ){
    // 
   return 'This is username ' . $name . ' with an id ' .$id;
});
*/

/*
Route::get('/', function () {
    return view('welcome');
  // return 'hello world';
});
*/
/*
Route::get ('/about' , function(){
     // i can write --> pages.about OR pages/about
    return view ('pages.about');
});

*/

Route::get('/' , 'PagesController@index');
Route::get('/about' , 'PagesController@about');
Route::get('/services' , 'PagesController@services');

Route::resource('posts' ,'PostsController');
Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
