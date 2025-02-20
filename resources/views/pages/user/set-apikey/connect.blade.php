@extends('layouts.app')

@section('title')
    {{ $apikey->name }}
@endsection

@push('css')
    
@endpush    

@section('content')
    @php
        $datas = is_array($data) && isset($data['data']) && !empty($data['data']) ? $data['data'] : $data;
    @endphp

    <div class="row d-flex justify-content-center">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="alert alert-info">
                <b>
                    Please scan the QR below via WhatsApp. When you have finished scanning, please refresh the page so that the status changes
                </b>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <b>QrCode Whatsaap</b>
                </div>
                <div class="card-body">
                    @if ($data['status'] == 200)
                        <img src="{{ $datas['qrimagelink'] }}" style="width: 100%" alt="">
                    @elseif($data['status'] == 400)
                        <div class="alert alert-info">
                            <b>
                                You have connected with WhatsApp, <a href="{{ route('apikey.index') }}" class="text-info">Go back</a>
                            </b>
                        </div>
                    @elseif($data['status'] == 401)
                        <div class="alert alert-danger">
                            <b>
                                {{ $data['message'] }}, <a href="{{ route('apikey.index') }}" class="text-info">Go back</a>
                            </b>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    
@endpush