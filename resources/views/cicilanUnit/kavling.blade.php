@extends('layouts.tema')
@section ('menuCicilanUnit','active')
@section('content')
<div class="section-header">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Cicilan Unit </h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item" aria-current="page"> Cicilan Unit  </li>
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
      <h4>Daftar Cicilan Unit</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover table-responsive-sm">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Blok</th>
            <th scope="col">Jenis</th>
            <th scope="col">Sisa Kewajiban</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($semuaCicilanUnit as $cicilanUnit)
          @if($cicilanUnit->pelanggan !=null)
          <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>
              <a href="{{route('pelangganDetail',['id'=>$cicilanUnit->pelanggan->id])}}" class="text-primary">
              {{$cicilanUnit->pelanggan->nama}}
              </a>
            </td>
            @if($cicilanUnit->pelanggan->kavling==null)
            <td>Batal Akad</td>
            @else
            <td>{{unitPelanggan($cicilanUnit->kavling_id)->blok}}</td>
            @endif
            <td>{{jenisKepemilikan($cicilanUnit->pelanggan_id)}}</td>
            <td>
              @if($cicilanUnit->sisaCicilan != null)
              Rp.{{number_format($cicilanUnit->sisaCicilan)}}
              @else
              Rp.{{number_format($cicilanUnit->sisaKewajiban)}}
              @endif
            </td>
            <td>
              @if($cicilanUnit->sisaDp<=0)
              <a href="{{route('unitKavlingDetail',['id'=>$cicilanUnit->id])}}" class="btn btn-white text-primary border-success btn-sm">Pembayaran</a>
              @else
              <a href="#" class="badge badge-secondary">DP Belum Lunas</a>
              @endif
              @if($cicilanUnit->sisaKewajiban==0)
              <span class="badge badge-info"><i class="fas fa-check"></i> Lunas</span>
              @endif
            </td>
          </tr>
          @endif
          @endforeach

        </tbody>

      </table>
      {{$semuaCicilanUnit->links()}}
    </div>
  </div>
@endsection