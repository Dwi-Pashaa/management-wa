@extends('layouts.app')

@section('title')
    Add Subsscribtion
@endsection

@push('css')
    
@endpush    

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('subscription.index') }}" class="btn btn-secondary btn-sm">
                <i class="feather icon-arrow-left"></i>
                Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('subscription.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="" class="mb-2">Title Subscribtion</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
                    @error('title')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="" class="mb-2">Limit</label>
                    <input type="number" name="limit" id="limit" class="form-control @error('limit') is-invalid @enderror">
                    @error('limit')
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