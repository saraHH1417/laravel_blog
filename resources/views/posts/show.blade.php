@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8">
            <h1>
                {{ $post->title }}
                    @badge(['type' => 'primary' , 'show' => now()->diffInMinutes($post->created_at) < 30])
                    NEW POST!
                    @endbadge
            </h1>

            <p> {{ $post->content }}</p>
                @updated(['name' => $post->user->name , 'date' => $post->created_at->diffForHumans()])
                @endupdated
                @if($post->updated_at->diffForHumans() !== $post->created_at->diffForHumans())
                    @updated(['name' => $post->user->name , 'date' => $post->updated_at->diffForHumans()])
                        Updated
                    @endupdated
                @endif
                @tags(['tags' => $post->tags])
                @endtags
                <p>Online People On This Page: {{ $counter }}</p>
            <hr>


            @include('comments._form')

        <!-- showing comments -->
            <h4>{{ count($post->comments) }} Comments</h4>
            @forelse($post->comments as $comment)
                {{ $comment->content }}
                <div class="row">
                    <div class="col-10">
                        <a href="">Like</a> -
                        <a href="">Share</a>
                        @updated(['name' => $comment->user->name ,'date' => $comment->created_at->diffForHumans()])
                        @endupdated
                    </div>
                </div>
            @empty
                <p>No Comments Yet!</p>
            @endforelse
        </div>
        <div class="col-sm-4">
            @include('posts._activity');
        </div>
    </div>
@endsection
