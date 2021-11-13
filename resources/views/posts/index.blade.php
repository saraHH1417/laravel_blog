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
                <p style="overflow:auto">
                    {{ $post->content }}
                </p>
                @updated(['name' => $post->user->name , 'date' => $post->created_at->diffForHumans()])
                @endupdated

                @tags(['tags' => $post->tags])
                @endtags
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
            @include('posts._activity')
        </div>
    </div>
@endsection

