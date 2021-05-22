@extends('layouts.tema')
@section ('menuTransaksiKeluar','active')
@section ('menuTransaksi','active')
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Transaksi Keluar</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Transaksi Keluar </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Tambah Jenis Biaya Baru</h4>
        </div>
        <div class="card-body">
        <form action="{{route('transaksiKeluarSimpan')}}" method="POST" enctype="multipart/form-data">
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
                <a class="btn btn-primary" data-toggle="modal" data-target="#pilihAkun">Pilih Akun</a>
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
              <a class="btn btn-primary" data-toggle="modal" data-target="#pilihRAB">Pilih RAB</a>
              <div class="input-group-prepend mx-3 mt-1">
                {{-- <div class="input-group-text " style="border: none"> --}}
                  atau
                {{-- </div> --}}
              </div>
              <a class="btn btn-primary" data-toggle="modal" data-target="#pilihRABUnit">Pilih Biaya Unit</a>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" hidden class="form-control" name="rab_id" id="idRAB" >
              <input type="text" hidden class="form-control" name="rabUnit_id" id="idRABUnit" >
              <input type="text" hidden class="form-control" name="akun_id" id="idAkunCari" >
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
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah</label>
            <div class="input-group col-sm-12 col-md-7">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  Rp
                </div>
              </div>
              <input type="text" class="form-control jumlah @error('jumlah') is-invalid @enderror" name="jumlah" value="{{old('jumlah')}}" id="jumlah">
              @error('jumlah')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sumber</label>
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

      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header">
      <h4>Daftar Transaksi Keluar</h4>
    </div>
    <div class="card-body">
      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th scope="col">Tanggal</th>
            <th scope="col">Kode Transaksi</th>
            <th scope="col">Uraian</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Sumber</th>
          </tr>
        </thead>
        <tbody>
          @foreach($transaksiKeluar as $transaksi)
          <tr>
            <td>{{formatTanggal($transaksi->tanggal)}}</td>
            <td>{{$transaksi->akun->kodeAkun}}</td>
            <td>{{$transaksi->uraian}}</td>
            <td>Rp.{{number_format($transaksi->debet)}}</td>
            <td>{{$transaksi->sumber}}</td>
          @endforeach
        </tbody>
      </table>
      {{$transaksiKeluar->links()}}
    </div>
  </div>
  {{-- modal RAB--}}
  <div class="modal fade modalBaru" id="pilihRAB" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
  <div class="modal fade modalBaru" id="pilihRABUnit" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                      <a href="#" class="badge badge-info pilihRAB" data-id-unit={{$rab->id}} data-isi="{{$rab->isi}}" id="rab" >Pilih</a>
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
  <div class="modal fade modalBaru" id="pilihAkun" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
  <script type="text/javascript">

    $(document).ready(function(){
      $(document).on('click','#rab',function(){
        var idRab = $(this).data('idRab');
        var isi =$(this).data('isi');
        $('#idRAB').val(idRab);
        // console.log(idRab);
        $('#isiRAB').val(isi);
        $('.close').click(); 
        $("#pilihRAB .close").click();
      })
    })
    $(document).ready(function(){
      $(document).on('click','#rab',function(){
        var idUnit = $(this).data('idUnit');
        var isi =$(this).data('isi');
        $('#idRABUnit').val(idUnit);
        // console.log(idUnit);
        $('#isiRAB').val(isi);
        $('.close').click(); 
        $("#pilihRABUnit .close").click();
      })
    })
    $(document).ready(function(){
      $(document).on('click','#akun',function(){
        var idAkun = $(this).data('idAkun');
        var isi =$(this).data('isi');
        $('#idAkunCari').val(idAkun);
        console.log(idAkun);
        $('#isiNamaAkun').val(isi);
        $('.close').click(); 
        $("#pilihAkun .close").click();
      })
    })
</script>
<script src="{{ mix("js/cleave.min.js") }}"></script>
<script>
  var cleave = new Cleave('.jumlah', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
</script>
  @endsection