<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index($tagId)
    {
        $tag = Tag::findOrFail($tagId);


        return view('tags.index' , [
            'posts' => $tag->blogPosts()->latestWithRelations()->get(),
            'comments' => $tag->comments()->latestWithRelations()->get()
        ]);
    }
}
