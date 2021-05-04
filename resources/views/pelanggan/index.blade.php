@extends('layouts.tema')
@section ('menuPelanggan','active')
@section('content')
<div class="section-header">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Pelanggan</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Pelanggan </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  
  <div class="section-header">
      <a href="{{route('pelangganTambah')}}" class="btn btn-primary">Tambah Pelanggan Baru</a>
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
  
    {{-- Content --}}
  <div class="card">
      <div class="card-header">
        <h4>Daftar Pelanggan</h4>
      </div>
      <div class="card-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">Unit</th>
              <th scope="col">No Telp</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($semuaPelanggan as $pelanggan)
            <tr>
              <th scope="row">{{$loop->iteration}}</th>
              <td>{{$pelanggan->nama}}</td>
              <td>{{unitPelanggan(pembelianPelanggan($pelanggan->id)->kavling_id)->blok}}</td>
              <td>{{$pelanggan->nomorTelepon}}</td>
              {{-- <td><a href="{{route('proyekEdit',['id'=>$pelanggan->id])}}" class="badge badge-info">Edit</a></td> --}}
            </tr>
            @endforeach
          </tbody>
        </table>
        {{$semuaPelanggan->links()}}
      </div>
    </div>
  @endsection