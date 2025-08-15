@extends('layouts.app')

@section('title', 'تعديل التعليق')

@section('content')
    <div class="container mt-4">
        <h3>تعديل التعليق</h3>

        <form action="{{ route('comments.update', $comment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="4"
                    required>{{ old('content', $comment->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">تحديث التعليق</button>
            <a href="{{ route('posts.show', $comment->post_id) }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
@endsection
