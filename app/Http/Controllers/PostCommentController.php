<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUsersPostWasCreated;
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
        ThrottledMail::dispatch(new CommentPostedMarkdown($comment) , $post->user);
//        $request->session()->flash('status' , 'Comment was created.');
        NotifyUsersPostWasCreated::dispatch($comment);
        return redirect()->back()->with('Comment created successfully');
    }
}
