@extends('layouts.app')
@section('title', 'Blog Detail')
@section('content')

<h1>
  <a href="{{ $_SERVER['HTTP_REFERER']  }}" class="pull-right fs12">Back</a>
  {{ $post->title }}</h1>
<p class="blog__contents">{!! nl2br(e($post->body)) !!}</p>
<img src="{{ "/img/" . $post->image }}" class="blog__image">


<h2>コメントを残す</h2>
<form method="post" action="{{ action('CommentsController@store', $post->id) }}">
  {{ csrf_field() }}
    <input type="text" name="comment" placeholder="コメントする" value="{{ old('comment') }}">
    @if ($errors->has('comment'))
    <span class="error">{{ $errors->first('comment') }}</span>
    @endif
    <input type="submit" value="投稿" class="add-comments">
</form>

<div class="all-comments">
	<h2>コメント一覧</h2>

	    @forelse ($post->comments as $comment)
	        <ul class="comment__content">
			    <li class="comment">
			        <h4 class="comment-body" id="comment_{{ $comment->id }}">
			    	    {{ $comment->comment }}
			        </h4>
			    </li>
			    <div class="clearfix">
				    <h6 class="comment-name">
				    	{{ $comment->commenter }}
				    </h6>

				    <div class="comment-area">
						<form method="post"  class="comment__form" action="{{ action('RepliesController@store', $post->id) }}">
						    {{ csrf_field() }}
						    <input type="text" name="reply" class="commentbox" placeholder="コメントする" value="{{ old('comment') }}">
						    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
						    @if ($errors->has('comment'))
						    <span class="error">{{ $errors->first('comment') }}</span>
						    @endif
						    <input type="submit" value="投稿" class="submit-comments">
						</form>
					</div>
				</div>
		    
		    @forelse ($post->replies as $reply)
		        @if($comment->id == $reply->comment_id)
	            	<ul class="comment_from_comment">
			    		<li class="comment">
			        		<h4 class="reply-body" id="comment_{{ $comment->id }}">
			    	    		{{ $reply->comment }}
			        		</h4>
		{{-- 	        		<h6 class="comment-name">
			    	    		{{ $reply->name }}
			        		</h6> --}}
			    		</li>
			    	</ul>
		        <div class="comment-area">
					<form method="post"  class="comment__form" action="{{ action('RepliesController@create', $post->id) }}">
					    {{ csrf_field() }}
					    <input type="text" name="reply" class="commentbox" placeholder="コメントする" value="{{ old('comment') }}">
					    <input type="hidden" name="reply_id" value="{{ $reply->id }}">
					    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
					    @if ($errors->has('comment'))
					    <span class="error">{{ $errors->first('comment') }}</span>
					    @endif
					    <input type="submit" value="投稿" class="submit-comments">
					</form>
				</div>
				@endif
		        @empty
	            @endforelse
	        </ul>
		@empty
			<li>No Comment yet</li>
		@endforelse

</div>

@endsection