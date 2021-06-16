@extends('layouts.tema')
@section ('menuDPPelanggan','active')
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Cicilan Dp</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Cicilan Dp</li>
            {{-- <li class="breadcrumb-item" aria-current="page"> Tambah </li> --}}
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
@if($cekTransferDp !=null)
<div class="card">
  <div class="card-header bg-warning">
    <h4 class="text-dark">Informasi: Pembayaran DP belum bisa disetujui, Keterangan Admin: {{$cekTransferDp->keterangan}}</h4>
  </div>
</div>
@endif
  <div class="card">
    <div class="card-header">
      <h4>Informasi Cicilan DP</h4>
    </div>
    <div class="card-body">
      <table class="table">
        <tr>
          <th style="width: 30%">Status Cicilan DP</th>
        @if ($info == null)
          <td>: Belum Lunas</td>
        <tr>
          <th>Cicilan DP Selanjutnya</th>
          <td>: Pertama</td>
        </tr>
        @else
        <td>
          @if($info->sisaDp > 0)
          : <i class="fa fa-times-circle" aria-hidden="true"></i> Belum Lunas
          @else
          : <i class="fa fa-check" aria-hidden="true"></i>  Lunas
          @endif
        </td>
      </tr>
      <tr>
        <th>Cicilan Selanjutnya</th>
        <td>: Ke {{$info->urut+1}} ({{terbilang($info->urut+1)}})</td>
      </tr>
      {{-- <tr>
        <th>Nominal Cicilan</th>
        <td>: Rp.{{number_format($cicilanPerBulan)}}</td>
      </tr> --}}
      <tr>
        <th>Jatuh Tempo</th>
        <td>: 1-10 {{carbon\carbon::parse($info->tempo)->isoFormat('MMMM YYYY')}}</td>
        @endif   
      </tr>
      <tr>
        <td></td>
        <td>
          @if($cekTransferDp !=null)
            @if($cekTransferDp->pembelian_id != null)
            <a href="{{route('lihatTransferDp',['id'=>$cekTransferDp->id])}}" class="btn btn-warning">Lihat Pembayaran</a>
            @else 
            {{-- <button class="btn btn-primary" type="submit">Tambah Pembayaran</button> --}}
            <a href="{{route('transferDP')}}" class="btn btn-primary border-success ">Pembayaran</a>
            @endif
          @elseif($id->sisaDp <= 0)
          <a href="#" class="btn btn-info"> <i class="fa fa-check" aria-hidden="true"></i> DP LUNAS</a>
          @else
          <a href="{{route('transferDP')}}" class="btn btn-primary border-success ">Pembayaran</a>
          @endif
        </td>
      </tr> 
    </table>
    </div>
  </div>
<div class="card">
  <div class="card-header">
    <h4>History Pembayaran Cicilan DP {{jenisKepemilikan($id->pelanggan_id)}} {{$id->pelanggan->nama}}</h4>
  </div>
  <div class="card-body">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Tanggal</th>
          <th scope="col">Jumlah</th>
          <th scope="col">Sisa DP</th>
          <th scope="col">Nomor Faktur</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($daftarCicilanDp as $cicilanDp)
        <tr>
          <th scope="row">{{$loop->iteration}}</th>
          <td>{{formatTanggal($cicilanDp->tanggal)}}</td>
          <td>Rp.{{number_format($cicilanDp->jumlah)}}</td>
          <td>Rp.{{number_format($cicilanDp->sisaDp)}}</td>
          <td>
            @if(jenisKepemilikan($id->pelanggan_id)=='Kavling')
            DK
            @else
            DB
            @endif
            {{romawi(Carbon\Carbon::parse($cicilanDp->tanggal)->isoFormat('MM'))}}/{{$cicilanDp->ke}}
          </td>
          <td>
            <a href="{{route('cetakKwitansiDp',['id'=>$cicilanDp->id])}}" class=" btn-sm border-success btn btn-white text-primary"> <i class="fas fa-file-invoice    "></i> Kwitansi</a>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot class="bg-light">
        <tr >
          <th style="text-align: right" colspan="2">Total Terbayar</th>
          <th>Rp.{{number_format($daftarCicilanDp->sum('jumlah'))}}</th>
          <td></td>
          <td></td>
          <td></td>
        </tr>

      </tfoot>
    </table>
    
  </div>
</div>
@endsection