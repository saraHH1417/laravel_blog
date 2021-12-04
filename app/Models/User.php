<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    public const LOCALES = [
        'en' => 'English',
        'fa'=> 'Farsi',
        'es'=> 'Spanish',
        'de'=> 'Deutsch'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
        'is_admin'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNameWithEmailAttribute() {
        return "Welcome " . ucwords($this->name) . ', Your Email: '. $this->email;
    }

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class , 'imageable');
    }

    // comments that created by the user
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // comments that other users have written for this user
    public function commentsOn()
    {
        return $this->morphMany(Comment::class , 'commentable')->latest();
    }
    public function scopeWithMostBlogPosts(Builder $query)
    {
        return $query->withCount('blogPosts')->orderBy('blog_posts_count' , 'desc');
    }

    public function scopeWithMostBlogPostsInLastMonth(Builder $query)
    {
        return $query->withCount(['blogPosts' => function(Builder $query){
                     $query->whereBetween(static::CREATED_AT , [now()->subMonths(1) , now()]);
        }])->has('blogPosts' , '>=' , '3')
           ->orderBy('blog_posts_count' , 'desc');
    }

    public function scopeThatHasCommentedOnPost(Builder $query, BlogPost $blogPost)
    {
         return $query->whereHas('comments' , function ($query) use($blogPost){
             return $query->where('commentable_id' , $blogPost->id)
                 ->where('commentable_type' , BlogPost::class);
         });
    }


    public function scopeUsersWhoAreAdmin(Builder $query)
    {
        return $query->where('is_admin' , true);
    }
}
