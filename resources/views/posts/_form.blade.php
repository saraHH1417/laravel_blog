<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" value="{{ old('title' , $post->title ?? null) }}" class="form-control">
</div>

<div class="form-group">
    <label for="content">Content</label>
    <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ old('content' , $post->content ?? null) }}</textarea>
</div>


@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>
                {{ $error }}
            </li>
        @endforeach
    </ul>
@endif
