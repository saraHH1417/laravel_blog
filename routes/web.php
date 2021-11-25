<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/' , [PostController::class, 'index'])->name('index');
Route::get('/home' , [HomeController::class, 'index'])->name('profile');
Route::get('/contact' , [HomeController::class, 'contact'])->name('contact');
Route::get('/secret' ,[HomeController::class , 'secret'])
            ->name('secret')
            ->middleware('can:home.secret');
//Route::resource('/posts' , 'App\Http\Controllers\PostController')->only(
//                ['index', 'show' ,'create', 'store' , 'edit' , 'update']);
Route::resource('/posts' , 'App\Http\Controllers\PostController');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('tags/{tagId}' , [\App\Http\Controllers\TagController::class , 'index'])->name('tag.index');
Route::resource('posts.comments' , \App\Http\Controllers\PostCommentController::class)->only(['store']);
Route::resource('users.comments' , \App\Http\Controllers\UserCommentController::class)->only(['store']);
Route::resource('users' , \App\Http\Controllers\UserController::class)->only(['show' , 'edit' , 'update']);

Route::get('mailable' , function (){
    $comment = \App\Models\Comments::all()->random()->first();
    return new \App\Mail\CommentPostedMarkdown($comment);
});
