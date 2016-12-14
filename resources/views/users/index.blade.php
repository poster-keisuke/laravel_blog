@extends('layouts.app')
@section('content')

<h5>
  <a href="{{ url('/') }}" class="pull-right fs12">Back</a>
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

<!-- page control -->
{{-- {!! $users->render() !!} --}}

@stop