<?php

namespace App\Providers;

use App\Policies\BlogPostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\BlogPost' => 'App\Policies\BlogPostPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('home.secret' , function ($user){
            return $user->is_admin;
        });
//        Gate::define('update-post' , function($user, $post){
//            return $user->id === $post->user_id;
//        });
//
//        Gate::allows('update-post' , $post); this statement is for checking in controller page
//        $this->authorize('update-post' , $post); this statement is for checking in controller page
//        Gate::define('delete-post' , function($user, $post){
//            return $user->id === $post->user_id;
//        });

//        Gate::define('posts.update' , [BlogPostPolicy::class , 'update']);
//        Gate::define('posts.delete' , [BlogPostPolicy::class , 'delete']);

        Gate::resource('posts' , BlogPostPolicy::class);

//        Before statement checks before all of gates and depending on the ability the next gates results can change
        Gate::before(function ($user , $ability){
            if($user->is_admin && in_array($ability , ['update' , 'delete'])){
                return true;
            }
        });


//      After statement can change the final result of gate even if the previous gates are false with after final result
//        can be true
//
//        Gate::after(function ($user , $ability , $result){
//            if($user->is_admin){
//                return true;
//            }
//        });
    }
}
