@extends('manger_blogs.master')
@section('title', 'Create New Articles')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="container">
        @if (session('msg'))
            <div class="alert alert-{{ session('type') }}" role="alert">
                {{ session('msg') }}
            </div>
        @endif
        <h1> Create New Articles</h1>
        <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label> Title </label>
                <input type="text" placeholder="Title" name="title"
                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $article->title) }}">
                @error('title')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label> Image </label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @error('image')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
                <img width="20%" src="{{ $article->image }}" alt="">
            </div>

            <div class="mb-3">
                <label> Category </label>
                <select name="category" class="form-control @error('category') is-invalid @enderror">
                    <option value="">Select Category</option>
                    @forelse ($categories as $category)
                        <option @selected(old('category', $category->id) == $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
                    @empty
                    @endforelse

                </select>
                @error('category')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label>Tags</label>
                <select class="select-tags form-control @error('tags') is-invalid @enderror" name="tags[]"
                    multiple="multiple">
                    @foreach ($tags as $tag)
                        <option @selected(old('tags', $article->tags)) value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
                @error('tags')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label> Content </label>
                <textarea placeholder="Content" name="content" class="form-control @error('content') is-invalid @enderror"
                    rows="5">{{ old('content', $article->title) }}</textarea>
                @error('content')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>
            <button class="btn btn-success w-25"><i class="fas fa-save"></i> Send</button>
        </form>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select-tags').select2();
        });
    </script>
@endsection
