@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('messages.logged_in') }}
                     @lang('messages.logged_in')

                    <h4>Using json : {{ __('Welcome to Laravel.') }}</h4>
                    <h4>Using json: {{ __('hello :name' , ['name' => 'user']) }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
