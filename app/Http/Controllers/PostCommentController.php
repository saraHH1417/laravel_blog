<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function __constructor()
    {
        $this->middleware('auth')->only(['store']);
    }
    public function store(StoreComment $request , BlogPost $post)
    {
        $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        $request->session()->flash('status' , 'Comment was created.');

        return redirect()->back();
    }
}
