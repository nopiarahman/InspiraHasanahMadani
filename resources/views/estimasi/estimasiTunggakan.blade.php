@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuEstimasi','active')
@section ('menuEstimasiTunggakan','active')
@section('content')
<div class="section-header sticky-top">
  <div class="container">
    <div class="row">
      <div class="col-6">
        <h1>Tunggakan </h1>
      </div>
      <div class="col-6">
        <form action="{{route('estimasi')}}" method="get" enctype="multipart/form-data">
    
          <div class="form-group row ">
            <div class="input-group col-sm-12 col-md-12">
              {{-- <label class="col-form-label text-md-right col-12 col-md-6 col-lg-6 " > <span style="font-size:small">Pilih Tanggal: </span> </label> --}}
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
                    // autoUpdateInput: false,
                    startDate: start,
                    endDate: end,
                    ranges: {
                        '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                        'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                        'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                },cb);
                });
            </script>
      </div>
    </div>
  </div>
</div>
{{-- filter tanggal --}}
<div class="card">
  <div class="section mt-4 mr-3 ">
           {{-- filter --}}
           
          </div>
              {{-- end filter --}}
              
  </div>
</div>
  {{-- DP NUNGGAK --}}
  <div class="card">
    <div class="card-header">
      <h4 class="text-danger">DP Tertunggak</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover table-sm table-responsive-sm" id="dpNunggak">
        <thead class="text-danger">
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Blok</th>
            <th scope="col">Jenis</th>
            <th scope="col">No Telp</th>
            <th scope="col">Jatuh Tempo</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($DPtertunggak as $tunggakan)
              @if($tunggakan)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$tunggakan->pelanggan->nama}}</td>
                  <td>{{$tunggakan->pelanggan->kavling->blok}}</td>
                  <td>{{jenisKepemilikan($tunggakan->pelanggan->id)}}</td>
                  <td>{{$tunggakan->pelanggan->nomorTelepon}}</td>
                  <td><a class="text-danger" href="{{route('DPKavlingTambah',['id'=>$tunggakan->pembelian_id])}}">
                    1-10 {{Carbon\Carbon::parse($tunggakan->tempo)->isoFormat('MMMM YYYY')}}
                    </a>
                  </td>
                </tr>
              @endif
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h4 class="text-danger">Cicilan Tertunggak</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover table-sm table-responsive-sm" id="cicilanNunggak">
        <thead class="text-danger">
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Blok</th>
            <th scope="col">Jenis</th>
            <th scope="col">No Telp</th>
            <th scope="col">Jatuh Tempo</th>
            <th scope="col">Nominal Tunggakan</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($cicilanTertunggak as $tunggakan)
            @if($tunggakan)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$tunggakan->pelanggan->nama}}</td>
              <td>{{$tunggakan->pelanggan->kavling->blok}}</td>
              <td>{{jenisKepemilikan($tunggakan->pelanggan->id)}}</td>
              <td>{{$tunggakan->pelanggan->nomorTelepon}}</td>
              <td>
                <a class="text-danger" href="{{route('unitKavlingDetail',['id'=>$tunggakan->pembelian_id])}}">
                  1-10 {{Carbon\Carbon::parse($tunggakan->tempo)->isoFormat('MMMM YYYY')}}
                  </a>
              </td>
              <td></td>
            </tr>
            @endif
            @empty
            <tr>
              <td>Tidak Ada Tunggakan</td>
            </tr>
            @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
@section('script')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript" >
    $('#dpNunggak').DataTable({
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
    $('#cicilanNunggak').DataTable({
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