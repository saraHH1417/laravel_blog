<p>
    @if($tags)
        @foreach($tags as $tag)
            <a href=" {{ route('posts.tag.index' , ['tagId' => $tag->id]) }}" class="badge badge-success mb-1" style="font-size: 1rem"> {{ $tag->name }}</a>
       @endforeach
    @endif
</p>
