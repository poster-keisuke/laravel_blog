<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reply;
use App\Comment;
use App\User;
use App\Post;
use Auth;

class RepliesController extends Controller
{
    public function store(Request $request, $postId) {
    	$this->validate($request, [
    		'comment' => 'required'
    	]);

    	$reply = new Reply(['comment' => $request->reply]);
        $reply->comment = $request->reply;
    	$post = post::findOrFail($postId);
    	$reply->before_comment_id = (0);
        $reply->comment_id = ($_POST['comment_id']);

    	$user_id = Auth::id();
    	$user = User::findOrFail($user_id);
    	$reply->name = $user->name;
    	

    	$post->replies()->save($reply);


    	return redirect()
    	       ->action('PostsController@show', $post->id);
    }
    public function create(Request $request, $postId) {
        // $this->validate($request, [
        //  'comment' => 'required'
        // ]);

        $reply = new Reply(['comment' => $request->reply]);
        $reply->comment = $request->reply;
        $post = post::findOrFail($postId);
        $reply->before_comment_id = ($_POST['reply_id']);
        $reply->comment_id = ($_POST['comment_id']);

        $user_id = Auth::id();
        $user = User::findOrFail($user_id);
        $reply->name = $user->name;
        

        $post->replies()->save($reply);


        return redirect()
               ->action('PostsController@show', $post->id);
    }
}
