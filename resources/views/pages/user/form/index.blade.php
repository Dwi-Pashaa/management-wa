@extends('layouts.app')

@section('title')
    List Forms
@endsection

@push('css')
    
@endpush    

@section('content')
<div class="card">
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
                        <th>Link</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($forms as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a onclick="copyToClipboard(event, this)" href="{{ route('form.public.show', ['slug_user' => $item->user->slug, 'slug_form' => $item->slug]) }}" class="btn btn-primary btn-sm">
                                    <i class="feather icon-copy"></i>
                                    Copy URL
                                </a>
                            </td>
                            <td>{{ $item->title }}</td>
                            <td>
                                @if ($item->status === 'publish')
                                    <span class="badge bg-info text-white">Publish</span>
                                @else
                                    <span class="badge bg-warning text-white">Draft</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y - H:i:s') }}</td>
                            <td>
                                <a href="{{ route('form.show', ['id' => $item->id, 'slug' => $item->slug]) }}" class="btn btn-info btn-sm" title="Customize Form">
                                    <i class="feather icon-list"></i>
                                </a>
                                {{-- <a href="" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="feather icon-edit"></i>
                                </a> --}}
                                <a href="javascript:void(0)" onclick="return deleteForm('{{ $item->id }}')" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="feather icon-trash-2"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Forms</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Link</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>

            {{ $forms->links() }}
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const BASE = "{{ route('form.index') }}";
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

    function copyToClipboard(event, element) {
        event.preventDefault();
        
        let url = element.getAttribute('href');

        let tempInput = document.createElement("input");
        document.body.appendChild(tempInput);
        tempInput.value = url;
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);

        Toast.fire({
            icon: 'success',
            title: 'Copied URL To Clipboard'
        });
    }

    function deleteForm(id) {
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