@extends('layouts.app')

@section('content')
    <form action="{{ route('posts.update' , ['post' => $post->id]) }}" method="POST">
        @csrf
        @method('PUT')
        @include('posts._form')
    </form>

@endsection
