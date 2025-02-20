@extends('layouts.app')

@section('title')
    {{ $subscription->title }}
@endsection

@push('css')
    
@endpush    

@section('content')

@include('components.alert-error')
@include('components.alert-success')

<form action="{{ route('subscription.bulkInsert') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="feather icon-plus"></i>
                        Add User
                    </button>
                </div>
                <div>
                    {{ $user->links() }}
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>
                                <div class="chk-option">
                                    <label class="check-task custom-control custom-checkbox d-flex justify-content-center done-task">
                                        <input id="checkAll" type="checkbox" class="custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                </div>
                            </th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" name="limit" id="limit" value="{{ $subscription->limit }}">
                        <input type="hidden" name="subscriptions_id" id="subscriptions_id" value="{{ $subscription->id }}">
                        @forelse ($user as $item)
                            <tr>
                                <td>
                                    <div class="chk-option">
                                        <label class="check-task custom-control custom-checkbox d-flex justify-content-center done-task">
                                            <input value="{{ $item->id }}" name="users_id[]" type="checkbox" class="custom-control-input checkItem">
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="3">No Users</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div>
                <b>Subscribtion</b>
            </div>
            <div>
                {{ $subscriptionUser->links() }}
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Limit</th>
                        <th>Used</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subscriptionUser as $su)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $su->user->name }}</td>
                            <td>{{ $su->user->email }}</td>
                            <td>{{ $su->limit }}</td>
                            <td>{{ $su->used }}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="return removeSubcribtion('{{ $su->id }}')" class="btn btn-danger btn-sm mb-3">
                                    <i class="feather icon-trash-2"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Subcribtions</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const BASE = "{{ route('subscription.index') }}";

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

        function removeSubcribtion(subscription_id) {
            Swal.fire({
                title: "Warning !",
                text: "Are you sure removed this user?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: BASE + '/' + subscription_id + '/removeSubscribtion',
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

        $(document).ready(function() {
            $("#checkAll").change(function() {
                $(".checkItem").prop("checked", $(this).prop("checked"));
            });

            $(".checkItem").change(function() {
                if ($(".checkItem:checked").length === $(".checkItem").length) {
                    $("#checkAll").prop("checked", true);
                } else {
                    $("#checkAll").prop("checked", false);
                }
            });
        });
    </script>
@endpush