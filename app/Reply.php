<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['reply'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    // comment->post
    public function post() {
      return $this->belongsTo('App\Post');
    }

    public function comment() {
      return $this->belongsTo('App\Comment');
    }
}
