@extends('layouts.tema')
@section('menuProyek', 'active')
@section('content')

    <div class="section-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Proyek</h1>
                </div>
            </div>
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb  bg-white mb-n2">
                        <li class="breadcrumb-item"> <a href="{{ route('proyek') }}"> Proyek</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Tambah Proyek </li>
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
                <form action="{{ route('proyekSimpan') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4>Data PT Baru</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama PT</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('namaPT') is-invalid @enderror" name="namaPT"
                                    value="{{ old('namaPT') }}">
                                @error('namaPT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('alamatPT') is-invalid @enderror"
                                    name="alamatPT" value="{{ old('alamatPT') }}">
                                @error('alamatPT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Telepon</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('telpPT') is-invalid @enderror" name="telpPT"
                                    value="{{ old('telpPT') }}">
                                @error('telpPT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="email" class="form-control @error('emailPT') is-invalid @enderror"
                                    name="emailPT" value="{{ old('emailPT') }}">
                                @error('emailPT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Logo PT</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="file" class="form-control @error('logoPT') is-invalid @enderror" name="logoPT"
                                    id="logoPT" value="{{ old('logoPT') }}">
                                <img src="" id="img-tag" width="100%">
                                @error('logoPT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <script type="text/javascript">
                                    function readURL(input) {
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();

                                            reader.onload = function(e) {
                                                $('#img-tag').attr('src', e.target.result);
                                            }
                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                    $("#logoPT").change(function() {
                                        readURL(this);
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <h4>Data Proyek Baru</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Proyek</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                    value="{{ old('nama') }}">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Lokasi</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi"
                                    value="{{ old('lokasi') }}">
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Proyek Dimulai</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="date" class="form-control @error('proyekStart') is-invalid @enderror"
                                    name="proyekStart" value="{{ old('proyekStart') }}">
                                @error('proyekStart')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Prefix Proyek</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('prefix') is-invalid @enderror" name="prefix"
                                    value="{{ old('prefix') }}">
                                <div class="feedback"><span>prefix adalah kata awalan untuk username pelanggan di
                                        proyek ini. Contoh prefix="kta" maka username pelanggan+blok = "ktab1",
                                        <strong>prefix tidak boleh sama dengan proyek yang lain</strong></span></div>
                                @error('prefix')
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
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
