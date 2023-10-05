@extends('manger_blogs.master')
@section('title', 'All articles')

@section('content')
    <div class="container">
        <h1> All articles</h1>

        {{-- @if (session('msg'))
            <div class="alert alert-{{ session('type') }}" role="alert">
                {{ session('msg') }}
            </div>
        @endif --}}
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
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $article->title }}</td>
                    <td style="width: 373px">{{ Str::words($article->content, 5, '...') }}</td>
                    <td><img width="80" src="{{ $article->image }}" alt=""></td>
                    <td>{{ $article->user->id }}</td>
                    <td>{{ $article->category->name ?? 'Opes Category Deleted' }}</td>
                    <td style="width: 150px">
                        <a class="btn btn-info btn-sm" href="{{ route('admin.articles.edit', $article->id) }}"><i
                                class="fas fa-edit"></i></a>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.articles.show', $article->id) }}"><i
                                class="fas fa-eye"></i></a>
                        <form class="d-inline" action="{{ route('admin.articles.destroy', $article->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="button" onclick="deleteArticle(event)" class="btn btn-danger btn-sm"
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

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        @if (session('msg'))
            Toast.fire({
                icon: "{{ session('type') }}",
                title: "{{ session('msg') }}"
            })
        @endif

        function deleteArticle(e) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = e.target.closest('form').action
                    axios.post(url, {
                        _method: 'delete'
                    }).then(res => {
                        Toast.fire({
                            icon: "success",
                            title: "Article Deleted successfully"
                        })

                        e.target.closest('tr').remove()
                    })
                }
            })
        }
    </script>
@endsection
