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
      <form action="{{route('exportTahunan')}}" method="get" enctype="multipart/form-data">
  
        <div class="form-group row ">
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
  {{-- filter tanggal --}}
  <div class="card my-n3">
    <div class="section mt-4 mr-3 ">
        {{-- filter --}}
        <form action="{{route('laporanTahunan')}}" method="get" enctype="multipart/form-data">
  
          <div class="form-group row ">
            <div class="input-group col-sm-12 col-md-12">
              <label class="col-form-label text-md-right col-12 col-md-6 col-lg-6 " > <span style="font-size:small">Pilih Tanggal: </span> </label>
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
                        'Tahun  Ini': [moment().startOf('year'), moment().endOf('year')],
                        'Tahun  Lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
                    }
                },cb);
                });
            </script>
            {{-- end filter --}}
            </div>
                {{-- end filter --}}
                
    </div>
    </div>
<div class="card">
  <div class="card-header">
    <h4>Laporan Keuangan Tahunan {{\Carbon\carbon::parse($start)->isoFormat('YYYY')}}</h4>
    
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
            {{-- {{dd($pendapatanLain)}} --}}
            @if($pendapatanLain->first() != null)
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
            @endif
            @php
                $totalProduksi = 0;
                $totalOperasional = 0;
                $totalNonOperasional = 0;
            @endphp
            @if($produksi->first() != null)
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
            @endif
            <tr>
              <th colspan="2" class="pt-3 bg-success text-white">Pengeluaran Operasional</th>
            </tr>
            <tr>
              <th colspan="2" class="">A. Biaya Operasional</th>
            </tr>
            @if($operasional->first() != null)
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
            @endif
            <tr >
              <th colspan="2" class="">B. Biaya Non Operasional</th>
            </tr>
            @if($nonOperasional->first() != null)
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
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection