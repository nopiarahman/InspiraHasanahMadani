@extends('layouts.tema')
@section ('menuEstimasi','active')
@section('content')
<div class="section-header">
  <div class="container">
    <div class="row">
      <div class="col-6">
        <h1>Estimasi Pemasukan Bulanan </h1>
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
  {{-- Cicilan DP --}}
  <div class="card">
    <div class="card-header">
      <h4>Daftar DP Aktif</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover table-sm table-responsive-sm">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">No Telp</th>
            <th scope="col">Blok</th>
            <th scope="col">Jenis</th>
            <th scope="col">Nilai Cicilan</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($dpAktif as $dp)
          <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$dp->pelanggan->nama}}</td>
            <td>{{$dp->pelanggan->nomorTelepon}}</td>
            <td>{{$dp->pelanggan->kavling->blok}}</td>
            <td>{{jenisKepemilikan($dp->pelanggan->id)}}</td>
            <td>Rp. {{number_format($dp->sisaDp)}}</td>
          </tr>
          @endforeach
        </tbody>

      </table>
    </div>
  </div>
  {{-- Cicilan Unit --}}
  <div class="card">
    <div class="card-header">
      <h4>Daftar Cicilan Aktif</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover table-sm table-responsive-sm">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">No Telp</th>
            <th scope="col">Blok</th>
            <th scope="col">Jenis</th>
            <th scope="col">Nilai Cicilan</th>
            <th scope="col">Cicilan Ke</th>
            <th scope="col">Terbayar</th>
          </tr>
        </thead>
        <tbody>
          @php
              $totalCicilan = 0;
              $totalTerbayar=0;
          @endphp
          @foreach($cicilanAktif as $cicilan)
          <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$cicilan->pelanggan->nama}}</td>
            <td>{{$cicilan->pelanggan->nomorTelepon}}</td>
            <td>{{$cicilan->pelanggan->kavling->blok}}</td>
            <td>{{jenisKepemilikan($cicilan->pelanggan->id)}}</td>
            <td>Rp. {{number_format($cicilan->pembelian->sisaKewajiban/$cicilan->pembelian->tenor)}}</td>
            @php
                $totalCicilan += $cicilan->pembelian->sisaKewajiban/$cicilan->pembelian->tenor;
            @endphp
            <td>{{cekCicilanTerakhir($cicilan->pembelian->id)->urut+1}}</td>
            @if (cekCicilanTerbayar($cicilan->id,$start)==null)
                <td> <span class="text-danger"> Belum Dibayar</span></td>
            @else
                <td> <span class="text-primary">Rp. {{number_format(cekCicilanTerbayar($cicilan->id,$start))}}</span> </td>
            @endif
            @php
                $totalTerbayar +=cekCicilanTerbayar($cicilan->id,$start);
            @endphp
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="5" class=" text-primary text-right border-success border-top">Total</th>
            <th class="border-success border-top text-primary">Rp.{{number_format($totalCicilan)}}</th>
            <th class=" text-primary text-right border-success border-top">Total</th>
            <th class="border-success border-top text-primary">Rp.{{number_format($totalTerbayar)}}</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection