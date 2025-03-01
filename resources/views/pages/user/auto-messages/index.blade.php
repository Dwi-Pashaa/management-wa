@extends('layouts.app')

@section('title')
    Auto Messages
@endsection

@push('css')
    
@endpush    

@section('content')
    @include('components.alert-success')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('auto.message.create') }}" class="btn btn-primary">
                        <i class="feather icon-plus"></i>
                        Add Auto Message
                    </a>
                </div>
                <div>
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="submit"><i class="feather icon-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($autoMessage as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td style="width: 10%">
                                    <form action="{{ route('auto.message.updateStatus', ['id' => $item->id]) }}" method="POST" id="formStatus">
                                        @csrf
                                        @method("PUT")
                                        <div class="form-group mb-3">
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Deactive</option>
                                            </select>
                                        </div>
                                    </form>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y - H:i:s') }}</td>
                                <td>
                                    <a href="{{ route('auto.message.edit', ['id' => $item->id]) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="return deleteAutoMessage('{{ $item->id }}')" class="btn btn-danger btn-sm" title="Delete">
                                        <i class="feather icon-trash-2"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No Auto Messages</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const BASE = "{{ route('auto.message.index') }}";

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

        function deleteAutoMessage(id) {
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

        $("#status").change(function() {
            $("#formStatus").submit()
        })
    </script>
@endpush