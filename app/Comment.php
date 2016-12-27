<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = ['comment'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    // comment->post
    public function post() {
        return $this->belongsTo('App\Post');
    }

    public function comments(){
        return $this->hasMany('App\Reply');
    }
}