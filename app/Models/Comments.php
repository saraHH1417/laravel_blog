<?php

namespace App\Models;

use App\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comments extends Model
{
    use HasFactory , SoftDeletes , Taggable;

    protected $fillable =['contents' , 'user_id'];

    public function commentable()
    {
        return $this->morphTo();
    }
    public function blogPost()
    {
        return $this->belongsTo(Comments::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeLatest(Builder $query) :Builder
    {
        return $query->orderBy(static::CREATED_AT , 'desc');
    }

    public function scopeLatestWithRelations(Builder $query) :Builder
    {
        return $query->latest()
            ->with('tags','user');
    }
    public static function boot()
    {
        parent::boot();
//        static::addGlobalScope(new LatestScope);

        //if we don't use a forget cache for blogpost , we may not see the updated post immediately in the
        // blogpost page. because of that we forget cache of our blogpost
        static::creating(function (Comments $comment){
            if($comment->commentable_type === BlogPost::class) {
                Cache::tags('blog-posts')->forget("blog-post-{$comment->commentable_id}");
                Cache::tags('blog-posts')->forget("blog-post-most-commented");
            }
        });
    }

}
