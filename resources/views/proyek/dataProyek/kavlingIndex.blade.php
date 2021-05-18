@extends('layouts.tema')
@section ('menuKavling','active')
@section ('menuDataProyek','active')
@section('content')
<div class="section-header">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Unit</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Unit </li>
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
      </div>
    </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Tambah Unit Baru</h4>
        </div>
        <div class="card-body">
        <form action="{{route('kavlingSimpan')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Blok</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('blok') is-invalid @enderror" name="blok" value="{{old('blok')}}">
              @error('blok')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Luas</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('luas') is-invalid @enderror" name="luas" value="{{old('luas')}}">
              @error('luas')
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

  <div class="card">
    <div class="card-header">
      <h4>Daftar Unit</h4>
    </div>
    <div class="card-body">
      <table class="table table-sm table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Blok</th>
            <th scope="col">Luas Tanah</th>
            <th scope="col">Luas Bangunan</th>
            <th scope="col">Kepemilikan</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($semuaKavling as $kavling)
          <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$kavling->blok}}</td>
            <td>{{$kavling->luas}}m</td>
            <td>
              @if($kavling->rumah != null)
              {{$kavling->rumah->luasBangunan}}m
              @elseif($kavling->kios !=null)
              {{$kavling->kios->luasBangunan}}m
              @else
              --
              @endif
            </td>
            @if($kavling->pembelian == !null)
            <td>{{$kavling->pembelian->pelanggan->nama}}</td>
            @else
            <td>--</td>
            @endif
            <td><a href="{{route('proyekEdit',['id'=>$kavling->id])}}" class="badge badge-info">Edit</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
        {{$semuaKavling->links()}}
@endsection