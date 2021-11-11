@extends('layouts.tema')
@if(auth()->user()->role=="admin")
  @section ('menuCicilanUnit','active')
@elseif(auth()->user()->role=="pelanggan")
  @section ('menuUnitPelanggan','active')
@endif
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
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
    @if(auth()->user()->role=="admin")
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Pembayaran Unit</h4>
      </div>
      <div class="card-body">
      <form action="{{route('cicilanKavlingSimpan')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Pembayaran</label>
          <div class="col-sm-12 col-md-7">
            <input type="hidden" class="form-control " name="pembelian_id" value="{{$id->id}}" >
            <input type="hidden" class="form-control " name="pelanggan_id" value="{{$id->pelanggan->id}}" >
            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{old('tanggal')}}" >
            @error('tanggal')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" readonly class="form-control " value="{{$id->pelanggan->nama}}">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Blok</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" readonly class="form-control " value="{{$id->kavling->blok}}">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" readonly class="form-control " value="{{jenisKepemilikan($id->pelanggan_id)}}">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Hutang</label>
          <div class="input-group col-sm-12 col-md-7">
            <div class="input-group-prepend">
              <div class="input-group-text">
                Rp
              </div>
            </div>
            <input type="text" readonly class="akadDp form-control"  value="{{$id->sisaKewajiban}} " id="totalDiskon">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sisa Hutang</label>
          <div class="input-group col-sm-12 col-md-7">
            <div class="input-group-prepend">
              <div class="input-group-text">
                Rp
              </div>
            </div>
            <input type="text" readonly class=" form-control"  value="{{number_format($id->sisaCicilan)}} " id="totalDiskon">
          </div>
        </div>
        <div id="tenor" class="">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tenor</label>
            <div class="input-group col-sm-12 col-md-7">
              <input type="text" readonly class=" form-control " name="" value="{{$id->tenor}} ">
              
              <div class="input-group-prepend">
                <div class="input-group-text">
                  bulan
                </div>
              </div>
              
            </div>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Cicilan/Bulan</label>
          <div class="input-group col-sm-12 col-md-7">
            <div class="input-group-prepend">
              <div class="input-group-text">
                Rp
              </div>
            </div>
            <input type="text" readonly class="akadDp form-control"  value="{{number_format($cicilanPerBulan)}} " id="totalDiskon">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pembayaran Unit</label>
          <div class="input-group col-sm-12 col-md-7">
            <div class="input-group-prepend">
              <div class="input-group-text">
                Rp
              </div>
            </div>
            <input type="text" class="jumlah form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{old('jumlah')}} " id="jumlah">
            @error('jumlah')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Metode Pembayaran</label>
          <div class="col-sm-12 col-md-7">
            <label class="selectgroup-item">
              <input type="radio" name="metode" value="cash" class="selectgroup-input" checked id="metodeCashDp" onclick="cash()">
              <span class="selectgroup-button">Cash</span>
            </label>
            <label class="selectgroup-item">
              <input type="radio" name="metode" value="transfer" id="" class="selectgroup-input" id="metodeTransferDp" onclick="transfer()">
              <span class="selectgroup-button">Transfer</span>
            </label>
            @error('metode')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        </div>
        <div id="rekeningTransfer" class="rekeningTransfer d-none">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Rekening Tujuan</label>
            <div class="col-sm-12 col-md-7">
              <select class="form-control selectric" tabindex="-1" name="rekening" >
                @forelse ($rekening as $item)
                <option value="" selected>Pilih Rekening...</option>                  
                <option value="{{$item->id}}">{{$item->namaBank}} {{$item->noRekening}} - a/n {{$item->atasNama}}</option>
                @empty
                <option value="">Belum ada rekening</option>                  
                @endforelse
              </select>
            </div>
          </div>
        </div>
        <script type="text/javascript">
          function transfer(){
            var transfer = document.querySelector('.rekeningTransfer');
            transfer.className ='rekeningTransfer';
          }
          function cash(){
            var cash = document.querySelector('.rekeningTransfer');
            cash.className ='rekeningTransfer d-none';
          }
          </script>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
          <div class="col-sm-12 col-md-7">
            <button class="btn btn-primary" type="submit">Tambah Pembayaran</button>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
@endif
<div class="card">
  <div class="card-header">
    <h4>History Pembayaran Cicilan Unit {{jenisKepemilikan($id->pelanggan_id)}} {{$id->pelanggan->nama}}</h4>
  </div>
  <div class="card-body">
    <table class="table table-hover table-responsive-sm" id="table">
      <thead>
        <tr>
          <th scope="col">Cicilan Ke</th>
          <th scope="col">Tanggal</th>
          <th scope="col">Jumlah</th>
          <th scope="col">Sisa Hutang</th>
          <th scope="col">Nomor Faktur</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @php
            $terbayar = 0;
        @endphp
        @foreach($daftarCicilanUnit as $cicilanUnit)
        {{-- update semua tempo setelah input --}}
        {{updateTempoCicilan($cicilanUnit)}}
        <tr>
          <th scope="row">{{cicilanKe($cicilanUnit->pembelian->id,$cicilanUnit->tanggal)}}</th>
          <td data-order="{{$cicilanUnit->tanggal}}" >{{formatTanggal($cicilanUnit->tanggal)}}</td>
          <td>Rp.{{number_format($cicilanUnit->jumlah)}}</td>
          
          <td>Rp.{{number_format($cicilanUnit->pembelian->sisaKewajiban-cicilanTerbayar($cicilanUnit->pembelian->id,$cicilanUnit->tanggal))}}</td>
          <td>
            @if(jenisKepemilikan($id->pelanggan_id)=='Kavling')
            CK
            @else
            CB
            @endif
            {{romawi(Carbon\Carbon::parse($cicilanUnit->tanggal)->isoFormat('MM'))}}/{{$cicilanUnit->ke}}</td>
          <td>
            <a href="{{route('cetakKwitansi',['id'=>$cicilanUnit->id])}}" class=" btn-sm border-success btn btn-white text-primary"> <i class="fas fa-file-invoice    "></i> Kwitansi</a>
            <button type="button" class=" border-danger btn btn-sm btn-white text-danger" 
            data-toggle="modal" 
            data-target="#exampleModalCenter" 
            data-id="{{$cicilanUnit->id}}">
            <i class="fa fa-trash" aria-hidden="true" ></i> Hapus </button>  
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot class="bg-light">
        <tr >
          <th style="text-align: right" colspan="2">Total Terbayar</th>
          <th>Rp.{{number_format($totalTerbayar)}}</th>
          <td></td>
          <td></td>
          <td></td>
        </tr>

      </tfoot>
    </table>
    
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
<script src="{{ mix("js/cleave.min.js") }}"></script>
<script>
  var cleave = new Cleave('.akadDp', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
  var cleave = new Cleave('.jumlah', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
 </script>
@endsection
{{-- @section('script')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript" >
    $('#table').DataTable({
      "pageLength":     25,
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
@endsection --}}