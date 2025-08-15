@extends('layouts.app')

@section('title') Create @endsection

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

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" type="text" class="form-control" value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Category (Only one)</label>
            <input type="text" name="category_input" class="form-control" value="{{ old('category_input') }}"
                placeholder="مثال: Laravel">
            @error('category_input')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Tags (Comma-separated)</label>
            <input type="text" name="tags_input" class="form-control" value="{{ old('tags_input') }}"
                placeholder="مثال: PHP, Laravel, برمجة">
        </div>

        <div class="form-group mt-3">
            <label for="image">Post Image</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>

        <button class="btn btn-success mt-3">Submit</button>
    </form>

@endsection
