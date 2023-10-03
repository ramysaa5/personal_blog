@extends('manger_blogs.master')
@section('title', 'Create New Tag')

@section('content')
    <div class="container">
        @if (session('msg'))
            <div class="alert alert-{{ session('type') }}" role="alert">
                {{ session('msg') }}
            </div>
        @endif
        <h1> Create New Tags</h1>
        <form action="{{ route('admin.tags.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label> Name </label>
                <input type="text" placeholder="Name" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}">
                @error('name')
                    <small class="text-dander">{{ $message }}</small>
                @enderror
            </div>
            <button class="btn btn-success w-25"><i class="fas fa-save"></i> Send</button>
        </form>
    </div>
@endsection
