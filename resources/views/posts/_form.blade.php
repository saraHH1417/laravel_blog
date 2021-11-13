<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" value="{{ old('title' , $post->title ?? null) }}" class="form-control">
</div>

<div class="form-group">
    <label for="content">Content</label>
    <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ old('content' , $post->content ?? null) }}</textarea>
</div>
<div class="form-group">
    <label for="file">File</label>
    <input type="file" name="thumbnail" id="file" class="form-control-file">
</div>

@errors @enderrors
