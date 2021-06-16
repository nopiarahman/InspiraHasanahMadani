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
    <form action="{{route('exportBulanan')}}" method="get" enctype="multipart/form-data">
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
  {{-- filter tanggal --}}
<div class="card my-n3">
<div class="section mt-4 mr-3 ">
         {{-- filter --}}
         <form action="{{route('laporanBulanan')}}" method="get" enctype="multipart/form-data">
  
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
                        '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                        'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                        'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                },cb);
                });
            </script>
        </div>
            {{-- end filter --}}
            
</div>
</div>
<div class="row">
  <div class="col-12">
<div class="card">
  <div class="card-header">
    <h4>Laporan Keuangan Bulan {{\Carbon\carbon::parse($start)->firstOfMonth()->isoFormat('MMMM')}}</h4>
  </div>
      <div class="card-body">

        <table class="table table-sm table-hover table-striped">
          <thead>
            <tr>
              <th scope="col" colspan="4" class="bg-primary text-white">Pendapatan</th>
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
        
            <tr class="border-top border-success">
              <th colspan=3" class="text-right " >Pendapatan Bulan {{\Carbon\carbon::parse($start)->isoFormat('MMMM')}}</th>
              @if($pendapatan !=null)
              <th class="">Rp.{{number_format($pendapatan->sum('kredit'))}}</th>
              @else
              <th class="">Rp.0</th>
              @endif
            </tr>
            <tr>
              <th colspan=3" class="text-right " >Sisa Saldo Bulan {{\Carbon\carbon::parse($start)->subMonths(1)->isoFormat('MMMM')}}</th>
              <th class="">Rp.{{number_format(saldoBulanSebelumnya($start))}}</th>
            </tr>
            <tr>
              <th colspan=3" class="text-right bg-secondary" >Total Pendapatan</th>
              @if($pendapatan !=null)
              <th class="bg-secondary">Rp.{{number_format(saldoBulanSebelumnya($start)+$pendapatan->sum('kredit'))}}</th>
              @else
              <th class="bg-secondary">Rp.0</th>
              @endif
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
              <tr class="border-top border-success">
                <th colspan="3" class="text-right " >Sub Total {{$judul}}</th>
                <th class="" >Rp. {{number_format($a[$judul])}}</th>
              </tr>
            @endforeach
              {{-- {{dd($a)}} --}}
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" class="text-right bg-secondary" >Total Biaya Operasional Bulanan</th>
                <th class="bg-secondary" >Rp. {{number_format(array_sum($c))}}</th>
            </tr>
            <tr>
              <th colspan="3" class="text-right bg-info text-white" >Total Laba/Rugi Berjalan</th>
              @if($pendapatan !=null)
              <th class="bg-info text-white" >Rp. {{number_format($pendapatan->sum('kredit')+saldoBulanSebelumnya($start)-array_sum($c))}}</th>
              @else
              <th class="bg-info text-white" >Rp. 0</th>
              @endif
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection