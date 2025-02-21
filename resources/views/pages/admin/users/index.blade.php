@extends('layouts.app')

@section('title')
    Manage Users 
@endsection

@push('css')
    
@endpush    

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="feather icon-plus"></i>
                Add User
            </a>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <select name="sort" id="sort" class="form-control">
                        <option value="10" {{ request('sort') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('sort') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('sort') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('sort') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                <div>
                    <form>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="submit"><i class="feather icon-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @include('components.alert-success')

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <a href="{{ route('users.edit', ['id' => $item->id]) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                    <a href="{{ route('user.forgot', ['id' => $item->id]) }}" class="btn btn-info btn-sm" title="Change Password">
                                        <i class="feather icon-lock"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="return deleteUsers('{{ $item->id }}')" class="btn btn-danger btn-sm" title="Delete">
                                        <i class="feather icon-trash-2"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty 
                            <tr>
                                <td colspan="4" class="text-center">No Users</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>

                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const BASE = "{{ route('users.index') }}";
        let params = new URLSearchParams(window.location.search);

        $("#sort").change(function() {
            params.set('sort', $(this).val());
            window.location.href = BASE + '?' + params.toString();
        });

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        function deleteUsers(id) {
            Swal.fire({
                title: "Warning !",
                text: "Are you sure deleted this data?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: BASE + '/' + id + '/destroy',
                        method: "DELETE",
                        dataType: "json",
                        success: function(response) {
                            Toast.fire({
                                icon: response.status,
                                title: response.message
                            });

                            setTimeout(() => {
                                window.location.reload();
                            }, 3000);
                        },
                        error: function(err) {
                            Toast.fire({
                                icon: "error",
                                title: "Server Error"
                            });
                            console.log(err);
                        }
                    })
                }
            });
        }
    </script>
@endpush