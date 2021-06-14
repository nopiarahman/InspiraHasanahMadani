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
          <li class="breadcrumb-item" aria-current="page"> Proyek </li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<div class="section-header">
    <a href="{{route('proyekTambah')}}" class="btn btn-primary">Tambah Proyek Baru</a>
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
      <h4>Daftar Proyek</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Proyek</th>
            <th scope="col">Lokasi</th>
            <th scope="col">Proyek Start</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($proyek as $pk)
          <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$pk->nama}}</td>
            <td>{{$pk->lokasi}}</td>
            <td>{{$pk->proyekStart}}</td>
            <td><a href="{{route('proyekEdit',['id'=>$pk->id])}}" class="btn btn-white text-primary border-success"> <i class="fas fa-pen    "></i> Edit</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      
    </div>
  </div>
@endsection