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
            <form action="{{ route('users.update', ['id' => $users->id]) }}" method="POST">
                @csrf
                @method("PUT")
                <div class="form-group mb-3">
                    <label for="" class="mb-2">Full Name</label>
                    <input value="{{ $users->name }}" type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="" class="mb-2">Email Address</label>
                    <input value="{{ $users->email }}" type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <button type="reset" class="btn btn-secondary float-left">Reset</button>
                <button type="submit" class="btn btn-primary float-right">Save</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    
@endpush