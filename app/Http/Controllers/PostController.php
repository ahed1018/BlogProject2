<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category', 'tags'])->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->load(['user', 'category', 'tags', 'comments.user']);
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required', 'min:5'],
            'category_input' => ['required', 'string'],
            'tags_input' => ['nullable', 'string'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $categoryNames = array_filter(array_map('trim', explode(',', $request->category_input)));
        if (count($categoryNames) > 1) {
            return back()->withInput()->withErrors([
                'category_input' => 'Only one category is allowed. Please enter a single category.',
            ]);
        }

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
        }

        $category = Category::firstOrCreate(['name' => $categoryNames[0]]);

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
            'user_id' => session('user_id'),
            'category_id' => $category->id,
        ]);

        if ($request->filled('tags_input')) {
            $tagNames = array_map('trim', explode(',', $request->tags_input));
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                if ($tagName !== '') {
                    $tag = Tag::firstOrCreate(['name' => $tagName]);
                    $tagIds[] = $tag->id;
                }
            }
            $post->tags()->attach($tagIds);
        }

        return to_route('posts.index')->with('success', 'تم إنشاء البوست بنجاح');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        $postCategory = $post->category ? $post->category->name : '';
        $postTags = $post->tags->pluck('name')->implode(', ');

        return view('posts.edit', compact('post', 'categories', 'tags', 'postCategory', 'postTags'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_input' => ['required', 'string'],
            'tags_input' => ['nullable', 'string'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ], [
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 5 ميغابايت.',
        ]);

        $categoryNames = array_filter(array_map('trim', explode(',', $request->category_input)));
        if (count($categoryNames) > 1) {
            return back()->withInput()->withErrors([
                'category_input' => 'Only one category is allowed. Please enter a single category.',
            ]);
        }

        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path('uploads/' . $post->image))) {
                unlink(public_path('uploads/' . $post->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);

            $post->image = $imageName;
        }

        $category = Category::firstOrCreate(['name' => $categoryNames[0]]);

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $category->id,
        ]);

        if ($request->filled('tags_input')) {
            $tagNames = array_map('trim', explode(',', $request->tags_input));
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                if ($tagName !== '') {
                    $tag = Tag::firstOrCreate(['name' => $tagName]);
                    $tagIds[] = $tag->id;
                }
            }
            $post->tags()->sync($tagIds);
        } else {
            $post->tags()->sync([]);
        }

        return redirect()->route('posts.show', $post->id)->with('success', 'تم تحديث التدوينة بنجاح');
    }

    public function destroy(Post $post)
    {
        if ($post->image && file_exists(public_path('uploads/' . $post->image))) {
            unlink(public_path('uploads/' . $post->image));
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'تم حذف التدوينة بنجاح');
    }
}
