@extends('layouts.app')

@section('title') Index @endsection

@section('content')
    <div class="text-center mb-4">
        <a href="{{ route('posts.create') }}" class="btn btn-success">Create Post</a>
    </div>

    <div class="container">
        <div class="row">
            @foreach($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($post->image)
                            <img src="{{ asset('uploads/' . $post->image) }}" class="card-img-top" alt="Post Image"
                                style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">
                                <strong>Posted By:</strong> {{ $post->user ? $post->user->name : 'not found' }}<br>
                                <strong>Date:</strong> {{ $post->created_at->format('Y-m-d') }}
                            </p>
                            <div class="mt-auto">
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
