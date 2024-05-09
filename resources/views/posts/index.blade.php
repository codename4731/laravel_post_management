<!-- resources/views/posts/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mb-3">All Posts</h1>
        </div>
        @if(Auth::check() && Auth::user()->isAdmin())
        <div class="col-auto">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Create Post</a>
        </div>
        @endif
    </div>

    <div class="row">
        @foreach ($posts as $post)
        <div class="col-md-4 mb-4">
            <div class="card">
                @if ($post->image)
                <img class="card-img-top" src="{{ asset('storage/' . $post->image) }}" alt="Post Image">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ $post->content }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-primary">View Post</a>
                        @if(Auth::check() && Auth::user()->isAdmin())
                        <div>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center pagination-lg">
            <li class="page-item {{ $posts->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $posts->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            @if($posts->currentPage() > 1)
            <li class="page-item"><a class="page-link" href="{{ $posts->url($posts->currentPage() - 1) }}">{{ $posts->currentPage() - 1 }}</a></li>
            @endif

            <li class="page-item active"><a class="page-link" href="#">{{ $posts->currentPage() }}</a></li>

            @if($posts->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $posts->nextPageUrl() }}">{{ $posts->currentPage() + 1 }}</a></li>
            @endif

            <li class="page-item {{ !$posts->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $posts->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
@endsection