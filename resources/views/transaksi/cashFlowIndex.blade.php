@extends('layouts.tema')
@section ('menuKasBesar','active')
@section ('menuKas','active')
@section('content')
<div class="section-header sticky-top">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Kas Besar</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item" aria-current="page"> Kas Besar </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
{{-- 
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
            <h4>Tambah Transaksi Masuk Kas Besar</h4>
          </div>
          <div class="card-body">
          <form action="{{route('kasBesarSimpan')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode Akun</label>
              <div class="input-group col-sm-12 col-md-7">
                  <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#pilihAkun">Pilih Akun</a>
                  <input type="text" hidden class="form-control" name="akun_id" id="idAkunCari" >
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Akun</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" readonly class="form-control" name="" id="isiNamaAkun" value="{{old('isiNamaAkun')}}">
              </div>
            </div>
            
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
    <h4>Daftar Kas Besar</h4>
  </div>
  <div class="card-body">
    {{-- filter --}}
    <form action="{{route('cashFlow')}}" method="get" enctype="multipart/form-data">

      <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-6 col-lg-6 mt-1 mr-n3" > <span style="font-size:small">Pilih Tanggal: </span> </label>
        <div class="input-group col-sm-12 col-md-6">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <i class="fa fa-calendar" aria-hidden="true"></i>
            </div>
          </div>
          <input type="text" id="reportrange" class="form-control filter @error('filter') is-invalid @enderror" name="filter" value="{{ request('filter') }}" id="filter">
          <input type="hidden" name="start" id="mulai" value="{{$start}}">
          <input type="hidden" name="end" id="akhir" value="{{$end}}">
          <button type="submit" class="btn btn-primary btn-icon icon-right">Filter
          <i class="fa fa-filter"></i>
          </button>
        </div>
      </form>
      <script type="text/javascript">
        $(function() {
            moment.locale('id');
            var start = moment($('#mulai').val());
              var end = moment($('#akhir').val());
            function cb(start, end) {
                $('#reportrange span').html(start.format('D M Y') + ' - ' + end.format('DD MMMM YYYY'));
                $('#mulai').val(start);
                $('#akhir').val(end);
            }
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Hari Ini': [moment(), moment()],
                    'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                    '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                    'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                    'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);
            });
        </script>
        {{-- end filter --}}
    <table class="table table-sm table-striped table-hover mt-3">
      <thead>
        <tr>
          <th scope="col">Tanggal</th>
          <th scope="col">Kode Transaksi</th>
          <th scope="col">Uraian</th>
          <th scope="col">Kredit</th>
          <th scope="col">Debit</th>
          <th scope="col">Saldo</th>
          <th scope="col">Sumber</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="2"></td>
          <th class="text-primary " colspan="3" >Sisa Saldo Sebelumnya</th>
          <th class="text-primary">Rp.{{number_format($awal->saldo+$awal->debit-$awal->kredit)}}</th>
        </tr>
        @foreach($cashFlow as $transaksi)
        <tr>
          <td>{{formatTanggal($transaksi->tanggal)}}</td>
          <td>{{$transaksi->akun->kodeAkun}}</td>
          <td>{{$transaksi->uraian}}</td>
          <td>
            @if($transaksi->kredit != null)
            Rp.{{number_format($transaksi->kredit)}}
            @endif
          </td>
          <td>
            @if($transaksi->debet != null)
            Rp.{{number_format($transaksi->debet)}}
            @endif
          </td>
          <td>Rp.{{number_format($transaksi->saldo)}}</td>
          <td>{{$transaksi->sumber}}</td>
          {{-- <td><a href="#" class="badge badge-primary">Detail</a></td> --}}
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <tr class="bg-light">
            <th colspan="3" class="text-right text-primary">Total</th>
            <th class="text-primary">Rp. {{number_format($cashFlow->sum('kredit'))}}</th>
            <th class="text-primary">Rp. {{number_format($cashFlow->sum('debet'))}}</th>
            <th colspan="2" class="text-primary">Rp. {{number_format(saldoTerakhir())}}</th>
          </tr>
        </tr>
      </tfoot>
    </table>
    {{-- {{$cashFlow->links()}} --}}
  </div>
</div>
{{-- Modal --}}
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
              @foreach($semuaAkun  as $akun)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$akun->kodeAkun}}</td>
                  <td>{{$akun->namaAkun}}</td>
                  <td>
                    @if($akun->namaAkun == 'Pendapatan')
                    {{-- <a href="#" disabled class="badge badge-info pilihRAB" id="akun" >Pilih</a> --}}
                    @else
                    <a href="#" class="badge badge-info pilihRAB" data-id-akun={{$akun->id}} data-isi="{{$akun->namaAkun}}" id="akun" >Pilih</a>
                    @endif
                  </td>
                </tr>
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
@endsection