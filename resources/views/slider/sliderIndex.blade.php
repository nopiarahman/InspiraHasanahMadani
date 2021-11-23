@extends('layouts.tema')
@section ('menuProyek','active')
@section('content')
<div class="section-header">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Slider</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item" aria-current="page"> Slider </li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<div class="section-header">
    <a href="{{route('sliderTambah')}}" class="btn btn-primary">Tambah Slider</a>
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

  {{-- Content --}}
<div class="card">
    <div class="card-header">
      <h4>Daftar Slider`</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Judul</th>
            <th scope="col">Gambar</th>
            <th scope="col">Text</th>
            <th scope="col">Link</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($slider as $sl)
          <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$sl->judul}}</td>
            <td>
              <img src="{{Storage::url($sl->gambar)}}" alt="" width="200px">
            </td>
            <td>{!!$sl->text!!}</td>
            <td>{{$sl->link}}</td>
            <td>{{$sl->status}}</td>
            <td><a href="{{route('sliderEdit',['id'=>$sl->id])}}" class="btn btn-white text-primary border-success"> <i class="fas fa-pen    "></i> Edit</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      
    </div>
  </div>
@endsection