@extends('layouts.tema')
@section ('menuKas','active')
@section ('menuKasPendaftaran','active')
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Kas Pendaftaran</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Kas Pendaftaran </li>
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
    <div class="section-header">
      <a href="{{route('kasPendaftaranMasuk')}}"  class="btn btn-primary disabled ">Masuk</a>
      <a href="{{route('kasPendaftaranKeluar')}}" class="btn btn-primary ml-2">Keluar</a>
  </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Tambah Transaksi Masuk Kas Pendaftaran</h4>
          </div>
          <div class="card-body">
          <form action="{{route('kasPendaftaranMasukSimpan')}}" method="POST" enctype="multipart/form-data">
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
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
              <div class="col-sm-12 col-md-7">
                <button class="btn btn-primary" type="submit">Simpan</button>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  
    <div class="card">
      <div class="card-header">
        <h4>Daftar Transaksi</h4>
      </div>
      <div class="card-body">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Uraian</th>
              <th scope="col">Kredit</th>
              <th scope="col">Debit</th>
              <th scope="col">Saldo</th>
              <th scope="col">Sumber</th>
            </tr>
          </thead>
          <tbody>
              @foreach($kasPendaftaran as $kas)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$kas->tanggal}}</td>
                <td>{{$kas->uraian}}</td>
                <td>
                  @if($kas->kredit != null)
                  Rp.{{number_format($kas->kredit)}}
                  @endif
                </td>
                <td>
                  @if($kas->debet != null)
                  Rp.{{number_format($kas->debet)}}
                  @endif
                </td>
                <td>Rp. {{number_format($kas->saldo)}}</td>
                <td>{{$kas->sumber}}</td>
              </tr>
              @endforeach
          </tbody>
          <tfoot>
            <tr class="bg-light">
              <th colspan="3" class="text-right text-primary">Total</th>
              <th class="text-primary">Rp. {{number_format($kasPendaftaran->sum('kredit'))}}</th>
              <th class="text-primary">Rp. {{number_format($kasPendaftaran->sum('debet'))}}</th>
              <th colspan="2" class="text-primary">Rp. {{number_format(saldoTerakhirKasPendaftaran())}}</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <script src="{{ mix("js/cleave.min.js") }}"></script>
<script src="{{ mix("js/addons/cleave-phone.id.js") }}"></script>
<script>
  var cleave = new Cleave('.jumlah', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
</script>
  @endsection