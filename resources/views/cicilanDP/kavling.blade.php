@extends('layouts.tema')
@section ('menuCicilanDP','active')
@section('content')
<div class="section-header">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Cicilan Dp</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Cicilan Dp </li>
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

    <div class="card">
      <div class="card-header">
        <h4>Daftar Cicilan DP</h4>
      </div>
      <div class="card-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">Blok</th>
              <th scope="col">Jenis</th>
              <th scope="col">Sisa DP</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($semuaCicilanDp as $cicilanDp)
            <tr>
              <th scope="row">{{$loop->iteration}}</th>
              <td>{{$cicilanDp->pelanggan->nama}}</td>
              <td>{{unitPelanggan($cicilanDp->kavling_id)->blok}}</td>
              <td>{{jenisKepemilikan($cicilanDp->pelanggan_id)}}</td>
              <td>Rp.{{number_format($cicilanDp->sisaDp)}}</td>
              <td><a href="{{route('DPKavlingTambah',['id'=>$cicilanDp->id])}}" class="badge badge-primary">Pembayaran</a>
                @if($cicilanDp->sisaDp==0)
                <span class="badge badge-info"><i class="fas fa-check"></i> Lunas</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{$semuaCicilanDp->links()}}
      </div>
    </div>
@endsection