<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Models\User;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::middleware('guest')->group(function (){
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware("auth")->group(function () {
    Route::get('/posts', [PostController::class , 'index'])->name('posts.index');
    Route::get('/posts/create',[PostController::class , 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class , 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', function ($post) {
        $post = \App\Models\Post::findOrFail($post);
        return app(PostController::class)->edit($post);
    })->name('posts.edit');
    Route::put('/posts/{post}', function ($post) {
        $post = \App\Models\Post::findOrFail($post);
        return app(PostController::class)->update(request(), $post);
    })->name('posts.update');
    Route::delete('/posts/{post}', function ($post) {
        $post = \App\Models\Post::findOrFail($post);
        return app(PostController::class)->destroy($post);
    })->name('posts.destroy');
    Route::get('/posts/{post}', function ($post) {
        $post = \App\Models\Post::with(['user', 'category', 'tags', 'comments.user'])->findOrFail($post);
        return app(PostController::class)->show($post);
    })->name('posts.show');
    Route::post('/posts/{post}/comments', function ($post) {
        $post = \App\Models\Post::findOrFail($post);
        return app(CommentController::class)->store(request(), $post);
    })->name('comments.store');
    Route::get('/comments/{comment}/edit', function ($comment) {
        $comment = \App\Models\Comment::findOrFail($comment);
        return app(CommentController::class)->edit($comment);
    })->name('comments.edit');
    Route::put('/comments/{comment}', function ($comment) {
        $comment = \App\Models\Comment::findOrFail($comment);
        return app(CommentController::class)->update(request(), $comment);
    })->name('comments.update');
    Route::delete('/comments/{comment}', function ($comment) {
        $comment = \App\Models\Comment::findOrFail($comment);
        return app(CommentController::class)->destroy($comment);
    })->name('comments.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
