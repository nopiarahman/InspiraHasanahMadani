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
      <a href="{{route('kasPendaftaranMasuk')}}"  class="btn btn-primary ">Masuk</a>
      <a href="{{route('kasPendaftaranKeluar')}}" class="btn btn-primary ml-2 disabled">Keluar</a>
  </div>
  @if(auth()->user()->role=="admin")
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Tambah Transaksi Keluar Kas Pendaftaran</h4>
          </div>
          <div class="card-body">
          <form action="{{route('kasPendaftaranKeluarSimpan')}}" method="POST" enctype="multipart/form-data">
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
  @endif
    <div class="card">
      <div class="card-header">
        <h4>Daftar Transaksi</h4>
      </div>
      <div class="card-body">
        {{-- filter --}}
      <form action="{{route('kasPendaftaranKeluar')}}" method="get" enctype="multipart/form-data">

        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-6 col-lg-6 mt-1 mr-n3" > <span style="font-size:small">Pilih Tanggal: </span> </label>
          <div class="input-group col-sm-12 col-md-6">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <i class="fa fa-calendar" aria-hidden="true"></i>
              </div>
            </div>
            <input type="text" id="reportrange" class="form-control filter @error('filter') is-invalid @enderror" name="filter" value="{{ request('filter') }}" id="filter">
            <input type="hidden" name="start" id="mulai">
            <input type="hidden" name="end" id="akhir">
            <button type="submit" class="btn btn-primary btn-icon icon-right">Filter
            <i class="fa fa-filter"></i>
            </button>
          </div>
        </form>
        <script type="text/javascript">
          $(function() {
              moment.locale('id');
              var start = moment().subtract(29, 'days');
              var end = moment();
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
        <table class="table table-sm table-hover table-striped mt-3">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Uraian</th>
              <th scope="col">Kredit</th>
              <th scope="col">Debit</th>
              <th scope="col">Saldo</th>
              <th scope="col">Sumber</th>
              @if(auth()->user()->role=="admin")
              <th scope="col">Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
              <tr>
                <td colspan="2"></td>
                <th class="text-primary " colspan="3" >Sisa Saldo Sebelumnya</th>
                <th class="text-primary">Rp.{{number_format(saldoPendaftaranBulanSebelumnya($start))}}</th>
              </tr>
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
                @if(auth()->user()->role=="admin")
                <td>
                  <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
                  data-toggle="modal" 
                  data-target="#hapusTransaksi" 
                  data-id="{{$kas->id}}" 
                  data-uraian="{{$kas->uraian}}">
                  <i class="fa fa-trash" aria-hidden="true" ></i> Hapus</button>  
                </td>
                @endif
              </tr>
              @endforeach
          </tbody>
          <tfoot>
            <tr class="bg-light">
              <th colspan="3" class="text-right text-primary">Total</th>
              <th class="text-primary">Rp. {{number_format($kasPendaftaran->sum('kredit'))}}</th>
              <th class="text-primary">Rp. {{number_format($kasPendaftaran->sum('debet'))}}</th>
              <th colspan="2" class="text-primary">Rp. {{number_format(totalKasPendaftaran($start,$end))}}</th>
              <td></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
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
        document.getElementById('formHapus').action='/hapusKasPendaftaran/'+id;
        })
      });
    </script>
    <script src="{{ mix("js/cleave.min.js") }}"></script>
<script src="{{ mix("js/addons/cleave-phone.id.js") }}"></script>
<script>
  var cleave = new Cleave('.jumlah', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
</script>
  @endsection