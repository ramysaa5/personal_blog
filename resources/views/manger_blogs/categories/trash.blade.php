@extends('manger_blogs.master')
@section('title', 'Trash categories')

@section('content')
    <div class="container">
        <h1> Trash categories</h1>

        @if (session('msg'))
            <div class="alert alert-{{ session('type') }}" role="alert">
                {{ session('msg') }}
            </div>
        @endif
        <table class="table table-bordered text-center">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>

            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('admin.categories.restore', $category->id) }}"><i
                                class="fa-solid fa-trash-arrow-up"></i></a>
                        <form class="d-inline" action="{{ route('admin.categories.forcedelete', $category->id) }}"
                            method="POST">
                            @csrf
                            @method('delete')
                            <button onclick="return confirm('Are you Suer??!')" class="btn btn-danger btn-sm"
                                href=""><i class="fas fa-trash"></i></button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan=3 style='text-align: center;'>No Data In Trash Found!</td>
                </tr>
            @endforelse

        </table>
        {{ $categories->links() }}
    </div>
@endsection
