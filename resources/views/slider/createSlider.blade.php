@extends('layouts.tema')
@section('head')
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section('menuSlider', 'active')
@section('content')
    <div class="section-header sticky-top">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Tambah Slider</h1>
                </div>
            </div>
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb  bg-white mb-n2">
                        <li class="breadcrumb-item"> <a href="{{ route('slider') }}"> Slider </a></li>
                        <li class="breadcrumb-item" aria-current="page"> Tambah </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Alert --}}
    <div class="row">
        <div class="col-12">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible show fade">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-warning alert-dismissible show fade">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Slider</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('simpanSlider') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul </label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                                    id="judul">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar</label>
                            <div class="col-sm-12 col-md-7">

                                <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar"
                                    value="{{ old('gambar') }}" id="gambar">
                                @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Teks / Keterangan</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea name="text" id="editor"></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">link</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('link') is-invalid @enderror" name="link"
                                    id="link">
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Publikasi</label>
                            <div class="col-sm-12 col-md-7">
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="privat" class="selectgroup-input"
                                        onclick="hideTanggal()">
                                    <span class="selectgroup-button">Private</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="publik" class="selectgroup-input"
                                        onclick="addTanggal()">
                                    <span class="selectgroup-button">Public</span>
                                </label>
                                @error('statusPembelian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
