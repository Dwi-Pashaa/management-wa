@extends('layouts.app')

@section('title')
    {{ $forms->title }}
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
@endpush    

@section('content')
    <form action="{{ route('form.bulkInsertForm') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="{{ route('form.index') }}" class="btn btn-warning">
                    <i class="feather icon-arrow-left"></i>
                    Back
                </a>
            </div>
            <div>
                <a href="{{ route('form.unpublic.show', ['slug_user' => $forms->user->slug, 'slug_form' => $forms->slug]) }}" target="_blank" class="btn btn-primary">
                    <i class="feather icon-eye"></i>
                    Priview Form
                </a>
                @if ($forms->status === 'publish')
                    <a href="javascript:void(0)" onclick="return unpublish('{{ $forms->id }}')" class="btn btn-secondary">
                        <i class="feather icon-x"></i>
                        Unpublish Form
                    </a>
                @else
                    <a href="javascript:void(0)" onclick="return publish('{{ $forms->id }}')" class="btn btn-info">
                        <i class="feather icon-check-circle"></i>
                        Publish Form
                    </a>
                @endif
            </div>
        </div>

        @include('components.alert-success')
        @include('components.alert-error')

        <div class="card">
            <div class="card-header">
                <b>
                    Form Details
                </b>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="">Title Form</label>
                    <input type="text" name="title" value="{{ $forms->title }}" id="title" class="form-control @error('title') is-invalid @enderror">
                    @error('title')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="">Logo Form</label>
                    <input type="file" name="header" id="header" class="form-control @error('header') is-invalid @enderror">
                    @error('header')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="">Thumbnail Form</label>
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror">
                    @error('thumbnail')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="">Description Form</label>
                    <textarea name="desc" id="desc" class="form-control @error('desc') is-invalid @enderror" cols="30" rows="10">{!! $forms->desc !!}</textarea>
                    @error('desc')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <b>
                            Detail Product
                        </b>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="addProduct">
                            <i class="feather icon-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row" id="appendProduct">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Product Name</label>
                            <input type="text" name="name[]" id="name[]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Stock</label>
                            <input type="number" name="stock[]" id="stock[]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Price</label>
                            <input type="number" name="price[]" id="price[]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Image</label>
                            <input type="file" name="image[]" id="image[]" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-2">
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm w-100">
                            <i class="feather icon-trash"></i>
                            Delete
                        </a>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <b>
                            Add Input
                        </b>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="addInputs">
                            <i class="feather icon-plus"></i>
                            Add Input
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body" id="appendInputs">
                @foreach ($forms->section as $sc)
                    <div class="row">
                        <input type="hidden" name="section_id" id="section_id" value="{{ $sc->id }}">
                        <div class="col-lg-3">
                            <div class="form-group mb-3">
                                <label for="">Input Name</label>
                                <input type="text" name="name[]" value="{{ $sc->name }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group mb-3">
                                <label for="">Input Type</label>
                                <select name="type[]" class="form-control">
                                    <option value="text" {{ $sc->type == 'text' ? 'selected' : '' }}>Text</option>
                                    <option value="number" {{ $sc->type == 'number' ? 'selected' : '' }}>Number</option>
                                    <option value="email" {{ $sc->type == 'email' ? 'selected' : '' }}>Email</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group mb-3">
                                <label for="">Input Is Required</label>
                                <select name="is_required[]" class="form-control">
                                    <option value="yes" {{ $sc->is_required == 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ $sc->is_required == 'no' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3" style="padding-top:30px">
                            <button type="button" class="btn btn-danger w-100 delete-section" data-id="{{ $sc->id }}">
                                <i class="feather icon-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <input type="hidden" name="forms_id" id="forms_id" value="{{ $forms->id }}">
        <button type="submit" class="btn btn-primary w-100">Save</button>
    </form>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#desc').summernote({
            height: 100,
            toolbar: false,
            placeholder: 'Description Form',
        });

        var maxField = 10;
        var addButton = $('#addInputs');
        var wrapper = $('#appendInputs');

        var fieldHTML = `<div class="row">
                            <div class="col-lg-3 mt-3">
                                <div class="form-group mb-3">
                                    <label for="">Input Name</label>
                                    <input type="text" name="name[]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-3">
                                <div class="form-group mb-3">
                                    <label for="">Input Type</label>
                                    <select name="type[]" class="form-control">
                                        <option value="">-Select-</option>
                                        <option value="text">text</option>
                                        <option value="number">number</option>
                                        <option value="email">email</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-3">
                                <div class="form-group mb-3">
                                    <label for="">Input Is Required</label>
                                    <select name="is_required[]" class="form-control">
                                        <option value="">-Select-</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-2" style="padding-top:35px">
                                <a href="javascript:void(0)" class="btn btn-danger w-100 removeField">
                                    <i class="feather icon-trash"></i>
                                    Delete
                                </a>
                            </div>
                        </div>`;

        var x = 1;

        $(addButton).click(function () {
            if (x < maxField) {
                x++;
                $(wrapper).append(fieldHTML);
            } else {
                alert('A maximum of ' + maxField + ' fields are allowed.');
            }
        });

        $(wrapper).on('click', '.removeField', function (e) {
            e.preventDefault();
            $(this).closest(".row").remove();
            x--;
        });

        $(document).on('click', '.delete-section', function () {
            let sectionId = $(this).data('id');
            let url = "{{ route('form.deleteSection', ':id') }}".replace(':id', sectionId);

            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            _method: "DELETE",
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire("Deleted!", response.message, "success");
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        },
                        error: function (xhr) {
                            Swal.fire("Error!", "Failed to delete section.", "error");
                        }
                    });
                }
            });
        });
    });
</script>
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

    function publish(id) {
        $.ajax({
            url: BASE + '/' + id + '/publish',
            method: "PUT",
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

    function unpublish(id) {
        $.ajax({
            url: BASE + '/' + id + '/unpublish',
            method: "PUT",
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
</script>
@endpush