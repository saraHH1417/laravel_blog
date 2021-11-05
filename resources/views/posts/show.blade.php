@extends('layouts.app')

@section('content')
    <h1>
        {{ $post->title }}
            @badge(['type' => 'primary' , 'show' => now()->diffInMinutes($post->created_at) < 30])
            NEW POST!
            @endbadge
    </h1>

    <p> {{ $post->content }}</p>
        @updated(['name' => $post->user->name , 'date' => $post->created_at->diffForHumans()])
        @endupdated
        @if($post->updated_at !== $post->created_at)
            @updated(['name' => $post->user->name , 'date' => $post->created_at->diffForHumans()])
                Updated
            @endupdated
        @endif
        <p>Online People On This Page: {{ $counter }}</p>
    <hr>
    <!-- showing comments -->
    <h4>{{ count($post->comments) }} Comments</h4>

    @forelse($post->comments as $comment)
        <div class="row">
            <div class="col-md-8">
                    {{ $comment->content }}
                    <p><small><a href="">Like</a> - <a href="">Share</a></small></p>
            </div>
            <div class="col-md-4">
                <p class="pull-right">
                    <small>
                        @updated(['date' => $comment->created_at->diffForHumans()])
                        @endupdated
                    </small>
                </p>
            </div>
        </div>
    @empty
        <p>No Comments Yet!</p>
    @endforelse
@endsection
