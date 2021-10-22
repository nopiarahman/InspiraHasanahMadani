@extends('layouts.tema')
@section('head')
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js" integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuProyekWeb','active')
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>{{$id->nama}}</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item"> <a href="{{route('proyekWeb')}}"> Proyek </a></li>
            <li class="breadcrumb-item" aria-current="page"> Detail </li>
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
          {{session ('status')}}
        </div>
      @endif
      @if (session('error'))
        <div class="alert alert-warning alert-dismissible show fade">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          {{session ('error')}}
        </div>
      @endif
    </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Detail Proyek</h4>
            <button class="btn btn-primary ml-2" onclick="tampilFormFoto()" > <i class="fas fa-camera    "></i> Tambah Foto/Galeri</button>
            <script>
              function tampilFormFoto(){
                var formRAB = document.querySelector('.formUpdate');
                formRAB.className ='card-body formUpdate d-none';
        
                var formBiayaUnit = document.querySelector('.formFoto');
                formBiayaUnit.className ='card-body formFoto';
        
              }
            </script>
          </div>
          <div class="card-body formUpdate" id="formUpdate">
          <form action="{{route('proyekWebUpdate',['id'=>$id->id])}}" method="POST" enctype="multipart/form-data">
            @method('patch')
            @csrf
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Proyek</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{$id->nama}}" id="nama">
                @error('nama')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Lokasi Proyek</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" value="{{$id->lokasi}}" id="lokasi">
                @error('lokasi')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Logo</label>
              <div class="col-sm-12 col-md-7">
                <img src="{{Storage::url($id->logo)}}" alt="" style="max-width: 200px">
                <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" value="{{old('logo')}}" id="logo">
                @error('logo')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Cover</label>
              <div class="col-sm-12 col-md-7">
                <img src="{{Storage::url($id->cover)}}" alt="" style="max-width: 200px">
                <input type="file" class="form-control @error('cover') is-invalid @enderror" name="cover" value="{{old('cover')}}" id="cover">
                @error('cover')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Detail</label>
              <div class="col-sm-12 col-md-7">
                <textarea name="detail" id="editor">{{$id->detail}}</textarea>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mulai Proyek</label>
              <div class="col-sm-12 col-md-7">
                <input type="date" class="form-control @error('proyekStart') is-invalid @enderror" name="proyekStart" value="{{$id->proyekStart}}" id="proyekStart">
                @error('proyekStart')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Publikasi</label>
              <div class="col-sm-12 col-md-7">
                <label class="selectgroup-item">
                  <input type="radio" name="status" value="privat" class="selectgroup-input" @if($id->status==="privat") checked @endif>
                  <span class="selectgroup-button">Private</span>
                </label>
                <label class="selectgroup-item">
                  <input type="radio" name="status" value="publik" class="selectgroup-input" @if($id->status==="publik") checked @endif>
                  <span class="selectgroup-button">Public</span>
                </label>
                @error('publikasi')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
              <div class="col-sm-12 col-md-7">
                <button class="btn btn-primary" type="submit">Update</button>
              </div>
            </div>
          </form>
          </div>
          <div class=" card-body formFoto d-none" id="formFoto">
            <form action="{{route('galeriProyek',['id'=>$id->id])}}"
              class="dropzone"
              id="my-awesome-dropzone" method="POST" enctype="multipart/form-data">
            @csrf
            </form>
          <div class="alert alert-info">
            <p class="text-center">Refresh Halaman ini untuk melihat Foto yang telah diupload</p>
          </div>
          </div>
          <div class="card-header">
            <h4>Galeri Proyek</h4>
          </div>
          <div class="card-body">
            <div class="d-flex flex-wrap">
            @foreach($id->galeri as $galeri)
              <form action="{{route('hapusGaleriProyek',['id'=>$galeri->id])}}" method="POST" enctype="multipart/form-data">
                @method('delete')
                @csrf
                <div class="boxGaleri">
                  <img src="{{Storage::url($galeri->path)}}" alt="" style="max-width: 200px">
                  <div class="overlay"></div>
                  <button class="button btn btn-sm btn-danger"><i class="fas fa-trash    "></i>Hapus</button>
                </div>
              </form>
              @endforeach
            </div>
          </div>
          <div class="card-footer">

            <button class="btn btn-secondary" onclick="kembali()">Batal</button>
          </div>
            <script>
              function kembali(){
                var formRAB = document.querySelector('.formUpdate');
                formRAB.className ='card-body formUpdate ';
        
                var formBiayaUnit = document.querySelector('.formFoto');
                formBiayaUnit.className ='card-body formFoto d-none';
              }
            </script>
          
        </div>
      </div>
    </div>
  @endsection
  @section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js" integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    ClassicEditor
        .create( document.querySelector( '#editor' ))
        .catch( error => {
            console.error( error );
        } );
</script>
  @endsection