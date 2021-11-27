<?php

namespace App\Listeners;

use App\Events\BlogPostCreated;
use App\Jobs\NotifyAdminPostWasCreated;
use App\Jobs\ThrottledMail;
use App\Mail\BlogPostAdded;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAdminWhenBlogPostCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BlogPostCreated $event)
    {
        //1
//        User::UsersWhoAreAdmin()
//            ->get()
//            ->map(function (User $user){
//                Mail::to($user)
//                    ->send(new BlogPostAdded);
//            });

        //2
        // It is preferable if we use Cache::remember for getting users who are admin.
        User::UsersWhoAreAdmin()
            ->get()
            ->map(function (User $user){
                ThrottledMail::dispatch(new BlogPostAdded , $user);
            });

//        //3
//        NotifyAdminPostWasCreated::dispatch();

    }
}
