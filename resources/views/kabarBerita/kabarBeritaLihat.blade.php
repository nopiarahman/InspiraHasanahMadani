@extends('layouts.tema')\
@section('head')
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuPengadaan','active')
@section ('menuDaftarBarang','active')
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Lihat Kabar Berita</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item"> <a href="{{route('kabarBerita')}}"> Kabar Berita </a></li>
            <li class="breadcrumb-item" aria-current="page"> Lihat </li>
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
            <h4>Lihat Kabar Berita</h4>
          </div>
          <div class="card-body">
          <form action="{{route('kabarBeritaUpdate',['id'=>$id->id])}}" method="POST" enctype="multipart/form-data" onchange="rubah()">
            @csrf
            
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{$id->judul}}" id="judul">
                @error('judul')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Isi</label>
              <div class="col-sm-12 col-md-7">
                <textarea name="isi" id="editor">{{$id->isi}}</textarea>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto</label>
              <div class="col-sm-12 col-md-7">
                @if($id->thumbnail)
                  <img src="{{Storage::url($id->thumbnail)}}" alt="" width="200px">
                @endif
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Ganti Foto</label>
              <div class="col-sm-12 col-md-7">
                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" value="{{old('thumbnail')}}" id="thumbnail">
                @error('thumbnail')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
              <div class="col-sm-12 col-md-7">
                <a href="{{route('kabarBerita')}}" class="btn btn-secondary" type="submit" id="btn-update">Kembali</a>
                <button class="btn btn-primary" type="submit" id="btn-update">Update</button>
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
        .create( document.querySelector( '#editor' ))
        .catch( error => {
            console.error( error );
        } );
function rubah(){
      document.getElementById('btn-update').disabled=false;

    }
</script>
  @endsection