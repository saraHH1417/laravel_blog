<div class="mb-2 mt-2">
    @auth
        <form action=" {{ route('posts.comments.store' , ['post' => $post->id]) }}" method="post"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <textarea name="content" id="content" style="width: 100%" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label for="file">File</label>
                <input type="file" name="thumbnail" id="file" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Add Comment</button>
        </form>
        @errors @enderrors
    @else
            <a href="{{ route('login') }}">Login </a> To Add Comment!
    @endauth
</div>
<hr>
