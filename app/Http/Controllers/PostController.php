<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

// The methods that laravel has in blogpost policy when we make it with artisan
//[
//    'view' => 'view',
//    'create' => 'create',
//    'store' => 'create',
//    'update' => 'update',
//    'edit' => 'update',
//    'destroy' => 'delete'
//]

class PostController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth')->only(['create' , 'store' , 'edit' , 'update' , 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */

    public function index()
    {
//        DB::connection()->enableQueryLog();
//        $posts = BlogPost::with('comments')->get();
//        foreach($posts as $post) {
//            foreach ($post->commepnts as $comment){
//                echo $comment->content;
//            }
//        }
//        dd(DB::getQueryLog());



        return view('posts.index' , [
            'posts' => BlogPost::latestWithRelations()->get()
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePost $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        $blogPost = BlogPost::create($validatedData);

        $request->session()->flash('success' , 'Blog post was created.');

        return redirect()->route('posts.show' , ['post' => $blogPost->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request ,$id)
    {
//        $request->session()->reflash();
//        return view('posts.show' , ['post' => BlogPost::with(['comments' => function($query){
//            return $query->latest();
//        }])->findorFail($id)]);

        // the default scale for time is minutes.
        $blogPost = Cache::tags(['blog-posts'])->remember("blog-post-{$id}" , 60 , function () use($id){
            return BlogPost::with('comments' , 'tags' , 'user' , 'comments.user')->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = "blog-posts-{$id}-counter";
        $usersKey = "blog-posts-{$id}-users";

        $users = Cache::tags(['blog-posts'])->get($usersKey , []);
        $usersUpdate = [];
        $difference =0;
        $now = now();

        foreach ($users as $session => $lastVisit){
            if($now->diffInMinutes($lastVisit) >= 1){
                $difference--;
            }
        }

        if(!array_key_exists($sessionId , $users) or $now->diffInMinutes($users[$sessionId]) >=1 ){
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::tags(['blog-posts'])->forever($usersKey , $usersUpdate);

        if(!Cache::tags(['blog-posts'])->has($counterKey)){
            Cache::tags(['blog-posts'])->forever($counterKey , 1);
        }else{
            Cache::tags(['blog-posts'])->increment($counterKey , $difference);
        }

        $counter = Cache::tags(['blog-posts'])->get($counterKey);

        return view('posts.show' , [
            'post' => $blogPost,
            'counter' => $counter
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

//        if(Gate::denies('update-post' , $post)){
//            abort(403 , "You can't edit this post");
//        }
        $this->authorize($post);

        return view('posts.edit' , ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

//        if(Gate::denies('update-post' , $post)){
//            abort(403 , "You can't edit this post");
//        }
        $this->authorize($post);
        $validatedData = $request->validated();

        $post->fill($validatedData);
        $post->save();
        $request->session()->flash('success' , 'Blog post has updated.');

        return redirect()->route('posts.show' , ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request  $request, $id)
    {

        $post = BlogPost::findOrFail($id);
//        if(Gate::denies('update-post' , $post)){
//            abort(403 , "You can't delete this post");
//        }

        $this->authorize($post);
        $post->delete();

//        dd('gjhkhk');
//        BlogPost::destroy($id);

        $request->session()->flash('success' , 'Post has deleted');

        return redirect()->route('posts.index');

    }
}
