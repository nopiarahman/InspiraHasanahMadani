@extends('layouts.tema')
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
      <form action="{{route('transaksiRABUnit',['id'=>$id->id])}}" method="get" enctype="multipart/form-data">

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
      </div>
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
 
@endsection