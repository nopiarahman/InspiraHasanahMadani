@extends('layouts.tema')
@section ('menuProyek','active')
@section('content')

<div class="section-header">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>User</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item"> <a href="{{route('kelolaUser')}}"> User</a></li>
          <li class="breadcrumb-item active" aria-current="page"> Tambah User </li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Tambah User Baru</h4>
      </div>
      <div class="card-body">
      <form action="{{route('userSimpan')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Lengkap</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}">
            @error('name')
              <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="">
            @error('email')
              <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jabatan</label>
          <div class="col-sm-12 col-md-7">
            <select class="form-control selectric" tabindex="-1" name="jabatan" >
              <option value="admin">Admin</option>
              <option value="marketing">Marketing</option>
            </select>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Proyek</label>
          <div class="col-sm-12 col-md-7">
            <select class="form-control selectric" tabindex="-1" name="proyek" >
              @forelse($semuaProyek as $proyek)
              <option value="{{$proyek->id}}">{{$proyek->nama}}</option>
              @empty
              <option value="">Belum ada proyek</option>
              @endforelse
            </select>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>
          <div class="col-sm-12 col-md-7">
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="sandi" value="">
            @error('password')
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