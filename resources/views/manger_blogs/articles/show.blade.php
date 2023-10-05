@extends('manger_blogs.master')
@section('title', 'Show Articles')

@section('content')
    <div class="container">

        <h1> Show Article</h1>
        <div class="card mb-3">
            <img src="{{ $article->image }}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{ $article->title }}</h5>
                <p class="card-text">{{ $article->content }}</p>
                <br>
                @if ($article->tags->count() > 0)
                    Tags:
                    @foreach ($article->tags as $tag)
                        <span class="badge bg-dark color-white">#{{ $tag->name }}</span>
                    @endforeach
                @endif
                <p class="card-text"><small class="text-muted">Create Last
                        {{ $article->created_at->diffForHumans() }}</small>
                </p>
            </div>
        </div>
    </div>
@endsection
