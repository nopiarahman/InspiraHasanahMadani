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
          <td data-order="{{$gudang->tanggalPembelian}}">{{formatTanggal($gudang->tanggalPembelian)}}</td>
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
            <a href="{{route('alokasiGudang',['id'=>$gudang->id])}}" class="btn btn-sm btn-white border-success text-primary"> <i class="fas fa-pen    "></i> Input </a>
            <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
              data-toggle="modal" 
              data-target="#hapusTransaksi" 
              data-id="{{$gudang->id}}" 
              data-uraian="{{$gudang->jenisBarang}}">
              <i class="fa fa-trash" aria-hidden="true" ></i> Hapus</button>

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
      <!-- Modal Hapus-->
      <div class="modal fade hapusTransaksi" id="hapusTransaksi" tabindex="-1" role="dialog" aria-labelledby="hapusTransaksiTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Hapus Gudang</h5>
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
          $('#hapusTransaksi').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var id = button.data('id') // Extract info from data-* attributes
          var uraian = button.data('uraian') 
          var modal = $(this)
          modal.find('.modal-text').text('Yakin ingin menghapus item gudang ' + uraian+' ini?')
          document.getElementById('formHapus').action='/hapusGudang/'+id;
          })
        });
      </script>
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