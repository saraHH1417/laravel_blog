<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
//        DB::connection()->enableQueryLog();
//        $posts = BlogPost::with('comments')->get();
//        foreach($posts as $post) {
//            foreach ($post->comments as $comment){
//                echo $comment->content;
//            }
//        }
//        dd(DB::getQueryLog());
        return view('posts.index' , ['posts' => BlogPost::withCount('comments')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validatedData = $request->validated();
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
        return view('posts.show' , ['post' => BlogPost::with('comments')->findorFail($id)]);
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();

//        BlogPost::destroy($id);
        $request->session()->flash('success' , 'Post has deleted.');

        return redirect()->route('posts.index');

    }
}
