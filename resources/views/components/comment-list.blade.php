@forelse($comments as $comment)
    {{ $comment->contents }}
    <div class="row">
        <div class="col-10">
            <a href="">Like</a> -
            <a href="">Share</a>
            @tags(['tags' => $comment->tags]) @endtags
            @updated(['name' => $comment->user->name ,'date' => $comment->created_at->diffForHumans() ,
            'userId' => $comment->user->id])
            @endupdated
        </div>
    </div>
    <hr>
@empty
    <p>No Comments Yet!</p>
@endforelse
