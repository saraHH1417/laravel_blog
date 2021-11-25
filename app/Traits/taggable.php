<?php

namespace App\Traits;

use App\Models\Tag;

trait Taggable {

    public static function bootTaggable()
    {
        static::updating(function ($model){
            $model->tags()->sync(static::findTagsInContent($model->contents));

            //if we wanted to use a trait for commentable models we should have created another trait named commentable
            // then we use it in the models that are commentable
            // then like this in the updating we write
            //$model->commnents()->sync($ i don't know this part , here we should somehow get the comment content)
        });

        static::created(function($model){
            $model->tags()->sync(static::findTagsInContent($model->contents));
        });
    }
    public function tags()
    {
        return $this->morphToMany(Tag::class , 'taggable')->withTimestamps();
    }

    private static function findTagsInContent($contents)
    {
        preg_match_all('/@([^@]+)@/m' , $contents , $tags);
        return Tag::whereIn('name' , $tags[1] ?? [])->get();
    }
}
