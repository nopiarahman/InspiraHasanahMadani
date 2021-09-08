@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuPelanggan','active')
@section ('menupelangganNonAktif','active')
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Pengembalian Dana {{$id->nama}}</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item"> <a href="{{route('pelangganNonAktif')}}">Pelanggan Non Aktif</a> </li>
            <li class="breadcrumb-item" aria-current="page"> Tambah Pengembalian Dana </li>
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
    <div class="row">
      <div class="col-12">
        @if (session('statusGudang'))
          <div class="alert alert-success alert-dismissible show fade">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            {{session ('statusGudang')}} <a href="{{route('gudang')}} " class="badge badge-warning text-dark">Lihat Gudang</a>
          </div>
        @endif
      </div>
    </div>
  <div class="card">
    <div class="card-header">
      <h4>Informasi Pengembalian Dana</h4>
    </div>
    <div class="card-body">
      <table class="table table-sm">
        <tr>
          <th style="width: 30%">Nama Pelanggan </th>
          <td>: {{$id->nama}}</td>
        </tr>
        <tr>
          <th>Unit</th>
          <td>: {{$id->pembelian->kavling->blok}}</td>
        </tr> 
        <tr>
          <th>Total Pembayaran DP</th>
          <td>: Rp. {{number_format($id->pembelian->dp-$id->pembelian->sisaDp)}}</td>
          @php
              $dp = $id->pembelian->dp-$id->pembelian->sisaDp;
          @endphp
        </tr>
        <tr>
          <th>Total Pembayaran Unit</th>
          <td>: Rp. {{number_format($id->pembelian->sisaKewajiban-$id->pembelian->sisaCicilan)}}</td>
          @php
              $cicilan=$id->pembelian->sisaKewajiban-$id->pembelian->sisaCicilan
          @endphp
        </tr>
        <tr>
          <th>Potongan Biaya</th>
          <td>: Rp. {{number_format(5000000)}}</td>
        </tr>
        <tr>
          <th>Total Pengembalian Dana</th>
          <td>: Rp. {{number_format($dp+$cicilan-5000000)}}</td>
        </tr>
      </table>
      </div>
    </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Tambah Pengembalian Dana</h4>
        </div>
        <div class="card-body">
        <form action="{{route('transaksiKeluarSimpan')}}" method="POST" enctype="multipart/form-data" onchange="hitung2()">
          @csrf
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal</label>
            <div class="col-sm-12 col-md-7">
              <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{old('tanggal')}}" >
              @error('tanggal')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode Akun</label>
            <div class="input-group col-sm-12 col-md-7">
              {{-- <div class="input-group-prepend"> --}}
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#pilihAkun">Pilih Akun</a>
              {{-- </div> --}}
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Akun</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" readonly class="form-control" name="" id="isiNamaAkun" value="{{old('isiNamaAkun')}}">
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori RAB</label>
            <div class="input-group col-sm-12 col-md-7">
              <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#pilihRAB">Pilih RAB</a>
              <div class="input-group-prepend mx-3 mt-1">
                {{-- <div class="input-group-text " style="border: none"> --}}
                  atau
                {{-- </div> --}}
              </div>
              <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#pilihRABUnit">Pilih Biaya Unit</a>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" hidden class="form-control" name="rab_id" id="idRAB" >
              <input type="text" hidden class="form-control" name="rabUnit_id" id="idRABUnit" >
              <input type="text" hidden class="form-control" name="akun_id" id="idAkunCari" >
              <input type="text" hidden class="form-control" name="pengembalian" value="{{$id->id}}">
              <input type="text" readonly class="form-control" name="" id="isiRAB" value="{{old('isi')}}">
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Uraian</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('uraian') is-invalid @enderror" name="uraian" value="{{old('uraian')}}">
              @error('uraian')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          {{-- <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control jumlah @error('uraian') is-invalid @enderror" name="jumlah" value="{{old('jumlah')}}" id="jumlahBarang">
              @error('jumlah')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Satuan</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('uraian') is-invalid @enderror" name="satuan" value="{{old('satuan')}}">
              @error('satuan')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div> --}}
          {{-- <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Satuan</label>
            <div class="input-group col-sm-12 col-md-7">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  Rp
                </div>
              </div>
              <input type="text" class="form-control hargaSatuan @error('hargaSatuan') is-invalid @enderror" name="hargaSatuan" value="{{old('hargaSatuan')}}" id="hargaSatuan">
              @error('hargaSatuan')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div> --}}
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah</label>
            <div class="input-group col-sm-12 col-md-7">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  Rp
                </div>
              </div>
              <input type="text" class="form-control totalHarga @error('total') is-invalid @enderror" name="total" value="{{old('total')}}" id="totalHarga">
              @error('total')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sumber</label>
            <div class="col-sm-12 col-md-7">
              <label class="selectgroup-item">
                <input type="radio" name="sumberKas" value="kasBesar" class="selectgroup-input" checked="">
                <span class="selectgroup-button">Kas Besar</span>
              </label>
              <label class="selectgroup-item">
                <input type="radio" name="sumberKas" value="pettyCash" class="selectgroup-input">
                <span class="selectgroup-button">Kas Kecil</span>
              </label>
              <label class="selectgroup-item">
                <input type="radio" name="sumberKas" value="kasKecilLapangan" class="selectgroup-input">
                <span class="selectgroup-button">Kas Kecil Lapangan</span>
              </label>
              @error('jenisKelamin')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Keterangan</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('sumber') is-invalid @enderror" name="sumber" value="{{old('sumber')}}">
              @error('sumber')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
            <div class="col-sm-12 col-md-7">
              <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
          </div>
        </div>
      </form>
      <script>
        function hitung2(){
        var harga = parseInt((document.getElementById('hargaSatuan').value).replace(/,/g, ''));
        var banyaknya = parseInt((document.getElementById('jumlahBarang').value).replace(/,/g, ''));
        var total = harga*banyaknya;
        $('#totalHarga').val(total);
        var cleave = new Cleave('.totalHarga', {
          numeral: true,
          numeralThousandsGroupStyle: 'thousand'
          });
        }
      
      </script>
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header">
      <h4>Daftar Pengembalian Dana</h4>
    </div>
    <div class="card-body">
     
      <table class="table table-hover table-striped mt-3" id="table">
        <thead>
          <tr>
            <td scope="col">No</td>
            <th scope="col">Tanggal</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Sisa Pengembalian</th>
            {{-- <th scope="col">Aksi</th> --}}
          </tr>
        </thead>
        <tbody>
          @foreach($pengembalian as $p)
          <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{formatTanggal($p->tanggal)}}</td>
            <td>Rp. {{number_format($p->jumlah)}}</td>
            <td>Rp. {{number_format($p->sisaPengembalian)}}</td>
            <td>
              {{-- @if($transaksi->sumber != "Gudang")
              @if (cekGudang($transaksi->id) == true)
              
              <a href="{{route('gudang')}}" type="button" class="btn btn-sm btn-white text-primary border-success">
              <i class="fas fa-warehouse "></i> Ada Stok Gudang</a>
              @else
              <button type="button" class="btn btn-sm btn-white text-primary border-success" 
              data-toggle="modal" 
              data-target="#keGudang" 
              data-id="{{$transaksi->id}}" 
              data-tanggal="{{$transaksi->tanggal}}" 
              data-uraian="{{$transaksi->uraian}}" 
              data-jumlah="{{$transaksi->jumlah}}" 
              data-satuan="{{$transaksi->satuan}}" 
              data-harga="{{$transaksi->hargaSatuan}}" 
              data-total="{{$transaksi->debet}}" 
              data-akun="{{$transaksi->akun->id}}" 
              data-awal="{{$transaksi->akun->namaAkun}}" 
              >
              Sisa Barang</button>
              @endif
              <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
              data-toggle="modal" 
              data-target="#hapusTransaksi" 
              data-id="{{$transaksi->id}}" 
              data-uraian="{{$transaksi->uraian}}">
              <i class="fa fa-trash" aria-hidden="true" ></i> Hapus</button>
            </td>
            @endif --}}
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="text-right text-primary">Total Transaksi</th>
            {{-- <th colspan="2" class="text-primary">Rp. {{number_format($transaksiKeluar->sum('debet'))}}</th> --}}
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  {{-- modal keGudang --}}
<div class="modal fade keGudang bd-example-modal-lg ml-5" id="keGudang" tabindex="-1" role="dialog" aria-labelledby="keGudangTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Transfer transaksi ke Gudang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data" id="formTransfer" onchange="hitung()">
          @csrf
          <input type="hidden" class="form-control" name="transaksi_id" value="" id="id">
          <input type="hidden"  class="form-control " name="akun_id" value="" id="akun">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal</label>
            <div class="col-sm-12 col-md-7">
              <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="" id="tanggal">
              @error('tanggal')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alokasi Awal</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('alokasiAwal') is-invalid @enderror" name="alokasiAwal" value="" id="alokasiAwal">
              @error('alokasiAwal')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Uraian</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('uraian') is-invalid @enderror" name="uraian" value="" id="uraian">
              @error('uraian')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah Awal</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" readonly class="form-control @error('banyaknya') is-invalid @enderror" name="banyaknya" value="" id="banyaknya">
              @error('banyaknya')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Satuan</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" readonly class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="" id="satuan">
              @error('satuan')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Satuan</label>
            <div class="input-group col-sm-12 col-md-7">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  Rp
                </div>
              </div>
              <input type="text" readonly class="hargaGudang form-control @error('harga') is-invalid @enderror" name="harga" value="" min="0" max="100" id="harga">
              @error('harga')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total</label>
            <div class="input-group col-sm-12 col-md-7">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  Rp
                </div>
              </div>
              <input type="text" readonly class="totalGudang form-control @error('total') is-invalid @enderror" name="total" value="{{old('total')}} " min="0" max="100" id="total">
              @error('total')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah Terpakai</label>
            <div class="col-sm-12 col-md-7">
              <input type="number" class="form-control @error('terpakai') is-invalid @enderror" max="" name="terpakai" value="" id="terpakai">
              @error('terpakai')
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
    var tanggal = button.data('tanggal') 
    var uraian = button.data('uraian') 
    var satuan = button.data('satuan') 
    var jumlah = button.data('jumlah') 
    var harga = button.data('harga') 
    var total = button.data('total') 
    var akun = button.data('akun') 
    var kategori = button.data('kategori')
    var awal = button.data('awal')
    document.getElementById('formTransfer').action='transferGudang/'+id;
    $('#id').val(id);
    $('#tanggal').val(tanggal);
    $('#akun').val(akun);
    $('#uraian').val(uraian);
    $('#banyaknya').val(jumlah);
    $('#terpakai').attr({"max":jumlah});
    $('#satuan').val(satuan);
    $('#harga').val(harga);
    $('#total').val(total);
    $('#alokasiAwal').val(awal);
    })
  });
  </script>
      <!-- Modal Hapus-->
      <div class="modal fade hapusTransaksi" id="hapusTransaksi" tabindex="-1" role="dialog" aria-labelledby="hapusTransaksiTitle" aria-hidden="true">
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
          $('#hapusTransaksi').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var id = button.data('id') // Extract info from data-* attributes
          var uraian = button.data('uraian') 
          var modal = $(this)
          modal.find('.modal-text').text('Yakin ingin menghapus transaksi ' + uraian+' ?')
          document.getElementById('formHapus').action='/hapusTransaksiKeluar/'+id;
          })
        });
      </script>
  {{-- modal RAB--}}
  <div class="modal fade" id="pilihRAB" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih RAB</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="body table-responsive-xl">
            <table class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Biaya</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($perHeader as $header=>$semuaRAB)
                <tr>
                  <th colspan="6" class="bg-primary text-light">{{$loop->iteration}}. {{$header}}</th>
                </tr>
                @foreach($perJudul[$header] as $judul=>$semuaRAB)
                <tr>
                  <th colspan="6" class="bg-light">{{$loop->iteration}}. {{$judul}}</th>
                </tr>
                  @foreach($semuaRAB as $rab)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td id="isiRAB">{{$rab->isi}}</td>
                    <td>
                      <a href="#" class="badge badge-info pilihRAB" data-id-rab={{$rab->id}} data-isi="{{$rab->isi}}" id="rab" >Pilih</a>
                    </td>
                  </tr>
                  @endforeach
                  @endforeach
                  @endforeach
                </tbody>
            </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          </form>  
        </div>
      </div>
    </div>
  </div>
  {{-- modal biaya Unit --}}
  <div class="modal fade " id="pilihRABUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih Biaya Unit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="body table-responsive-xl">
            <table class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Biaya</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($perHeaderUnit as $header=>$semuaRABUnit)
                <tr>
                  <th colspan="6" class="bg-primary text-light">{{$loop->iteration}}. {{$header}}</th>
                </tr>
                @foreach($perJudulUnit[$header] as $judul=>$semuaRABUnit)
                <tr>
                <th colspan="6" class="bg-light">{{$loop->iteration}}. {{$judul}}</th>
                </tr>
                  @foreach($semuaRABUnit as $rab)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$rab->isi}}</td>
                    <td>
                      <a href="#" class="badge badge-info pilihRAB" data-id-unit={{$rab->id}} data-isi="{{$rab->isi}}" id="rabUnit" >Pilih</a>
                    </td>
                  </tr>
                  @endforeach
                  @endforeach
                  @endforeach
                </tbody>
            </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          </form>  
        </div>
      </div>
    </div>
  </div>
  {{-- modal Akun--}}
  <div class="modal fade " id="pilihAkun" tabindex="-1"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih Akun</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="body table-responsive-xl">
            <table class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Kode Akun</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($perKategori as $judul=>$kategoriAkun)
                <tr>
                  <th colspan="4" class="bg-light">{{$judul}}</th>
                </tr>
                  @foreach($kategoriAkun as $kategori)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$kategori->kodeAkun}}</td>
                    <td>{{$kategori->namaAkun}}</td>
                    <td>
                      <a href="#" class="badge badge-info pilihRAB" data-id-akun={{$kategori->id}} data-isi="{{$kategori->namaAkun}}" id="akun" >Pilih</a>
                    </td>
                  </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          </form>  
        </div>
      </div>
    </div>
  </div>
  <script>
    function hitung(){
    var harga = parseInt((document.getElementById('harga').value).replace(/,/g, ''));
    var banyaknya = document.getElementById('banyaknya').value;
    var total = harga*banyaknya;
    $('#total').val(total);
    }
  
  </script>
  <script type="text/javascript">

    $(document).ready(function(){
      $(document).on('click','#rab',function(){
        var idRab = $(this).data('idRab');
        var isi =$(this).data('isi');
        $('#idRAB').val(idRab);
        // console.log(idRab);
        $('#isiRAB').val(isi);
        $('.close').click(); 
      });
      $(document).on('click','#rabUnit',function(){
        var idUnit = $(this).data('idUnit');
        var isi =$(this).data('isi');
        $('#idRABUnit').val(idUnit);
        // console.log(idUnit);
        $('#isiRAB').val(isi);
        $('.close').click(); 
      });
      $(document).on('click','#akun',function(){
        var idAkun = $(this).data('idAkun');
        var isi =$(this).data('isi');
        $('#idAkunCari').val(idAkun);
        console.log(idAkun);
        $('#isiNamaAkun').val(isi);
        $('.close').click(); 
      });
    });

</script>
<script src="{{ mix("js/cleave.min.js") }}"></script>
<script>
  var cleave = new Cleave('.jumlah', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
  var cleave = new Cleave('.hargaSatuan', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
  var cleave = new Cleave('.hargaGudang', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });

</script>
  @endsection
  @section('script')
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
@endsection