@extends('layouts.app')

@section('title')
    Set Api Key Watsaapmatic
@endsection

@push('css')
    
@endpush    

@section('content')
    @include('components.alert-success')

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                @if ($apikey == null)
                    <div>
                        <a href="{{ route('apikey.create') }}" class="btn btn-primary">
                            <i class="feather icon-plus"></i>
                            Add Api Key
                        </a>
                    </div>
                @endif
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
                            <th>Key Name</th>
                            <th>Created</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($apikey != null)
                            <tr>
                                <td>1</td>
                                <td>{{ $apikey->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($apikey->created_at)->format('d-m-Y - H:i:s') }}</td>
                                <td>
                                    <a href="{{ route('apikey.show', ['id' => $apikey->id]) }}" class="btn btn-success btn-sm" title="Connect To Whatsaap">
                                        <i class="feather icon-message-square"></i>
                                    </a>
                                    <a href="{{ route('apikey.edit', ['id' => $apikey->id]) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="feather icon-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="return deletApiKey('{{ $apikey->id }}')" class="btn btn-danger btn-sm" title="Delete">
                                        <i class="feather icon-trash-2"></i>
                                    </a>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="4" class="text-center">No Secret Key</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Key Name</th>
                            <th>Created</th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <b>Device Connected</b>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Whatsaap ID</th>
                            <th>Unique</th>
                            <th>Status</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $device = is_array($device) && isset($device['data']) && !empty($device['data']) ? $device['data'] : $device;
                        @endphp
                        @if ($deviceCount > 0)
                            @forelse ($device as $dc)
                                <tr>
                                    <td>1</td>
                                    <td>{{ $dc['phone'] }}</td>
                                    <td>{{ $dc['unique'] }}</td>
                                    <td>
                                        @if ($dc['status'] === 'connected')
                                            <span class="badge bg-success text-white">
                                                {{ $dc['status'] }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger text-white">
                                                {{ $dc['status'] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('apikey.relink', ['id' => $apikey->id, 'unique' => $dc['unique']]) }}" class="btn btn-primary btn-sm" title="Relink Whatssap Account">
                                            <i class="feather icon-refresh-cw"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="4">No Device Connected</td>
                                </tr>
                            @endforelse
                        @else
                            <tr>
                                <td class="text-center" colspan="4">No Device Connected</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Whatsaap ID</th>
                            <th>Unique</th>
                            <th>Status</th>
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
        const BASE = "{{ route('apikey.index') }}";

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

        function deletApiKey(id) {
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