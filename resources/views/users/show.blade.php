@extends('layouts.app')
@section('content')

<h5>
  <a href="{{ url('/users') }}" class="pull-right fs12">Back</a>
</h5>

<h1>{{$user_posts->name}}の記事ー一覧</h1>

<table class="table table-striped">
  <tr><th>記事作成時間</th><th>記事タイトル</th></tr>
@forelse($user_posts->posts as $post)
    <tr>
        <td>{{$post->updated_at}}</td>
        <td><a href="{{ action('PostsController@show', $post->id) }}">{{$post->title}}</a></td>
    </tr>
@empty
  <li>No Posts yet</li>
@endforelse
</table>

@stop