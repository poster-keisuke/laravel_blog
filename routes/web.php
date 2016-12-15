<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
	return view('posts.index');
});
Route::get('/', 'PostsController@index');
Route::get('/posts/create', 'PostsController@create');
Route::get('/posts/{id}', 'PostsController@show');
Route::get('/posts/{id}/edit', 'PostsController@edit');
Route::post('/posts', 'PostsController@store');
Route::patch('/posts/{id}/', 'PostsController@update');
Route::delete('/posts/{id}/', 'PostsController@destroy');

Route::get('/', 'PostsController@getSearch');

Route::get('/users','UsersController@index');
Route::get('/user/{id}','UsersController@show');

/* ログイン画面の表示 */
Route::get('auth/login', 'Auth\AuthController@getLogin');
/* ログイン処理 */
Route::post('auth/login', 'Auth\AuthController@postLogin');
/* ログアウト */
Route::get('auth/logout', 'Auth\AuthController@getLogout');
/* ユーザー登録画面の表示 */
Route::get('auth/register', 'Auth\RegisterController@__construct');
/* ユーザー登録処理 */
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Route::get('/{name}', function($name) {
// 	return 'hello!' . $name;
// });
Auth::routes();

Route::get('/home', 'HomeController@index');
