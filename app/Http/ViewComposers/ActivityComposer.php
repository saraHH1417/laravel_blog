<?php

namespace App\Http\ViewComposers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
    public function compose(View $view)
    {

        $mostCommented = Cache::tags(['blog-posts'])->remember('blog-post-most-commented' , now()->addSeconds(10) ,
            function (){
                return BlogPost::mostCommented()->take(5)->get();
            });

        $mostActiveUsers = Cache::remember('users-most-active' , now()->addSeconds(10) ,
            function (){
                return User::withMostBlogPosts()->take(5)->get();
            });

        $mostActiveUsersInLastMonth = Cache::remember('users-most-active-last-month', now()->addSeconds(10),
            function (){
                return User::withMostBlogPostsInLastMonth()->take(5)->get();
            });

        $view->with('mostCommented' , $mostCommented);
        $view->with('mostActiveUsers' , $mostActiveUsers);
        $view->with('mostActiveUsersInLastMonth' , $mostActiveUsersInLastMonth);
    }
}
