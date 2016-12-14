@extends('layouts.app')
@section('title', 'Blog Detail')
@section('content')

<h1>
  <a href="{{ $_SERVER['HTTP_REFERER']  }}" class="pull-right fs12">Back</a>
  {{ $post->title }}</h1>
<p class="blog__contents">{!! nl2br(e($post->body)) !!}</p>
<img src="{{ "/img/" . $post->image }}" class="blog__image">
@endsection