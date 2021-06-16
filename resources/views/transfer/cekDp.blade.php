@extends('layouts.tema')
@section ('menuCicilan','active')
@section ('menuCicilanDP','active')
@section('content')
<div class="section-header sticky-top">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Cicilan DP</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item" > <a href="{{route('DPKavling')}}"> Cicilan DP </a></li>
          <li class="breadcrumb-item" aria-current="page"> Transfer </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
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

<div class="card">
  <div class="card-header">
    <h4>Daftar Transfer Masuk</h4>
  </div>
  <div class="card-body">
    <table class="table table-hover table-striped mt-3">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Pelanggan</th>
          <th scope="col">Tanggal</th>
          <th scope="col">Jumlah</th>
          <th scope="col">Rekening</th>
          <th scope="col">Status</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($transfer as $item)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$item->pelanggan->nama}}</td>
          <td>{{$item->tanggal}}</td>
          <td>Rp.{{number_format($item->jumlah)}}</td>
          <td>{{$item->rekening->namaBank}} - {{$item->rekening->noRekening}}</td>
          <td>@if($item->status == 'review')
              <span class="badge badge-warning text-dark">Review Ulang</span>
              @elseif($item->status != null)
              <span class="badge badge-info">Diupdate</span>
              @elseif($item->status == null)
              <span class="badge badge-primary">Belum di Lihat</span>
              @endif
          </td>
          <td>
            <a href="{{route('lihatTransferDPPelanggan',['id'=>$item->id])}}" class="btn btn-white border-success text-primary">Lihat</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{$transfer->links()}}
  </div>
</div>
@endsection