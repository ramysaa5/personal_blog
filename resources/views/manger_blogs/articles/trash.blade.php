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
                <th>Deleted By</th>
                <th>Deleted At</th>
                <th>Category Name</th>
                <th>Action</th>
            </tr>

            @forelse ($articles as $article)
                {{-- @dd($article) --}}
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ Str::words($article->content, 5, '...') }}</td>
                    <td>{{ $article->user->id }}</td>
                    <td>{{ $article->deleted_at->diffForHumans() }}</td>
                    <td>{{ $article->category->name ?? 'Opes Category Deleted' }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('admin.articles.restore', $article->id) }}"><i
                                class="fas fa-trash-arrow-up"></i></a>
                        <form class="d-inline" action="{{ route('admin.articles.forcedelete', $article->id) }}" method="POST">
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
