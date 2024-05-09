<!-- resources/views/posts/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">{{ $post->title }}</h2>
            @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="Post Image">
            @endif
            <p class="card-text">{{ $post->content }}</p>
        </div>
    </div>
</div>
@endsection