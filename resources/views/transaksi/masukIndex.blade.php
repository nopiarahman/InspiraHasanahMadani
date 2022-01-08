@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuTransaksiMasuk','active')
@section ('menuTransaksi','active')
@section('content')
<div class="section-header sticky-top">
  <div class="container">
    <div class="row">
      <div class="col-3">
        <h1>Transaksi Masuk</h1>
      </div>
      
      <div class="col-9">
        {{-- filter --}}
    <form action="{{route('transaksiMasuk')}}" method="get" enctype="multipart/form-data">

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

<div class="card">
  <div class="card-header">
    <h4>Daftar Transaksi Masuk</h4>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-6"></div>
      <div class="col-6">
{{-- filter --}}
<form action="{{route('exportMasuk')}}" method="get" enctype="multipart/form-data">
  <div class="form-group row mb-4">
    {{-- <label class="col-form-label text-md-right col-12 col-md-6 col-lg-6 mt-1 mr-n3" > <span style="font-size:small">Pilih Tanggal: </span> </label> --}}
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
    {{-- </div> --}}
  </div>
</div>
    <table class="table table-sm table-hover table-striped mt-3" id="table">
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
        @foreach($transaksiMasuk as $transaksi)
        <tr>
          <td dat-order="{{$transaksi->tanggal}}" >{{formatTanggal($transaksi->tanggal)}}</td>
          <td>
            @if($transaksi->rab)
            {{$transaksi->rab->kodeRAB}}
            @elseif($transaksi->rabUnit)
            {{$transaksi->rabUnit->kodeRAB}}
            @endif
            {{$transaksi->kategori}}
          </td>
          <td>{{$transaksi->uraian}}</td>
          <td data-order="{{$transaksi->kredit}}" >Rp.{{number_format($transaksi->kredit)}}</td>
          <td>{{$transaksi->sumber}}</td>
          {{-- <td><a href="#" class="badge badge-primary">Detail</a></td> --}}
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr class="bg-light">
          <th colspan="3" class="text-right text-primary">Total Transaksi</th>
          <th colspan="2" class="text-primary">Rp. {{number_format($transaksiMasuk->sum('kredit'))}}</th>
        </tr>
      </tfoot>
    </table>
    {{-- {{$transaksiMasuk->links()}} --}}
  </div>
</div>
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