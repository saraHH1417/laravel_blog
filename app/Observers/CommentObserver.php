<?php

namespace App\Observers;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     *
     * @param  \App\Models\Comment  $comments
     * @return void
     */
    public function creating(Comment $comment)
    {
        if($comment->commentable_type === BlogPost::class) {
            Cache::tags('blog-posts')->forget("blog-post-{$comment->commentable_id}");
            Cache::tags('blog-posts')->forget("blog-post-most-commented");
        }
    }

}
