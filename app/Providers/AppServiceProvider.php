<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use App\Services\Counter;
use App\Services\DummyCounter;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use phpDocumentor\Reflection\Types\Resource_;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // when we request CommentResource it returns all results wrapped in $data array(or object, honestly I'm not sure)
        // $data is used for special occasions like when we need pagination . So , We don't need $data here and can
        // disable it with withoutWrapping function.
        JsonResource::withoutWrapping();
        // or CommentResource::withoutWrapping()
//        Schema::defaultStringLength(191);
        Blade::aliasComponent('components.badge' , 'badge');
        Blade::aliasComponent('components.updated' , 'updated');
        Blade::aliasComponent('components.card' , 'card');
        Blade::aliasComponent('components.tags' , 'tags');
        Blade::aliasComponent('components.errors' , 'errors');
        Blade::aliasComponent('components.comment-form' , 'AddCommentForm');
        Blade::aliasComponent('components.comment-list' , 'ShowCommentList');
        Blade::aliasComponent('components.post-list' , 'ShowPostList');

//        view()->composer('*' , ActivityComposer::class);
        view()->composer(['posts.index' , 'posts.show'] , ActivityComposer::class);

//        $this->app->bind(Counter::class , function($app){
//            return new Counter(5);
//        });

        // $app->make('x') equals resolve('x')
        $this->app->singleton(Counter::class , function($app){
            return new Counter(
                $app->make('Illuminate\Contracts\Cache\Factory'),
                $app->make('Illuminate\Contracts\Session\Session'),
                env('COUNTER_TIMEOUT'));
        });

        $this->app->bind(
            'App\Contracts\CounterContract',
            Counter::class
        );

//        $this->app->bind(
//           'App\Contracts\CounterContract',
//            DummyCounter::class
//        );


//        $this->app->when(Counter::class)
//            ->needs('$timeout')
//            ->give(env('COUNTER_TIMEOUT'));
    }
}
