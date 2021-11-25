@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8">
            {{--                <img src="http://localhost/projects/web/12_laravel_course_for_beginners_and_intermediate_piotr_jura/mid_blog/public/storage/{{ $post->image->path }}">--}}
{{--            <img src="{{ $post->image->url() }}" alt="Image didn't loaded successfully">--}}
            @if($post->image)
                <div style="background-image: url('{{ $post->image->url() }}');min-height: 500px;
                            color: white;text-align: center;background-attachment: fixed">
                    <h1 style="padding-top: 100px;text-shadow: 1px 2px #000">
            @else
                <div>
                    <h1>
            @endif

                    {{ $post->title }}
                        @badge(['type' => 'primary' , 'show' => now()->diffInMinutes($post->created_at) < 30])
                        NEW POST!
                        @endbadge
                    </h1>

                </div>
            <p> {{ $post->contents }}</p>

                @updated(['name' => $post->user->name , 'date' => $post->created_at->diffForHumans() ,
                            'userId' => $post->user->id])
                @endupdated
                @if($post->updated_at->diffForHumans() !== $post->created_at->diffForHumans())
                    @updated(['name' => $post->user->name , 'date' => $post->updated_at->diffForHumans(),
                                'userId' => $post->user->id])
                        Updated
                    @endupdated
                @endif
                @tags(['tags' => $post->tags])
                @endtags
                <p>Online People On This Page: {{ $counter }}</p>
            <hr>


            @AddCommentForm(['route' => route('posts.comments.store' , ['post' => $post->id])])
            @endAddCommentForm

            @ShowCommentList(['comments' => $post->comments])
            @endShowCommentList
        <!-- showing comments -->
            <h4>{{ count($post->comments) }} Comments</h4>
        </div>
        <div class="col-sm-4">
            @include('posts._activity');
        </div>
    </div>
@endsection
