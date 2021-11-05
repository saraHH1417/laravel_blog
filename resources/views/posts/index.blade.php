@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8">
            @forelse( $posts as $post)
                <h3>
                    @if($post->trashed())
                        <del>
                    @endif
                    <a  class="{{ $post->trashed() ? 'text-muted' : '' }}" href="{{ route('posts.show' , ['post' => $post->id]) }}">
                        {{ $post->title }}
                    </a>
                    @if($post->trashed())
                        </del>
                    @endif
                </h3>
                <p>
                    {{ $post->content }}
                </p>
                <p> Post added {{ $post->created_at->diffForHumans() }}
                    By {{ $post->user->name }}</p>
                @if($post->comments_count)
                    <p>{{ $post->comments_count }} Comments</p>
                @else
                    <p>No Comments Yet!</p>
                @endif

                @auth
                    @can('update' , $post)
                        <a href="{{ route('posts.edit' , ['post' => $post->id]) }}" class="btn btn-primary">
                            Edit
                        </a>
                    @endcan

                    @if( !$post->trashed())
                        @can('delete' , $post)
                        <a href="{{ route('posts.destroy' , ['post' => $post->id]) }}"
                           onclick="event.preventDefault();document.querySelector('#delete_form-{{ $post->id }}').submit()" class="btn btn-primary">
                            Delete
                        </a>
                        <form id="delete_form-{{ $post->id }}" method="post" type="hidden" action="{{ route('posts.destroy' , ['post' => $post->id]) }}">
                            @csrf
                            @method('DELETE')
                        </form>
                        @endcan
                    @endif
                @endauth
                <hr>
            @empty
                <p> No blog posts yet! </p>
            @endforelse
        </div>
        <div class="rightSidebar col-sm-4">
            @card(['title' => "Most Commented" , 'elements' => collect($mostCommented) ,'elementFeature' => 'title',
                    'needLink' => true])
                @slot('subtitle')
                    What people are currently talking about?
                @endslot
                @slot( 'noElementDetail' )
                    Currently , There is no commented post.
                @endslot
            @endcard

            @card(['marginTop' => 'mt-4' , 'title' => "Most Active Users" , 'subtitle' => "Which users have more posts?",
                    'elements' => $mostActiveUsers , 'noElementDetail' => 'Currently , There is no commented post.'
                    ,'elementFeature' => 'name'])
            @endcard

            @card(['marginTop' => 'mt-4' ,'title' => "Most Active Users In The Last Month" , 'subtitle' => "Which users have more posts?",
            'elements' => $mostActiveUsers , 'noElementDetail' => 'Currently , There is no active user.'
            ,'elementFeature' => 'name'])
            @endcard
        </div>
    </div>
@endsection

