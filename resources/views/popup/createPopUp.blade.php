@extends('layouts.tema')
@section('head')
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuPopUp','active')
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Edit Pop Up</h1>
        </div>
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
            <h4>Tambah / Edit Pop Up</h4>
          </div>
          <div class="card-body">
          <form action="{{route('popUpSimpan')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul </label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" @if($popup) value="{{$popup->judul}}" @else value="{{old('judul')}}" @endif id="judul">
                @error('judul')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar</label>
              <div class="col-sm-12 col-md-7">
                @if($popup)
                <img src="{{ Storage::url($popup->gambar)}}" alt="" width="200px">
                @endif
                <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar" value="{{old('gambar')}}" id="gambar">
                @error('gambar')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Teks / Keterangan</label>
              <div class="col-sm-12 col-md-7">
                <textarea name="text" id="editor">@if($popup) {!!$popup->text!!} @endif</textarea>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">link</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('link') is-invalid @enderror" name="link"  @if($popup) value="{{$popup->link}}" @else value="{{old('link')}}" @endif  id="link">
                @error('link')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Publikasi</label>
              <div class="col-sm-12 col-md-7">
                <label class="selectgroup-item">
                  <input type="radio" name="status" value="privat" class="selectgroup-input" onclick="hideTanggal()" @if($popup) @if($popup->status=='privat') checked @endif @endif>
                  <span class="selectgroup-button">Private</span>
                </label>
                <label class="selectgroup-item">
                  <input type="radio" name="status" value="publik" class="selectgroup-input" onclick="addTanggal()" @if($popup) @if($popup->status=='publik') checked @endif @endif>
                  <span class="selectgroup-button">Public</span>
                </label>
                @error('statusPembelian')
                <div class="invalid-feedback">{{$message}}</div>
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
        .create( document.querySelector( '#editor' ))
        .catch( error => {
            console.error( error );
        } );
</script>
  @endsection