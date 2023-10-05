@extends('manger_blogs.master')
@section('title', 'All Tags')

@section('content')
    <div class="container">
        <h1> All Tags</h1>

        {{-- @if (session('msg'))
            <div class="alert alert-{{ session('type') }}" role="alert">
                {{ session('msg') }}
            </div>
        @endif --}}
        <table class="table table-bordered text-center">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>

            @forelse ($tags as $tag)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tag->name }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('admin.tags.edit', $tag->id) }}"><i
                                class="fas fa-edit"></i></a>
                        <form class="d-inline" action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="button" onclick="deleteArticle(event)" class="btn btn-danger btn-sm"
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
