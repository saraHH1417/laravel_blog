<?php

namespace App\Jobs;

use App\Mail\CommentPostedOnPostsWatched;
use App\Models\Comments;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyUsersPostWasCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $comment;
    public function __construct(Comments $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::thatHasCommentedOnPost($this->comment->commentable)
            ->get()
            ->filter(function (User $user){
                return $user->id != $this->comment->user_id;
            })->map(function (User $user){
//                Mail::to($user)->send(
//                    new CommentPostedOnPostsWatched($this->comment , $user)
//                );
                ThrottledMail::dispatch(new CommentPostedOnPostsWatched($this->comment , $user) , $user);
            });
    }
}
