@extends('layouts.tema')
@if(auth()->user()->role=="admin")
  @section ('menuCicilanUnit','active')
@elseif(auth()->user()->role=="pelanggan")
  @section ('menuUnitPelanggan','active')
@endif
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Cicilan Unit</h1>
        </div>
      </div>
      @if(auth()->user()->role=="admin" ||auth()->user()->role=="projectmanager" )
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item"> <a href="{{route('cicilanKavling')}}"> Cicilan Unit </a></li>
            <li class="breadcrumb-item" aria-current="page"> Tambah </li>
          </ol>
        </nav>
      </div>
      @endif
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
    @if($cekTransferUnit !=null)
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="text-dark">Informasi: Pembayaran cicilan belum bisa disetujui, Keterangan Admin: {{$cekTransferUnit->keterangan}}</h4>
      </div>
    </div>
    @endif
<div class="card">
  <div class="card-header">
    <h4>Informasi Cicilan</h4>
  </div>
  <div class="card-body">
    <table class="table">
      <tr>
        <th style="width: 30%">Status Cicilan</th>
      @if ($info == null)
        <td>: Belum Lunas</td>
      <tr>
        <th>Cicilan Selanjutnya</th>
        <td>: Pertama</td>
      </tr>
      <tr>
        <th>Nominal Cicilan</th>
        <td>: Rp.{{number_format($cicilanPerBulan)}}</td>
      </tr>
      @else
      <td>
        @if($info->sisaKewajiban > 0)
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
    <tr>
      <th>Nominal Cicilan</th>
      <td>: Rp.{{number_format($cicilanPerBulan)}}</td>
    </tr>
    <tr>
      <th>Jatuh Tempo</th>
      <td>: 1-10 {{carbon\carbon::parse($info->tempo)->isoFormat('MMMM YYYY')}}</td>
      @endif   
    </tr>
    <tr>
      <td></td>
      <td>
        @if($cekTransferUnit !=null)
          @if($cekTransferUnit->pembelian_id != null)
          <a href="{{route('lihatTransferUnit',['id'=>$cekTransferUnit->id])}}" class="btn btn-warning">Lihat Pembayaran</a>
          @else 
          {{-- <button class="btn btn-primary" type="submit">Tambah Pembayaran</button> --}}
          <a href="{{route('transferUnit')}}" class="btn btn-primary border-success ">Pembayaran</a>
          @endif
        @elseif($id->sisaDp > 0)
        <a href="#" class="btn btn-primary border-success disabled">DP Belum Lunas</a>
        @elseif($id->sisaKewajiban <= 0)
        <a href="#" class="btn btn-primary border-info">Cicilan Lunas</a>
        @else
        <a href="{{route('transferUnit')}}" class="btn btn-primary border-success ">Pembayaran</a>
        @endif
      </td>
    </tr> 
  </table>
  </div>
</div>
<div class="card">
  <div class="card-header">
    <h4>History Pembayaran Cicilan Unit {{jenisKepemilikan($id->pelanggan_id)}} {{$id->pelanggan->nama}}</h4>
  </div>
  <div class="card-body">
    <table class="table table-hover table-responsive">
      <thead>
        <tr>
          <th scope="col">Cicilan Ke</th>
          <th scope="col">Tanggal</th>
          <th scope="col">Jumlah</th>
          <th scope="col">Sisa Hutang</th>
          <th scope="col">Nomor Faktur</th>
          <th scope="col">Status</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($daftarCicilanUnit as $cicilanUnit)
        <tr>
          <th scope="row">{{$cicilanUnit->urut}}</th>
          <td>{{formatTanggal($cicilanUnit->tanggal)}}</td>
          <td>Rp.{{number_format($cicilanUnit->jumlah)}}</td>
          <td>Rp.{{number_format($cicilanUnit->sisaKewajiban)}}</td>
          <td>
            @if(jenisKepemilikan($id->pelanggan_id)=='Kavling')
            CK
            @else
            CB
            @endif
            {{romawi(Carbon\Carbon::parse($cicilanUnit->tanggal)->isoFormat('MM'))}}/{{$cicilanUnit->ke}}</td>
          <td>
            <span class="badge badge-info text-white"> <i class="fa fa-check" aria-hidden="true"></i> Diterima</span>
          </td>
          <td>
            <a href="{{route('cetakKwitansiPelanggan',['id'=>$cicilanUnit->id])}}" class=" btn-sm border-success btn btn-white text-primary"> <i class="fas fa-file-invoice    "></i> Kwitansi</a>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot class="bg-light">
        <tr >
          <th style="text-align: right" colspan="2">Total Terbayar</th>
          <th colspan="5">Rp.{{number_format($totalTerbayar)}}</th>
        </tr>
      </tfoot>
    </table>
    {{$daftarCicilanUnit->links()}}
  </div>
</div>
    <!-- Modal Hapus-->
    <div class="modal fade exampleModalCenter" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Hapus Transaksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" id="formHapus">
              @method('delete')
              @csrf
              <p class="modal-text"></p>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger">Hapus!</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#exampleModalCenter').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-text').text('Yakin ingin menghapus transaksi ini ?')
        document.getElementById('formHapus').action='/hapusCicilan/'+id;
        })
      });
    </script>
@endsection