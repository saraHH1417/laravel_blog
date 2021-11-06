<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comments extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =['content' , 'user_id'];
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
    public static function boot()
    {
        parent::boot();
//        static::addGlobalScope(new LatestScope);

        //if we don't use a forget cache for blogpost , we may not see the updated post immediately in the
        // blogpost page. because of that we forget cache of our blogpost
        static::creating(function (Comments $comment){
            Cache::tags('blog-posts')->forget("blog-post-{$comment->blog_post_id}");
            Cache::tags('blog-posts')->forget("blog-post-most-commented");
        });
    }

}
