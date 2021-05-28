@extends('layouts.tema')
@section ('menuLaporanTahunan','active')
@section ('menuLaporan','active')
@section('content')
<div class="section-header">
  <div class="container">

    <div class="row">
      <div class="col-6">
        <h1>Laporan Keuangan Tahunan</h1>
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
              var start = moment().startOf('year');
              var end = moment().endOf('year');
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
                      'Tahun  Ini': [moment().startOf('year'), moment().endOf('year')],
                      'Tahun  Lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
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
    <h4>Laporan Keuangan Tahunan {{\Carbon\carbon::now()->isoFormat('YYYY')}}</h4>
    
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card-body">
        <table class="table table-sm table-hover table-striped">
          <tbody>
            <tr>
              <th colspan="2" class="pt-3 bg-success text-white">Pendapatan</th>
            </tr>
            <tr>
              <th colspan="2" class="">A. Pendapatan Usaha</th>
            </tr>
            <tr>
              <td class="pl-4">Penjualan</td>
              <td>Rp. {{number_format(penjualanTahunan($start,$end))}}</td>
            </tr>
            <tr>
              <th colspan="2" class="">B. Pendapatan Lain-lain</th>
            </tr>
            @foreach ($pendapatanLain as $produk)
              <tr>
                <td class="pl-4">{{$produk->namaAkun}}</td>
                <td >Rp. {{number_format(pendapatanLainTahunan($produk->id,$start,$end))}}</td>
              </tr>
            @endforeach
            <tr class="border border-success">
              
            <th >Total Pendapatan</th>
            <th class="">Rp. {{number_format(penjualanTahunan($start,$end)+pendapatanLainTahunan($produk->id,$start,$end))}}</th>
          </tr>
            <tr>
              <th colspan="2" class="">Biaya Atas Pendapatan</th>
            </tr>
            <tr>
              <th colspan="2" class="">A. Biaya Produksi</th>
            </tr>
            @php
                $totalProduksi = 0;
                $totalOperasional = 0;
                $totalNonOperasional = 0;
            @endphp
            @foreach ($produksi as $produk)
              <tr>
                <td class="pl-4">{{$produk->namaAkun}}</td>
                <td>Rp. {{number_format(transaksiAkunTahunan($produk->id,$start,$end))}}</td>
              </tr>
              @php
                  $totalProduksi += transaksiAkunTahunan($produk->id,$start,$end);
              @endphp
            @endforeach
            <tr>
              <td class="pl-4">Biaya Pembangunan Rumah </td>
              <td>Rp. {{number_format(biayaPembangunanRumahTahunan($start,$end))}}</td>
            </tr>
            <tr>
              <td class="pl-4">Biaya Pembebanan Per-Unit </td>
              <td>Rp. {{number_format(biayaPembebananTahunan($start,$end))}}</td>
            </tr>
            <tr class="border border-success">
              <th class="border-top">Total Biaya Produksi</th>
              <th class="border-top">Rp. {{number_format($totalProduksi+biayaPembebananTahunan($start,$end)+biayaPembangunanRumahTahunan($start,$end))}}</th>
            </tr>
            <tr>
              <th class="bg-secondary">Laba Kotor</th>
              <th class="bg-secondary">
                Rp. {{number_format((penjualanTahunan($start,$end)+pendapatanLainTahunan($produk->id,$start,$end))-($totalProduksi+biayaPembebananTahunan($start,$end)+biayaPembangunanRumahTahunan($start,$end)))}}
              </th>
            </tr>
            <tr>
              <th colspan="2" class="pt-3 bg-success text-white">Pengeluaran Operasional</th>
            </tr>
            <tr>
              <th colspan="2" class="">A. Biaya Operasional</th>
            </tr>
            @foreach ($operasional as $produk)
              <tr>
                <td class="pl-4">{{$produk->namaAkun}}</td>
                <td>Rp. {{number_format(transaksiAkunTahunan($produk->id,$start,$end))}}</td>
              </tr>
              @php
                  $totalOperasional += transaksiAkunTahunan($produk->id,$start,$end);
              @endphp
            @endforeach
            <tr class="border border-success">
              <th class="">Total Biaya Operasional</th>
              <th class="">Rp. {{number_format($totalOperasional)}}</th>
            </tr>
            <tr >
              <th colspan="2" class="">B. Biaya Non Operasional</th>
            </tr>
            @foreach ($nonOperasional as $produk)
              <tr>
                <td class="pl-4">{{$produk->namaAkun}}</td>
                <td>Rp. {{number_format(transaksiAkunTahunan($produk->id,$start,$end))}}</td>
              </tr>
              @php
                  $totalNonOperasional += transaksiAkunTahunan($produk->id,$start,$end);
              @endphp
            @endforeach
            <tr class="border border-success">
              <th class="">Total Biaya Non Operasional</th>
              <th class="">Rp. {{number_format($totalNonOperasional)}}</th>
            </tr>
            <tr class="border border-success">
              <th class="bg-secondary">Total Pengeluaran Operasional</th>
              <th class="bg-secondary">Rp. {{number_format($totalNonOperasional+$totalOperasional)}}</th>
            </tr>
            <tr>
              <th class="bg-warning text-white">Laba/Rugi Operasional</th>
              <th class="bg-warning text-white">Rp. {{number_format(((penjualanTahunan($start,$end)+pendapatanLainTahunan($produk->id,$start,$end))-($totalProduksi+biayaPembebananTahunan($start,$end)+biayaPembangunanRumahTahunan($start,$end)))-($totalNonOperasional+$totalOperasional))}}</th>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection