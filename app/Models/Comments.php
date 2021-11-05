<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function blogPost()
    {
        return $this->belongsTo(Comments::class);
    }


    public function scopeLatest(Builder $query) :Builder
    {
        return $query->orderBy(static::CREATED_AT , 'desc');
    }
    public static function boot()
    {
        parent::boot();
//        static::addGlobalScope(new LatestScope);
    }

}
