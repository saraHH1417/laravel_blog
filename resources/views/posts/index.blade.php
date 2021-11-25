@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8">
            @ShowPostList(['posts' => $posts])
            @endShowPostList
        </div>
        <div class="rightSidebar col-sm-4">
            @include('posts._activity')
        </div>
    </div>
@endsection

