@extends('layouts.app')

@section('title')
    Change Password
@endsection

@push('css')
    
@endpush    

@section('content')
    @include('components.alert-success')

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('change.password.update', ['id' => Auth::user()->id]) }}" method="POST">
                @csrf
                @method("PUT")
                <div class="form-group mb-3">
                    <label for="" class="mb-2">Old Password</label>
                    <input type="password" name="password_old" id="password_old" class="form-control @error('password_old') is-invalid @enderror">
                    @error('password_old')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="" class="mb-2">New Password</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="" class="mb-2">Confirmation Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                    @error('password_confirmation')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary float-right">Save</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    
@endpush