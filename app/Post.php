<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Tavle Name
    protected  $table = 'posts';
    //primary key 
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;
    
    //Making relation between user and posts 
    public function user(){
        return $this->belongsTo('App\User');  // means that post belong to a user 
    }
}
