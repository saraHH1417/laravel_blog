@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-4">
            @if($user->image)
                <img src="{{ $user->image->url() }}" alt="" class="img-thumbnail avatar">
            @endif
        </div>
        <div class="col-8">
            <h3>{{ $user->name }}</h3>
            <h3>{{ __('Language') }}: {{ $languages[$user->locale] }}</h3>

            <p>Currently viewed by {{ $counter }} other users</p>

            @auth
                @if(\Illuminate\Support\Facades\Auth::user()->id == $user->id)
                    <a class="btn btn-info" href="{{ route('users.edit' , ['user' => $user->id]) }}">
                        Edit Details
                    </a>
                @endif
            @endauth
            <div id="comments-div">
                @AddCommentForm(['route' => route('users.comments.store' , ['user' => $user->id])])
                @endAddCommentForm

                @ShowCommentList(['comments' => $user->commentsOn])
                @endShowCommentList
            </div>
        </div>
    </div>
@endsection
