@extends('client.master');

@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <div class="card mb-3">
            <img height="400px" src="{{ $article->image }}" class="card-img-top" alt="...">
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
                <p class="card-text"><small class="text-muted">Last Created
                        {{ $article->created_at->diffForHumans() }}</small>
                </p>
                {{-- <a class="btn btn-info w-25 hi" href="{{ route('show', $article->id) }}"> Show</a> --}}
            </div>
        @endsection
