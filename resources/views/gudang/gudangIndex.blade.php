@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuGudang','active')
@section('content')
<div class="section-header sticky-top">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Gudang</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item" aria-current="page"> Gudang </li>
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
    <h4>Daftar Stok Gudang</h4>
  </div>
  <div class="card-body">
    <table class="table table-hover table-sm table-responsive-sm" id="table">
      <thead>
        <tr>
          <th scope="col">Tanggal</th>
          <th scope="col">Alokasi Awal</th>
          <th scope="col">Jenis Barang</th>
          <th scope="col">Pembelian</th>
          <th scope="col">Total</th>
          <th scope="col">Sisa</th>
          <th scope="col">Nominal Sisa</th>
          <th scope="col">Alokasi</th>
        </tr>
      </thead>
      <tbody>
        @php
            $totalNominal =0;
        @endphp
        @if($daftarGudang->first() != null)
        @foreach($daftarGudang as $gudang)
        <tr>
          <td>{{formatTanggal($gudang->tanggalPembelian)}}</td>
          <td>{{$gudang->alokasiAwal}}</td>
          <td>{{$gudang->jenisBarang}}</td>
          <td>{{$gudang->banyaknya}}{{$gudang->satuan}}</td>
          <td>Rp.{{number_format($gudang->total)}}</td>
          <td>
            @if ($gudang->sisa > 0)
            {{$gudang->sisa}}{{$gudang->satuan}}
            @else
            <a href="#" class="btn btn-white btn-sm text-primary"> <i class="fa fa-check" aria-hidden="true"></i> Habis </a>                
            @endif
          </td>
          <td>Rp.{{number_format(($gudang->sisa)*$gudang->harga)}}</td>
          <td>
            <a href="{{route('alokasiGudang',['id'=>$gudang->id])}}" class="btn btn-white border-success text-primary"> <i class="fas fa-pen    "></i> Input </a>
          </td>
        </tr>
        @php
            $totalNominal += $gudang->sisa*$gudang->harga;
        @endphp
        @endforeach
      </tbody>
      <tfoot>
        <tr class="bg-light">
          <th colspan="4" class="text-right text-primary">Total</th>
          <th colspan="2" class="text-primary">Rp. {{number_format($gudang->sum('total'))}}</th>
          <th colspan="2" class="text-primary">Rp. {{number_format($totalNominal)}}</th>
        </tr>
      </tfoot>
      @endif
    </table>
  </div>
</div>

@endsection
@section('script')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript" >
    $('#table').DataTable({
      "language": {
        "decimal":        "",
        "emptyTable":     "Tidak ada data tersedia",
        "info":           "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "infoEmpty":      "Menampilkan 0 sampai 0 dari 0 data",
        "infoFiltered":   "(difilter dari _MAX_ total data)",
        "infoPostFix":    "",
        "thousands":      ",",
        "lengthMenu":     "Menampilkan _MENU_ data",
        "loadingRecords": "Loading...",
        "processing":     "Processing...",
        "search":         "Cari:",
        "zeroRecords":    "Tidak ada data ditemukan",
        "paginate": {
            "first":      "Awal",
            "last":       "Akhir",
            "next":       "Selanjutnya",
            "previous":   "Sebelumnya"
        },
        }
    });
</script>
@endsection