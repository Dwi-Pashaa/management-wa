@extends('layouts.app')

@section('title')
    {{ $users->name }}
@endsection

@push('css')
    
@endpush    

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                <i class="feather icon-arrow-left"></i>
                Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('user.change', ['id' => $users->id]) }}" method="POST">
                @csrf
                @method("PUT")
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