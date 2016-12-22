@extends('layouts.app')
@section('content')

<div class="search">
  {{ Form::open(['method' => 'GET']) }}
  {{ Form::input('検索する', 'q', null) }}
  {{ Form::close() }}
</div>

<h5>
  <a href="{{ $_SERVER['HTTP_REFERER'] }}" class="pull-right fs12">Back</a>
</h5>

<h1>ユーザー一覧</h1>

<table class="table table-striped">
  <tr><th>ユーザーID：</th><th>登録日時：</th><th>ユーザー名：</th></tr>
@foreach($users as $user)
  <tr>
    <td>{{$user->id}}</td>
    <td>{{$user->created_at}}</td>
    <td><a href="{{ action('UsersController@show', $user->id) }}">{{ $user->name }}</a>
  </tr>
@endforeach
</table>

{!! $users->render() !!}

<h5 class="user__title">
  <a href="/users">ユーザー一覧ページへ</a>
</h5>
<br>
<h5 class="user__title">
  <a href="/">topページへ</a>
</h5>


@stop