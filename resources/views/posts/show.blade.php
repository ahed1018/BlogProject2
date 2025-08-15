@extends('layouts.app')

@section('title') Show @endsection

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            Post Info
        </div>
        <div class="card-body">
            <h5 class="card-title">Title: {{ $post->title }}</h5>
            <p class="card-text">Description: {{ $post->description }}</p>

            @if($post->category)
                Category: {{ $post->category->name }}
            @else
                <p>No Category</p>
            @endif

            <p class="card-text">
                Tags:
                @forelse($post->tags as $tag)
                    <span class="badge bg-secondary">{{ $tag->name }}</span>
                @empty
                    <span class="text-muted">No tags</span>
                @endforelse
            </p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Post Creator Info
        </div>
        <div class="card-body d-flex align-items-center">
            @if($post->user && $post->user->profile_image)
                <img src="{{ asset('uploads/users/' . $post->user->profile_image) }}" alt="User Image" width="70"
                    class="rounded-circle me-3">
            @else
                <img src="{{ asset('images/default-user.png') }}" alt="Default User Image" width="70"
                    class="rounded-circle me-3">
            @endif
            <div>
                <h5 class="card-title">Name: {{ $post->user ? $post->user->name : 'not found' }}</h5>
                <p class="card-text">Email: {{ $post->user ? $post->user->email : 'not found' }}</p>
                <p class="card-text">Created At: {{ $post->user ? $post->user->created_at : 'not found' }}</p>
            </div>
        </div>
    </div>

    @if($post->image)
        <div class="mt-3">
            <img src="{{ asset('uploads/' . $post->image) }}" alt="Blog Image" width="100%" style="max-width: 600px;">
        </div>
    @endif

    <div class="card mt-4">
        <div class="card-header">
            Comments ({{ $post->comments->count() }})
        </div>
        <div class="card-body">
            @forelse($post->comments as $comment)
                <div class="d-flex mb-4 border rounded p-3 shadow-sm">
                    <div class="flex-shrink-0 me-3">
                        @if($comment->user && $comment->user->profile_image)
                            <img src="{{ asset('uploads/users/' . $comment->user->profile_image) }}" alt="User Image" width="60"
                                class="rounded-circle border">
                        @else
                            <img src="{{ asset('images/default-user.png') }}" alt="Default User Image" width="60"
                                class="rounded-circle border">
                        @endif
                    </div>

                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>{{ $comment->user->name ?? 'Unknown' }}</strong>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mt-2 mb-3">{{ $comment->content }}</p>

                        <div>
                            <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-outline-warning me-2">
                                تعديل
                            </a>

                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline-block"
                                onsubmit="return confirm('هل أنت متأكد من حذف التعليق؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">لا توجد تعليقات حتى الآن.</p>
            @endforelse
        </div>
    </div>

        <div class="card mt-4">
            <div class="card-header">Add Comment</div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('comments.store', $post->id) }}">
                    @csrf
                    <div class="mb-3">
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                            placeholder="Write your comment..." required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Comment</button>
                </form>
            </div>
        </div>
@endsection
