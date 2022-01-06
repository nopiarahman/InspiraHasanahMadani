@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuKas','active')
@section ('menuKasKecilLapangan','active')
@section('content')
<div class="section-header sticky-top">
  <div class="container">
    <div class="row">
        <div class="col-6">
          <h1>Kas Kecil Lapangan</h1>
        </div>
        <div class="col-6">
           {{-- filter --}}
    <form action="{{route('exportKasLapangan')}}" method="get" enctype="multipart/form-data">
      <div class="form-group row mb-4">
        <div class="input-group col-sm-12 col-md-12">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <i class="fa fa-calendar" aria-hidden="true"></i>
            </div>
          </div>
          <input type="text" id="reportrange2" class="form-control filter @error('filter') is-invalid @enderror" name="filter" value="{{ request('filter') }}" id="filter">
          <input type="hidden" name="start" id="mulai2" value="{{$start}}">
          <input type="hidden" name="end" id="akhir2" value="{{$end}}">
          <button type="submit" class="btn btn-primary btn-icon icon-right">
            <i class="fas fa-file-excel    "></i>
            Export
          </button>
        </div>
      </form>
      <script type="text/javascript">
        $(function() {
            moment.locale('id');
            var start = moment($('#mulai2').val());
              var end = moment($('#akhir2').val());
            function cb(start, end) {
                $('#reportrange2 span').html(start.format('D M Y') + ' - ' + end.format('DD MMMM YYYY'));
                $('#mulai2').val(start);
                $('#akhir2').val(end);
            }
            $('#reportrange2').daterangepicker({
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
        </div>
      </div>
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
    <div class="section-header">
      <a href="{{route('kasKecilLapangan')}}"  class="btn btn-primary disabled ">Masuk</a>
      <a href="{{route('kasKecilLapanganKeluar')}}" class="btn btn-primary ml-2">Keluar</a>
  </div>
  @if(auth()->user()->role=="admin" || auth()->user()->role=="projectmanager")
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Tambah Transaksi Masuk Kas Kecil Lapangan</h4>
          </div>
          <div class="card-body">
          <form action="{{route('kasKecilLapanganMasukSimpan')}}" method="POST" enctype="multipart/form-data">
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
      <form action="{{route('kasKecilLapangan')}}" method="get" enctype="multipart/form-data">

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
          <table class="table table-sm my-3 bg-light ">
            <tr>
              <th class="text-primary text-right pr-5">Sisa Saldo Sebelumnya:  Rp.{{number_format($saldoSebelum)}}</th>
            </tr>
          </table>
        <table class="table table-sm table-hover table-striped mt-3" id="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Uraian</th>
              <th scope="col">Kredit</th>
              <th scope="col">Debit</th>
              <th scope="col">Saldo</th>
              <th scope="col">Sumber</th>
              @if(auth()->user()->role=="admin" || auth()->user()->role=="projectmanager")
              <th scope="col">Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
              {{-- <tr>
                <td colspan="2"></td>
                <th class="text-primary " colspan="3" >Sisa Saldo Sebelumnya</th>
                <th class="text-primary">Rp.{{number_format($saldoSebelum)}}</th>
              </tr> --}}
              @php
                  $saldo = $saldoSebelum;
              @endphp
              @foreach($kasKecilLapangan as $kas)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{formatTanggal($kas->tanggal)}}</td>
                <td>{{$kas->uraian}} {{$kas->jumlah}} {{$kas->satuan}}</td>
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
                <td>Rp. {{number_format($saldo+$kas->kredit-$kas->debet)}}</td>
                @php
                    $saldo=$saldo+$kas->kredit-$kas->debet
                @endphp
                <td>{{$kas->sumber}}</td>
                @if(auth()->user()->role=="admin" || auth()->user()->role=="projectmanager")
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
              <th class="text-primary">Rp. {{number_format($kasKecilLapangan->sum('kredit'))}}</th>
              <th class="text-primary">Rp. {{number_format($kasKecilLapangan->sum('debet'))}}</th>
              <th colspan="2" class="text-primary">Rp. {{number_format(totalKasKecilLapangan($start,$end))}}</th>
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
              document.getElementById('formHapus').action='/hapusKasKecilLapangan/'+id;
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