<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;

use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BlogPost extends Model
{
    use HasFactory , softDeletes , Taggable;

    protected $fillable = ['title' , 'contents' , 'user_id'];

    public function image()
    {
        return $this->morphOne(Image::class , 'imageable');
    }
    public function comments()
    {
        return $this->morphMany(Comments::class , 'commentable')->latest();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


//    public function scopeLatest(Builder $query) : Builder
//    {
//        return $query->orderBy(static::CREATED_AT , 'desc');
//    }

    public function scopeMostCommented(Builder $query) :Builder
    {
        return $query->withCount('comments')->orderBy('comments_count' , 'desc');
    }

    public function scopeLatestWithRelations(Builder $query) :Builder
    {
        return $query->latest()
            ->withCount('comments')
            ->with('tags','user');
    }
    public static function boot()
    {
//        static::addGlobalScope(new LatestScope);
        static::addGlobalScope(new DeletedAdminScope);
        parent::boot();

        static::creating(function (BlogPost $blogPost){
            Cache::forget("users-most-active");
            Cache::forget("users-most-active-last-month");
        });

//        Moved this to observer
//        static::deleting(function(BlogPost $blogPost){
//            Cache::tags('blog-post')->forget("blog-post-{$blogPost->id}");
//            $blogPost->comments()->delete();
//            //because posts are soft deletable we don't write below line
//            Storage::delete($blogPost->image->path);
//            $blogPost->image()->delete();
//        });



//        Moved this to observer
//        static::updating(function (BlogPost $blogPost){
//            Cache::tags('blog-post')->forget("blog-post-{$blogPost->id}");
//        });

        //        Moved this to observer
//        static::restoring(function (BlogPost $blogPost){
//            $blogPost->comments()->restore();
//        });
    }
}
