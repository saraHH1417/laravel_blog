@if($errors->any())
    <dv class="mb-2 mt-2">
        @foreach($errors->all() as $error)
            <div class="alert alert-danger mb-2 mt-2" role="alert">
                {{ $error }}
            </div>
        @endforeach
    </dv>
@endif
