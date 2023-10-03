@extends('manger_blogs.master')
@section('title', 'All articles')

@section('content')
    <div class="container">
        <h1> All articles</h1>

        @if (session('msg'))
            <div class="alert alert-{{ session('type') }}" role="alert">
                {{ session('msg') }}
            </div>
        @endif
        <table class="table table-bordered text-center">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Image</th>
                <th>Created By</th>
                <th>Category Name</th>
                <th>Action</th>
            </tr>

            @forelse ($articles as $article)
                {{-- @dd($article) --}}
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ Str::words($article->content, 5, '...') }}</td>
                    <td><img src="{{ $article->image }}" alt=""></td>
                    <td>{{ $article->user_id }}</td>
                    <td>{{ $article->category_id }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('admin.articles.edit', $article->id) }}"><i
                                class="fas fa-edit"></i></a>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.articles.show', $article->id) }}"><i
                                class="fas fa-eye"></i></a>
                        <form class="d-inline" action="{{ route('admin.articles.destroy', $article->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button onclick="return confirm('Are you Suer??!')" class="btn btn-danger btn-sm"
                                href=""><i class="fas fa-trash"></i></button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan=10 style='text-align: center;'>No Data Found!</td>
                </tr>
            @endforelse

        </table>
        {{ $articles->links() }}
    </div>
@endsection
