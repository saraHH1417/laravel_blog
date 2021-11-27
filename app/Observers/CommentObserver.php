<?php

namespace App\Observers;

use App\Models\BlogPost;
use App\Models\Comments;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    /**
     * Handle the Comments "created" event.
     *
     * @param  \App\Models\Comments  $comments
     * @return void
     */
    public function creating(Comments $comment)
    {
        if($comment->commentable_type === BlogPost::class) {
            Cache::tags('blog-posts')->forget("blog-post-{$comment->commentable_id}");
            Cache::tags('blog-posts')->forget("blog-post-most-commented");
        }
    }

}
