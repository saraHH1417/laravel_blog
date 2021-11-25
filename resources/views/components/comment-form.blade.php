<div class="mb-2 mt-2">
    @auth
        <form action="{{ $route}}" method="post"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <textarea name="contents" id="content" style="width: 100%" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Add Comment</button>
        </form>
        @errors @enderrors
    @else
        <a href="{{ route('login') }}">Login </a> To Add Comment!
    @endauth
</div>
<hr>

