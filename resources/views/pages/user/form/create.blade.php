@extends('layouts.app')

@section('title')
    Create Form
@endsection

@push('css')
    
@endpush    

@section('content')
    @include('components.alert-success')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('form.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="">Form Type</label>
                    <select name="subscriptions_id" id="subscriptions_id" class="form-control @error('subscriptions_id') is-invalid @enderror">
                        <option value="">- Select -</option>
                        @foreach ($subscribtion as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('subscriptions_id')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="">Title Form</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
                    @error('title')
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