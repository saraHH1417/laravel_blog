<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\CommentPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComment;
use App\Http\Resources\CommentResource;
use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Http\Request;

class ApiPostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(BlogPost $post , Request $request)
    {
        // if we put (int) before $request->input(x) it turns null to zero which is wrong
        // and we don't want this to happen. so we don't use (int)
      $perPage = $request->input('per_page') ?? 15;
      return CommentResource::collection(
          $post->comments()->with('user')->paginate(5)->appends(
            [
                'per_page' => $perPage
            ]
          )
      );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CommentResource
     */
    public function store(StoreComment $request,BlogPost $post)
    {
        $this->authorize(Comment::class);
        $comment = $post->comments()->create([
            'contents' => $request->input('contents'),
            'user_id' => $request->user()->id
        ]);

        event(new CommentPosted($comment));

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPost $post , Comment $comment)
    {
        return $comment;
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogPost $post , Comment $comment , StoreComment $request)
    {
        $this->authorize($comment);
        $comment->contents = $request->input('contents');
        $comment->save();
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPost $post,Comment $comment)
    {
        $this->authorize($comment);
        $comment->delete();
        return response()->json([
            'status' => 200,
            'message' => 'comment deleted successfully'
        ]);
    }

}
