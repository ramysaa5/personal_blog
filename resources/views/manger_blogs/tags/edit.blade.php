@extends('manger_blogs.master')
@section('title', 'Edit Tag')

@section('content')
    <div class="container">
        <h1> Edit Tag</h1>
        <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="mb-3">
                <label> Name </label>
                <input type="text" placeholder="Name" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $tag->name) }}">
                @error('name')
                    <small class="text-dander">{{ $message }}</small>
                @enderror
            </div>
            <button class="btn btn-success w-25"><i class="fas fa-save"></i> Update</button>
        </form>
    </div>
@endsection
