<?php

namespace App\Http\Controllers;

use Request;
use App\Post;
use App\User;
use Input;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Html\FormFacade;
use Collective\Html\HtmlServiceProvider;



class PostsController extends Controller
{

  public function index() {
    if (Auth::guest()) {
      return $this->isLoggedIn();
    } else {
      $posts = Post::orderBy('created_at', 'desc')->Paginate(5);
      return view('posts.index')->with('posts', $posts);
    }
  }

  public function show($id) {
    if (Auth::guest()) {
      return $this->isLoggedIn();
    } else {
      try {
        Post::findOrFail($id);
      }
      catch (ModelNotFoundException $e) {
        return redirect('/')->with('flash_message', 'This post has not exist!');
      }
    	$post = Post::findOrFail($id);
    	return view('posts.show')->with('post', $post);
    }
  }

  public function edit($id) {
    if (Auth::guest()) {
      return redirect('/login')->with('flash_message', 'You are not login');
    }

    try {
      Post::findOrFail($id);
    }
    catch (ModelNotFoundException $e) {
      return redirect('/')->with('flash_message', 'This post has not exist!');
    }

    $post = Post::findOrFail($id);
    $user_id = Auth::id();
    $post_id = Post::findOrFail($id)->user_id;
    if ($post_id === $user_id) {
    	$post = Post::findOrFail($id);
    	return view('posts.edit')->with('post', $post);
    } else{
      return redirect('/')->with('flash_message', 'You are not contributor');
    }
  }

  public function destroy($id) {
    if (Auth::guest()) {
      return redirect('/login')->with('flash_message', 'You are not login');
    }

    try {
      Post::findOrFail($id);
    }
    catch (ModelNotFoundException $e) {
      return redirect('/')->with('flash_message', 'This post has not exist!');
    }

    $user_id = Auth::id();
    $post_id = Post::findOrFail($id)->user_id;

    if ($post_id === $user_id) {
  	  $post = Post::findOrFail($id);
  	  $post->delete();
  	  return redirect('/')->with('flash_message', 'Post Deleted!!');
    } else{
      return redirect('/')->with('flash_message', 'You are not contributor');
    }
  }

  public function create() {
    if (Auth::guest()) {
      return redirect('/login')->with('flash_message', 'You are not login');
    }
  	return view('posts.create');
  }

  public function store(PostRequest $request) {
    if (Auth::guest()) {
      return redirect('/login')->with('flash_message', 'You are not login');
    }
  	$post = new Post();
  	$post->title = $request->title;
    $post->body = $request->body;
    $file = $request->file('image');

    if ($file !== null ) {
      $file = $request->file('image');
      $originFileName = $file->getClientOriginalName();
      $fileExtension = pathinfo($originFileName, PATHINFO_EXTENSION);

      $date = date("YmdHis");
      $fileName = $date . "." . $fileExtension;

      $path = public_path() . "/img/" . $fileName; 
      $file->move( public_path() . "/img/", $fileName);
      $image['image'] = $path; 
      $post->image = $fileName;

      \Auth::user()->posts()->save($post);
      return redirect('/')->with('flash_message', 'Post Added!');

    } else {
      $imagefile = "noimage.png";
      $post->image = $imagefile;
      \Auth::user()->posts()->save($post);
      return redirect('/')->with('flash_message', 'Post Added!');
    }

  }

  public function update(PostRequest $request, $id) {
    if (Auth::guest()) {
      return redirect('/login')->with('flash_message', 'You are not login');
    }
    try {
      Post::findOrFail($id);
    }
    catch (ModelNotFoundException $e) {
      return redirect('/')->with('flash_message', 'This post has not exist!');
    }

    $user_id = Auth::id();
    $post_id = Post::findOrFail($id)->user_id;

    if ($post_id === $user_id) {
    	$post = Post::findOrFail($id);
    	$post->title = $request->title;
    	$post->body = $request->body;

      $file = $request->file('image');

      if($file) {
        $file = $request->file('image');
        $originFileName = $file->getClientOriginalName();
        $fileExtension = pathinfo($originFileName, PATHINFO_EXTENSION);

        $date = date("YmdHis");
        $fileName = $date . "." . $fileExtension;

        $path = public_path() . "/img/" . $fileName; 
        $file->move( public_path() . "/img/", $fileName);
        $image['image'] = $path; 
        $post->image = $fileName;
      }
          
          
      $post->save();
      return redirect('/')->with('flash_message', 'Post Updated!!!');
    } else {
      return redirect('/')->with('flash_message', 'You are not contributor');
    }
  }

  public function getSearch(){
    $query = Request::get('q');
    $sort_query = Request::get('sort');

    if ($query) {
      $posts = Post::where('title', 'like', "%$query%")->Paginate(5);
    } elseif ($sort_query == 'old') {
      $posts = Post::orderBy('created_at', 'asc')->Paginate(5);
    } else {
      $posts = Post::orderBy('created_at', 'desc')->Paginate(5);
    }
    return view('posts.index')->with('posts', $posts);
  }



  private function isLoggedIn() {
    if (Auth::guest()) {
      return redirect('/login')->with('flash_message', 'You are not login');
    }
  }

}
