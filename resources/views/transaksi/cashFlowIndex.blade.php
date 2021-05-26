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
<div class="section-header">

</div> --}}

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
    {{$cashFlow->links()}}
  </div>
</div>
@endsection