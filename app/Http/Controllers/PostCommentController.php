<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted;
use App\Http\Requests\StoreComment;
use App\Http\Resources\CommentResource;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\ThrottledMail;
use App\Mail\CommentPostedMarkdown;
use App\Mail\CommnetPostedMail;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
    public function __constructor()
    {
        $this->middleware('auth')->only(['store']);
    }



    public function store(StoreComment $request , BlogPost $post)
    {
        $comment = $post->comments()->create([
            'contents' => $request->input('contents'),
            'user_id' => $request->user()->id
        ]);

//        Mail::to($post->user)->queue(
//            new CommentPostedMarkdown($comment)
//        );
//        $when = now()->addMinutes(1);
//        Mail::to($post->user)->later(
//            $when,
//            new CommentPostedMarkdown($comment)
//        );

        event(new CommentPosted($comment));


        return redirect()->back()->with('Comment created successfully');
    }
}
