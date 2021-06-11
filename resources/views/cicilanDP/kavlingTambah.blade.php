@extends('layouts.tema')
@section ('menuCicilanDP','active')
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
            <li class="breadcrumb-item"> <a href="{{route('DPKavling')}}"> Cicilan Dp </a></li>
            <li class="breadcrumb-item" aria-current="page"> Tambah </li>
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
    <div class="card">
      <div class="card-header">
        <h4>Pembayaran DP</h4>
      </div>
      <div class="card-body">
      <form action="{{route('DPKavlingSimpan')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Pembayaran</label>
          <div class="col-sm-12 col-md-7">
            <input type="hidden" class="form-control " name="pembelian_id" value="{{$id->id}}" >
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
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Akad DP</label>
          <div class="input-group col-sm-12 col-md-7">
            <div class="input-group-prepend">
              <div class="input-group-text">
                Rp
              </div>
            </div>
            <input type="text" readonly class="akadDp form-control"  value="{{$id->dp}} " id="totalDiskon">
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pembayaran DP</label>
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
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
          <div class="col-sm-12 col-md-7">
            <button class="btn btn-primary" type="submit" @if($id->sisaDp==0) disabled @endif >Tambah Pembayaran</button>
          </div>
        </div>
      </form>
      </div>
    </div>
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
            {{-- @if($loop->last == true) --}}
          <td>
            <a href="{{route('cetakKwitansiDp',['id'=>$cicilanDp->id])}}" class="btn btn-white text-primary"> <i class="fas fa-file-invoice    "></i> Kwitansi</a>
            <button type="button" class="btn btn-sm btn-white text-danger" 
            data-toggle="modal" 
            data-target="#exampleModalCenter" 
            data-id="{{$cicilanDp->id}}">
            <i class="fa fa-trash" aria-hidden="true" ></i> Hapus </button>   
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot class="bg-light">
        <tr >
          <th style="text-align: right" colspan="2">Total Terbayar</th>
          <th>Rp.{{number_format($id->dp-$id->sisaDp)}}</th>
          <td></td>
          <td></td>
          <td></td>
        </tr>

      </tfoot>
    </table>
    
  </div>
</div>
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