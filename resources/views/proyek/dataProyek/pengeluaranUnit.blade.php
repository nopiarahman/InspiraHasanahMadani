@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuRAB','active')
@section ('menuDataProyek','active')
@section('content')
<div class="section-header sticky-top">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Pengeluaran {{$id->isi}}</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item"> <a href="{{route('RAB')}}"> RAB </a></li>
          <li class="breadcrumb-item"> <a href="{{route('biayaUnit')}}"> Biaya Unit </a></li>
          <li class="breadcrumb-item" aria-current="page"> Pengeluaran </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<div class="section-header">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h6 class="text-primary">Total RAB</h6>
      </div>
      <div class="col-md-3">
        <h6>: Rp.{{number_format($totalRAB)}}</h6>
      </div>
      <div class="col-md-3">
        <h6 class="text-primary">Total Pengeluaran</h6>
      </div>
      <div class="col-md-3">
        <h6 class="text-warning">: Rp.{{number_format($total->sum('debet'))}}</h6>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6"></div>
      <div class="col-md-3">
        <h6 class="text-primary">Persentase</h6>
      </div>
      <div class="col-md-3">
        @if($totalRAB != 0)
        <h6>: {{number_format((float)($total->sum('debet')/$totalRAB*100),2)}}%</h6>
        @else
        <h6>: 0%</h6>
        @endif
      </div>
    </div>
  </div>
</div>
<div class="card">
    <div class="card-header">
      <h4>Daftar Pengeluaran {{$id->isi}}</h4>
    </div>
    <div class="card-body">
      {{-- filter --}}
      <div class="row form-group">
        <div class="col">
          @if($id->getTable() =='rab')
          <form action="{{route('transaksiRAB',['id'=>$id->id])}}" method="get" enctype="multipart/form-data">
          @elseif($id->getTable()=='rabunit')
          <form action="{{route('transaksiRABUnit',['id'=>$id->id])}}" method="get" enctype="multipart/form-data">
          @endif
            <select class="form-control col-md-8" name="bulan" id=""  onchange="this.form.submit()">
              <option value="" @if ($bulanTerpilih ===0)
                  selected
              @endif>Semua Pengeluaran</option>
              @forelse ($periode as $p)
                  <option value="{{$p}}" @if ($bulanTerpilih ===$p)
                      selected
                  @endif>{{filterBulan($p)}}</option>
              @empty
              @endforelse
            </select> 
          </form> 
        </div>
        <div class="col-md-8 col-sm-12">
        @if($id->getTable() =='rab')
        <form action="{{route('transaksiRAB',['id'=>$id->id])}}" method="get" enctype="multipart/form-data">
        @elseif($id->getTable()=='rabUnit')
        <form action="{{route('transaksiRABUnit',['id'=>$id->id])}}" method="get" enctype="multipart/form-data">
        @endif
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-sm-12 col-md-6 col-lg-6 mt-1 mr-n3" > <span style="font-size:small">Pilih Tanggal: </span> </label>
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
          </div>
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
      </div>
      <table class="table table-sm table-striped" id="table">
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
            <td data-order="{{$transaksi->tanggal}}" >{{formatTanggal($transaksi->tanggal)}}</td>
            <td>
              @if($transaksi->rab)
            {{$transaksi->rab->kodeRAB}}
            @elseif($transaksi->rabUnit)
            {{$transaksi->rabUnit->kodeRAB}}
            @endif
            {{$transaksi->kategori}}
            </td>
            <td>{{$transaksi->uraian}}</td>
            <td>Rp.{{number_format($transaksi->debet)}}</td>
            <td>{{$transaksi->sumber}}</td>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4" style="text-align: right; font-weight:bold;" class="text-primary"> <h5> Total: {{number_format($totalFilter)}}</h5></td>
          </tr>
        </tfoot>
      </table>
      {{-- {{$transaksiKeluar->links()}} --}}
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