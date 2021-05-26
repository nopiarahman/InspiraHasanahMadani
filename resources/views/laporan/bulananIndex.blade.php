@extends('layouts.tema')
@section ('menuLaporanBulanan','active')
@section ('menuLaporan','active')
@section('content')
<div class="section-header">
  <div class="container">

    <div class="row">
      <div class="col-6">
        <h1>Laporan Keuangan Bulanan</h1>
      </div>
        <div class="col-6">
        {{-- filter --}}
      <form action="{{route('laporanBulanan')}}" method="get" enctype="multipart/form-data">
  
        <div class="form-group row ">
          <div class="input-group col-sm-12 col-md-12">
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
                  // autoUpdateInput: false,
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
              },cb);
              });
          </script>
          {{-- end filter --}}
      </div>
    </div>
  </div>
  </div>
</div>
<div class="card">
  <div class="card-header">
    <h4>Laporan Keuangan Bulan {{\Carbon\carbon::parse($end)->isoFormat('MMMM')}}</h4>
    
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card-body">
        <table class="table table-sm table-hover table-striped">
          <thead>
            <tr>
              <th scope="col" colspan="4" class="">Pendapatan</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pendapatan as $pd)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td colspan="2">{{$pd->uraian}}</td>
              <td>Rp.{{number_format($pd->kredit)}}</td>
            </tr>
            @endforeach
          </tbody>
        
            <tr>
              <th colspan=3" class="text-right bg-warning text-white" >Pendapatan Bulan {{\Carbon\carbon::parse($end)->isoFormat('MMMM')}}</th>
              <th class="bg-warning text-white">Rp.{{number_format($pendapatan->sum('kredit'))}}</th>
            </tr>
            <tr>
              <th colspan=3" class="text-right bg-warning text-white" >Sisa Saldo Bulan {{\Carbon\carbon::parse($start)->subMonths(1)->isoFormat('MMMM')}}</th>
              <th class="bg-warning text-white">Rp.{{number_format(pendapatanBulanSebelumnya($start,$end))}}</th>
            </tr>
          
            @php
            $a=[];
            $b=[];
            $c=[];
            $totalIsi=[];
            @endphp
            @foreach($perKategori as $judul=>$kategoriAkun)
            @php
              $a[$judul]=0;
              $c[$judul]=0;
              $totalIsi[$judul]=0;
            @endphp
            <tr>
              <th colspan="4" class="">{{$loop->iteration}}. {{$judul}}</th>
            </tr>
              @foreach($kategoriAkun as $kategori)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$kategori->kodeAkun}}</td>
                <td>{{$kategori->namaAkun}}</td>
                <td>Rp. {{number_format(transaksiAkun($kategori->id,$start,$end))}}</td>
              </tr>
              @php
                  $totalIsi[$judul]+=transaksiAkun($kategori->id,$start,$end);
              @endphp
              @endforeach
              @php
              $a[$judul]=$totalIsi[$judul]
              @endphp
              @php
                  $c[$judul]=$a[$judul]-$c[$judul];
              @endphp
              <tr>
                <th colspan="3" class="text-right bg-secondary" >Sub Total {{$judul}}</th>
                <th class="bg-secondary" >Rp. {{number_format($a[$judul])}}</th>
              </tr>
            @endforeach
              {{-- {{dd($a)}} --}}
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" class="text-right bg-warning text-white" >Total Biaya Operasional Bulanan</th>
                <th class="bg-warning text-white" >Rp. {{number_format(array_sum($c))}}</th>
            </tr>
            <tr>
              <th colspan="3" class="text-right bg-info text-white" >Total Laba/Rugi Berjalan</th>
                <th class="bg-info text-white" >Rp. {{number_format($pendapatan->sum('kredit')-array_sum($c))}}</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection