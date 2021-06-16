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
  @if($transferDp->count() != 0)
<div class="card bg-warning">
  <div class="card-header">
    <h4 class="text-dark">Ada {{$transferDp->count()}} pelanggan yang melakukan transaksi via transfer</h4>
    <a href="{{route('cekTransferDPPelanggan')}}" class="btn btn-dark text-white ">Lihat</a>
  </div>
</div>
@endif
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
            @if($cicilanDp->pelanggan !=null)
            <tr>
              <th scope="row">{{$loop->iteration}}</th>
              <td>
                
                <a href="{{route('pelangganDetail',['id'=>$cicilanDp->pelanggan->id])}}" class="text-primary">
                {{$cicilanDp->pelanggan->nama}}
                </a>
              </td>
              @if($cicilanDp->pelanggan->kavling==null)
              <td>Batal Akad</td>
              @else
              <td>{{unitPelanggan($cicilanDp->kavling_id)->blok}}</td>
              @endif
              <td>{{jenisKepemilikan($cicilanDp->pelanggan_id)}}</td>
              <td>Rp.{{number_format($cicilanDp->sisaDp)}}</td>
              <td><a href="{{route('DPKavlingTambah',['id'=>$cicilanDp->id])}}" class="btn btn-white btn-sm text-primary border-success">Pembayaran</a>
                @if($cicilanDp->sisaDp==0)
                <span class="badge badge-white text-info"><i class="fas fa-check"></i> Lunas</span>
                @endif
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
        {{$semuaCicilanDp->links()}}
      </div>
    </div>
@endsection