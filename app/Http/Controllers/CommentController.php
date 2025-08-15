<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|min:1',
        ]);

        $user = auth()->user();
        Comment::create([
            'content' => $request->content,
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', 'تم إضافة التعليق بنجاح');
    }

    public function edit(Comment $comment)
    {
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|min:1',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('posts.show', $comment->post_id)->with('success', 'تم تحديث التعليق بنجاح');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('posts.show', $comment->post_id)->with('success', 'تم حذف التعليق بنجاح');
    }
}
