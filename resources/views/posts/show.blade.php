@extends('layouts.app')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p> {{ $post->content }}</p>
    <p> Added {{ $post->created_at->diffForHumans() }}</p>

    @if((new Carbon\Carbon())->diffInMinutes($post->created_at) < 15)
     <strong>New!</strong>
    @endif

    <h4>Comments</h4>
    @forelse($post->comments as $comment)
        <p>
            {{ $comment->content }}
        </p>
        <p class="text-muted">
            Added {{ $commnet->updated_at->diffForHumans() }}
        </p>
    @empty
        <p>No Comments Yet!</p>
    @endforelse
@endsection
