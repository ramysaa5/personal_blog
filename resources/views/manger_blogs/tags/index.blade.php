@extends('manger_blogs.master')
@section('title', 'All Tags')

@section('content')
    <div class="container">
        <h1> All Tags</h1>

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

            @forelse ($tags as $tag)
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td>{{ $tag->name }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('admin.tags.edit', $tag->id) }}"><i
                                class="fas fa-edit"></i></a>
                        <form class="d-inline" action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button onclick="return confirm('Are you Suer??!')" class="btn btn-danger btn-sm"
                                href=""><i class="fas fa-trash"></i></button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan=3 style='text-align: center;'>No Data Found!</td>
                </tr>
            @endforelse

        </table>
        {{ $tags->links() }}
    </div>
@endsection
