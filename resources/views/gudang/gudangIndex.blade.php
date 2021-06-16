@extends('layouts.tema')
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
    <table class="table table-sm table-hover table-striped mt-3">
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
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @php
            $totalNominal =0;
        @endphp
        @if($daftarGudang->first() != null)
        @foreach($daftarGudang as $gudang)
        <tr>
          <td>{{formatTanggal($gudang->tanggal)}}</td>
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
            @if ($gudang->alokasi ==null)
            
            @else
            {{$gudang->alokasi}} 
            @endif
          </td>
          <td>
            @if ($gudang->alokasi ==null)
            <button type="button" class="btn btn-sm btn-white text-primary border-success" 
            data-toggle="modal" 
            data-target="#keGudang" 
            data-id="{{$gudang->id}}" 
            data-satuan="{{$gudang->satuan}}" 
            data-alokasi="{{$gudang->alokasi}}" 
            data-sisa="{{$gudang->sisa}}" 
            >
            <i class="fas fa-pen" aria-hidden="true"></i> Input</button>
            @elseif($gudang->sisa > 0)
            <button type="button" class="btn btn-sm btn-white text-warning border-success" 
            data-toggle="modal" 
            data-target="#keGudang" 
            data-id="{{$gudang->id}}" 
            data-satuan="{{$gudang->satuan}}" 
            data-alokasi="{{$gudang->alokasi}}" 
            data-sisa="{{$gudang->sisa}}" 
            >
            <i class="fas fa-pen" aria-hidden="true"></i> Input Ulang</button>
            @else
            <button type="button" class="btn btn-sm btn-white text-warning border-success" 
            data-toggle="modal" 
            data-target="#keGudang" 
            data-id="{{$gudang->id}}" 
            data-satuan="{{$gudang->satuan}}" 
            data-alokasi="{{$gudang->alokasi}}" 
            data-sisa="{{$gudang->sisa}}" 
            >
            <i class="fas fa-pen" aria-hidden="true"></i> Input Ulang</button>
            @endif
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
          <th colspan="3" class="text-primary">Rp. {{number_format($totalNominal)}}</th>
        </tr>
      </tfoot>
      @endif
    </table>
    {{-- {{$transaksiMasuk->links()}} --}}
  </div>
</div>
  {{-- modal keGudang --}}
  <div class="modal fade keGudang bd-example-modal-lg ml-5" id="keGudang" tabindex="-1" role="dialog" aria-labelledby="keGudangTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Input Alokasi Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" enctype="multipart/form-data" id="formTransfer">
            @csrf
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sisa</label>
              <div class="input-group col-sm-12 col-md-7">
                <input type="text" class="form-control @error('sisa') is-invalid @enderror" name="sisaSebelumnya" value="" min="0" max="100" id="sisa">
                @error('sisa')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
                <div class="input-group-prepend">
                  <div class="input-group-text " >
                    <span id="satuanSisa"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah Alokasi</label>
              <div class="input-group col-sm-12 col-md-7">
                <input type="text" class="form-control @error('jumlahAlokasi') is-invalid @enderror" name="jumlahAlokasi" value="" min="0" max="100" id="jumlahAlokasi">
                @error('jumlahAlokasi')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
                <div class="input-group-prepend">
                  <div class="input-group-text " >
                    <span id="satuanAlokasi"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tujuan Alokasi</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" value="" id="keterangan">
                @error('keterangan')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
              <div class="col-sm-12 col-md-7">
                <button class="btn btn-primary" type="submit">Transfer</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              </div>
            </div>
          </form>
          </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function () {
      $('#keGudang').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id') // Extract info from data-* attributes
      var sisa = button.data('sisa') 
      var satuan = button.data('satuan') 
      var alokasi = button.data('alokasi') 
      document.getElementById('formTransfer').action='alokasiGudang/'+id;
      $('#satuanSisa').text(satuan);
      $('#sisa').val(sisa);
      $('#satuanAlokasi').text(satuan);
      $('#keterangan').val(alokasi);
      })
    });
    </script>
@endsection