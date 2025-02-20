@extends('layouts.app')

@section('title')
    Add Api Key Watsaapmatic
@endsection

@push('css')
    
@endpush    

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('apikey.index') }}" class="btn btn-primary btn-sm">
                <i class="feather icon-arrow-left"></i>
                Back
            </a>
        </div>
        <div class="card-body">
           <form action="{{ route('apikey.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="" class="mb-2">Key Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="" class="mb-2">Api Secret Key From Watsaapmatic</label>
                    <input type="text" name="api_secret" id="api_secret" class="form-control @error('api_secret') is-invalid @enderror">
                    @error('api_secret')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="" class="mb-2">Whatsapp Server In Watsaapmatic</label>
                    <select name="whatsapp_server_id" id="whatsapp_server_id" class="form-control @error('whatsapp_server_id') is-invalid @enderror">
                        <option value="">- Select -</option>
                        @php
                            $data = [
                                [
                                    "id" => 1,
                                    "name" => "Free Server"
                                ],
                                [
                                    "id" => 2,
                                    "name" => "Enterprise Server"
                                ]
                            ];
                        @endphp
                        @foreach ($data as $item)
                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    @error('whatsapp_server_id')
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