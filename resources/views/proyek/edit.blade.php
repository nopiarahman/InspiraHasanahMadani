@extends('layouts.tema')
@section ('menuProyek','active')
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
          <li class="breadcrumb-item"> <a href="{{route('proyek')}}"> Proyek</a></li>
          <li class="breadcrumb-item active" aria-current="page"> Edit Proyek </li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Edit Proyek</h4>
      </div>
      <div class="card-body">
      <form action="{{route('proyekUpdate',['id'=>$proyek->id])}}" method="POST" enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Proyek</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{$proyek->nama}}">
            @error('nama')
              <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Lokasi</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" value="{{$proyek->lokasi}}">
            @error('lokasi')
              <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Proyek Dimulai</label>
          <div class="col-sm-12 col-md-7">
            <input type="date" class="form-control @error('proyekStart') is-invalid @enderror" name="proyekStart" value="{{$proyek->projectStart}}">
            @error('proyekStart')
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
    </div>
  </div>
</div>

@endsection