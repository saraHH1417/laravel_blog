@extends('layouts.app')

@section('content')
    @errors
    @enderrors
    <form action="{{ route('users.update' , ['user' => $user]) }}" method="POST"
          enctype="multipart/form-data" class="form-horizontal">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-4">
                <img src="{{ $user->image ? $user->image->url() : '' }}" alt="" class="img-thumbnail avatar">
                {{-- or --}}
                {{-- <img src="{{ $storage::url($user->image->path) }}" alt="" class="img-thumbnail avatar">--}}

                <div class="card">
                    <div class="card-body">
                        <h6>Upload a different image</h6>
                        <input class="form-control-file" type="file" name="avatar">
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input class="form-control" id="name" type="text" value="{{ $user->name ?? '' }}" name="name">
                </div>

                <div class="form-group">
                    <label> {{__('Language:')}}</label>
                    <select class="form-control" name="locale">
                        @foreach($languages as $key=>$language)
                            <option value=" {{ $key }}" {{ $user->locale == $key ? 'selected' : '' }}>
                                {{ $language }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Save Changes">
                </div>
            </div>
        </div>
    </form>
@endsection
