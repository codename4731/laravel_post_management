<!-- resources/views/posts/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Post</h1>
    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{ $post->user_id }}">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}">
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="3">{{ old('content', $post->content) }}</textarea>
            @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            @if ($post->image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image" style="max-width: 200px;">
            </div>
            @endif
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection