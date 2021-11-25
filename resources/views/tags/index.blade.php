@extends('layouts.app')
@section('content')
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item  mr-5" role="presentation">
            <a class="nav-link active" id="pills-home-tab" href="#pills-home"  role="tab" data-toggle="tab">Posts</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="pills-profile-tab" href="#pills-profile" role="tab" data-toggle="tab" >Comments</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            @ShowPostList(['posts' => $posts])
            @endShowPostList
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            @ShowCommentList(['comments' => $comments])
            @endShowCommentList
        </div>
    </div>
@endsection
