<?php

namespace App\Http\Controllers;

use Request;
use App\User;
use App\Post;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;

class UsersController extends Controller
{
  public function index()
	{
		if (Auth::guest()) {
          return redirect('/login')->with('flash_message', 'You are not login');
        }

	    $query = User::query();
	    $users = $query->orderBy('id','desc');
	    return view('users.index')->with('users',$users);
	}

	    //jsonを返す
  public function json()
    {
        $query = User::query();
        $users = $query->orderBy('id','desc')->paginate(2);
        return \Response::json($users);
    }

   public function ajax()
    {
	    $page = Input::get('page');
	    if(empty($page)) $page = 1;

	    return view('users.ajax')->with('page',$page);
	    // $query = User::query();
     //    $page = $query->orderBy('id','desc')->paginate(2);
     //    return view('users.ajax')->with('page',$page);
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

	public function getSearch() {
	    $query = Request::get('q');

	    if ($query) {
	      $users = User::where('name', 'like', "%$query%")->Paginate(5);
	    } else {
	      $query = User::query();
	      $users = $query->orderBy('id','desc')->paginate(2);

	      // $users = User::all();
	    }
	    return view('users.index')->with('users',$users);
	  }


}
