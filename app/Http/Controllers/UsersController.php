<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends Controller
{
  public function index()
	{
		if (Auth::guest()) {
          return redirect('/login')->with('flash_message', 'You are not login');
        }

	    // $query = User::query();
	    //全件取得
	    //ページネーション
	    // $users = $query->orderBy('id','desc');
	    $users = User::all();
	    return view('users.index')->with('users',$users);
	}

	

  public function show($id)
	{
		if (Auth::guest()) {
          return redirect('/login')->with('flash_message', 'You are not login');
        }

		try {
          User::findOrFail($id);
        }
        catch (ModelNotFoundException $e) {
          return redirect('/')->with('flash_message', 'This user has not exist!');
        }
	    // $user_id = Auth::id();
	    $user_id = User::findOrFail($id)->id;
	    $user_posts = User::with('posts')->find($user_id);
	    // dd($user_posts);
	    return view('users.show')->with('user_posts',$user_posts);
	}


}
