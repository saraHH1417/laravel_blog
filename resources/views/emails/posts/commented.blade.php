<style>
    body {
        font-family: Arial , Halvetica, sans-serif;
    }
</style>

<p>
    Hi {{ $comment->commentable->user->name }},
    {{-- in fact commentable here is blog post --}}
    <br>
    Some one has commented on your blog post.
    <br>
    <a href="{{ route('posts.show' , ['post' => $comment->commentable->id]) }}">
        {{ $comment->commentable->title }}
    </a>
</p>
<hr>
<p>
    @if($comment->user->image)
        {{-- message variable exists in all email templates by default --}}
        <img src="{{$message->embed( $comment->user->image->url())}}" alt="Not Found">
    @endif
     <a href="{{ route('users.show' , ['user' => $comment->user->id]) }}">
        {{ ucwords($comment->user->name) }}
    </a> said:
</p>

<p>
    {!! nl2br(e($comment->contents)) !!}
</p>
