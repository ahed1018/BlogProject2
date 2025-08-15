@extends('layouts.app')

@section('title') Edit @endsection

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" type="text" value="{{ old('title', $post->title) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"
                rows="3">{{ old('description', $post->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Category (Only one)</label>
            <input type="text" name="category_input" class="form-control" value="{{ old('category_input', $postCategory) }}"
                placeholder="مثال: Laravel">
            @error('category_input')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Tags (Comma-separated)</label>
            <input type="text" name="tags_input" class="form-control" value="{{ old('tags_input', $postTags) }}"
                placeholder="مثال: PHP, Laravel, برمجة">
        </div>

        @if($post->image)
            <div class="mb-3">
                <label>Current image:</label><br>
                <img src="{{ asset('uploads/' . $post->image) }}" alt="Current Image" width="200">
            </div>
        @endif

        <div class="mb-3">
            <label for="image">Edit image:</label>
            <input type="file" name="image" class="form-control" id="image">
        </div>

        <button class="btn btn-primary">Update</button>
    </form>

@endsection
