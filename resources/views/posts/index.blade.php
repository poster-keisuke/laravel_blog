@extends('layouts.app')
@section('content')

<div class="search">
  {{ Form::open(['method' => 'GET']) }}
  {{ Form::input('検索する', 'q', null) }}
  {{ Form::close() }}
</div>

<h1>
  <a href="{{ url('/posts/create') }}" class="pull-right fs12">Add New</a>
  Posts
</h1>

<a href="{{ url('/') }}" class="pull-right fs12">New</a>
<br>
<a href="{{ url('/?sort=old') }}" class="pull-right fs12">Old</a>

<ul>
  @forelse ($posts as $post)
  <li>
    <a href="{{ action('PostsController@show', $post->id) }}">{{ $post->title }}</a>
        {{-- @if (Auth::user()->id) --}}
    @can('update-post', $post)
      <a href="{{ action('PostsController@edit', $post->id) }}" class="fs12">[Edit]</a>
    @endcan
    @can('delete-post', $post)
      <form action="{{ action('PostsController@destroy', $post->id) }}" id="form_{{ $post->id }}" method="post", style="display:inline">
      {{ csrf_field() }}
      {{ method_field('delete') }}
        <a href="#" data-id="{{ $post->id }}" onclick="deletePost(this);" class="fs12">[✕]</a>
      </form>
    @endcan
  </li>
  @empty
  <li>No Posts yet</li>
  @endforelse
</ul>

<div class="paginate">
  {{ $posts->appends(Request::only('q'))->links() }}
</div>

<h5 class="user__title">
  <a href="/users">ユーザー一覧ページへ</a>
</h5>
<br>
<h5 class="user__title">
  <a href="/">topページへ</a>
</h5>


<script>
function deletePost(e) {
  'use strict';

  if (confirm('are you sure?')) {
    document.getElementById('form_' + e.dataset.id).submit();
  }
}
</script>

@stop