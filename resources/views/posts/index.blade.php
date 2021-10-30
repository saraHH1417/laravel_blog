@extends('layouts.app')

@section('content')
    @forelse($posts as $post)
        <h3>
            <a href="{{ route('posts.show' , ['post' => $post->id]) }}"> {{ $post->title }} </a>
        </h3>
        <p>
            {{ $post->content }}
        </p>
        @if($post->comments_count)
            <p>{{ $post->comments_count }} Comments</p>
        @else
            <p>No Comments Yet!</p>
        @endif
        <div class="row">
            <div class="col-1">
                <p>
                    <a href="{{ route('posts.edit' , ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
                </p>
            </div>
            <div class="col-1">
                <form action=" {{ route('posts.destroy' , ['post' => $post->id]) }}">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-danger" value="Delete">
                </form>
            </div>
        </div>
    @empty
        <p> No blog posts yet! </p>
    @endforelse
@endsection

