<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comment;
use App\User;
use App\Post;
use Auth;

class CommentsController extends Controller
{
    public function store(Request $request, $postId) {
    	$this->validate($request, [
    		'comment' => 'required'
    	]);

    	$comment = new Comment(['comment' => $request->comment]);
    	
    	$post = post::findOrFail($postId);
    	$comment->before_post_id = $postId;

    	$user_id = Auth::id();
    	$user = User::findOrFail($user_id);
    	$comment->commenter = $user->name;
    	

    	$post->comments()->save($comment);


    	return redirect()
    	       ->action('PostsController@show', $post->id);
    }

    // public function create(Request $request, $postId) {
    // 	$this->validate($request, [
    // 		'comment' => 'required'
    // 	]);

    // 	$comment = new Comment(['comment' => $request->comment]);
    	
    // 	$post = post::findOrFail($postId);
    // 	$comment->before_post_id = ($_POST['comment_id']);

    // 	$user_id = Auth::id();
    // 	$user = User::findOrFail($user_id);
    // 	$comment->commenter = $user->name;
    	

    // 	$post->comments()->save($comment);


    // 	return redirect()
    // 	       ->action('PostsController@show', $post->id);
    // }
}
