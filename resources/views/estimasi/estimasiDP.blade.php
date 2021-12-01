@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuEstimasi','active')
@section ('menuEstimasiDp','active')
@section('content')
<div class="section-header sticky-top">
  <div class="container">
    <div class="row">
      <div class="col-6">
        <h1>Estimasi DP </h1>
      </div>
      <div class="kanan">
        <form action="{{route('exportEstimasiDp')}}" method="get" enctype="multipart/form-data">
          @csrf
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
          <button type="submit" class="btn btn-primary"> <i class="fas fa-file-excel"></i> Export Excel</button>
        </div>
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
      </div>
      
    </div>
  </div>
</div>
{{-- filter tanggal --}}
<div class="card">
  <div class="section mt-4 mr-3 ">
    {{-- filter --}}
    <div class="row">
      <div class="col-6"></div>
          <div class="col-6">
          <form action="{{route('estimasiDp')}}" method="get" enctype="multipart/form-data">
      
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
</div>
  {{-- Cicilan DP --}}
  <div class="card">
    <div class="card-header">
      <h4>Daftar DP Jatuh Tempo Bulan {{Carbon\Carbon::parse($start)->isoFormat('MMMM')}}</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover table-sm table-responsive-sm" id="dpAktif">
        <thead class="text-primary">
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">No Telp</th>
            <th scope="col">Nilai Cicilan</th>
            <th scope="col">Terbayar</th>
            <th scope="col">Tanggal Pembayaran</th>
            <th scope="col">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @php
          $n=1;
              $totalDP = 0;
              $totalDPTerbayar=0;
          @endphp
          @foreach($dpAktif as $dp)
            @if ($dp) 
              @if (cekPembayaranDP($dp->id,$start)==null && $dp->pembelian->sisaDp <= 0)
              @else
              <tr>
                <td>{{$n}}</td>
                @php
                    $n++;
                @endphp
                <td>{{$dp->pelanggan->nama}} | {{$dp->pelanggan->kavling->blok}}</td>
                <td>{{$dp->pelanggan->nomorTelepon}} </td>
                @if ($dp->pembelian->dp/$dp->pembelian->tenorDP >= $dp->sisaDp)
                    @php
                        $nilai = $dp->sisaDp
                    @endphp
                @else
                @php
                    $nilai = $dp->pembelian->dp/$dp->pembelian->tenorDP
                @endphp
                @endif
                <td data-order="{{$nilai}}">Rp. {{number_format($nilai)}}</td>
                @php
                    $totalDP += $nilai;
                @endphp
                @if (cekPembayaranDP($dp->id,$start)==null)
                    <td> <a href="{{route('DPKavlingTambah',['id'=>$dp->pembelian->id])}}"> 
                      <span class="text-danger"> Belum Dibayar</span></a></td>
                @else
                    <td data-order="{{cekPembayaranDP($dp->id,$start)}}">  <a href="{{route('DPKavlingTambah',['id'=>$dp->pembelian->id])}}">
                      <span class="text-primary">Rp. {{number_format(cekPembayaranDP($dp->id,$start))}}</span> </a></td>
                @endif
                @php
                    $totalDPTerbayar +=cekPembayaranDP($dp->id,$start);
                @endphp
                  @if(cekDPEstimasi($dp->id)!=null)
                  <td>
                    {{formatTanggal(cekDPEstimasi($dp->id)->tanggal)}}
                  </td>
                  @else
                  <td></td>
                  @endif
                @if ($dp->pembelian->sisaDp <= 0)
                <td> <span class="text-info">DP LUNAS</span> </td>
                @else
                <td>Sisa DP: Rp. {{number_format($dp->pembelian->sisaDp)}}</td>
                @endif
              </tr>
              @endif
            @endif
          @endforeach
        </tbody>
        {{-- <tfoot>
          <tr>
            <th colspan="3" class=" text-primary text-right border-success border-top">Total</th>
            <th class="border-success border-top text-primary">Rp.{{number_format($totalDP)}}</th>
            <th  class="border-success border-top text-primary">Rp.{{number_format($totalDPTerbayar)}}</th>
            <td colspan="2" class="border-success border-top text-primary"></td>
          </tr>
        </tfoot> --}}
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <div class="card card-hero ">
        <div class="card-header" style="background-image: linear-gradient(to bottom, #ffd208, #ee9c03);">
          <div class="card-icon" style="color: rgb(63, 35, 2)">
            <i class="fas fa-question" aria-hidden="true"></i>
          </div>
          <h4>Rp. {{number_format($totalDP)}}</h4>
          <div class="card-description">Total Estimasi Pemasukan</div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12">
      <div class="card card-hero ">
        <div class="card-header" style="background-image: linear-gradient(to bottom, #8fe700, #03a827);">
          <div class="card-icon" style="color: rgb(2, 63, 5)">
            <i class="fas fa-check" aria-hidden="true"></i>
          </div>
          <h4>Rp. {{number_format($totalDPTerbayar)}}</h4>
          <div class="card-description">Total Realisasi</div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script>
  //fungsi untuk filtering data berdasarkan tanggal 
  var start_date;
   var end_date;
   var DateFilterFunction = (function (oSettings, aData, iDataIndex) {
      var dateStart = parseDateValue(start_date);
      var dateEnd = parseDateValue(end_date);
      var evalDate= parseDateValue(aData[8]);
        if ( ( isNaN( dateStart ) && isNaN( dateEnd ) ) ||
             ( isNaN( dateStart ) && evalDate <= dateEnd ) ||
             ( dateStart <= evalDate && isNaN( dateEnd ) ) ||
             ( dateStart <= evalDate && evalDate <= dateEnd ) )
        {
            return true;
        }
        return false;
  });

  // fungsi untuk converting format tanggal dd/mm/yyyy menjadi format tanggal javascript menggunakan zona aktubrowser
  function parseDateValue(rawDate) {
      var dateArray= rawDate.split("/");
      var parsedDate= new Date(dateArray[2], parseInt(dateArray[1])-1, dateArray[0]);  // -1 because months are from 0 to 11   
      return parsedDate;
  }    

  $( document ).ready(function() {
  //konfigurasi DataTable pada tabel dengan id example dan menambahkan  div class dateseacrhbox dengan dom untuk meletakkan inputan daterangepicker
   var $dTable = $('#dpAktif').DataTable({
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
        },
    "dom": "<'row'<'col-sm-6'l><'col-sm-3' <'datesearchbox'>><'col-sm-3'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>"
   });

   //menambahkan daterangepicker di dalam datatables
   $("div.datesearchbox").html('<input type="text" class="form-control mb-3 mt-n2" id="datesearch" placeholder="Filter tanggal pembayaran..">');

   document.getElementsByClassName("datesearchbox")[0].style.textAlign = "right";

   //konfigurasi daterangepicker pada input dengan id datesearch
   $('#datesearch').daterangepicker({
      autoUpdateInput: false
    });

   //menangani proses saat apply date range
    $('#datesearch').on('apply.daterangepicker', function(ev, picker) {
       $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
       start_date=picker.startDate.format('DD/MM/YYYY');
       end_date=picker.endDate.format('DD/MM/YYYY');
       $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
       $dTable.draw();
    });

    $('#datesearch').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      start_date='';
      end_date='';
      $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
      $dTable.draw();
    });
  });
</script>


@endsection