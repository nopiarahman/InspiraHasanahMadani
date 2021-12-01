@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuEstimasi','active')
@section ('menuEstimasiCicilan','active')
@section('content')
<div class="section-header sticky-top">
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
  {{-- Cicilan Unit --}}
  <div class="card">
    <div class="card-header">
      <h4>Daftar Cicilan  Jatuh Tempo Bulan {{Carbon\Carbon::parse($start)->isoFormat('MMMM')}}</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover table-sm table-responsive-sm" id="cicilanAktif">
        <thead class="text-primary">
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">No Telp</th>
            <th scope="col">Nilai Cicilan</th>
            <th scope="col">Terbayar</th>
            <th scope="col">Tanggal Pembayaran</th>
          </tr>
        </thead>
        <tbody>
          @php
              $totalCicilan = 0;
              $totalTerbayar=0;
              $n=1;
          @endphp
          @foreach($cicilanAktif as $cicilan)
          @if ($cicilan)
            @if (cekPembayaranCicilan($cicilan->id)==null && $cicilan->pembelian->sisaKewajiban <= 0)
            @else
            <tr>
              <td>{{$n}}</td>
              @php
                  $n++;
              @endphp
              <td> {{$cicilan->pelanggan->nama}} | {{$cicilan->pelanggan->kavling->blok}}</td>
              <td>{{$cicilan->pelanggan->nomorTelepon}}</td>
              @if ($cicilan->pembelian->sisaKewajiban/$cicilan->pembelian->tenor >= $cicilan->sisaKewajiban)
              @php
                  $nilai = $cicilan->sisaKewajiban
              @endphp
              @else
              @php
                  $nilai = $cicilan->pembelian->sisaKewajiban/$cicilan->pembelian->tenor
              @endphp
              @endif
              <td data-order="{{$nilai}}">Rp. {{number_format($nilai)}}</td>
              @php
                  $totalCicilan += $nilai;
              @endphp
              @if (cekPembayaranCicilan($cicilan->id)==null)
                  <td> <a href="{{route('unitKavlingDetail',['id'=>$cicilan->pembelian->id])}}"> <span class="text-danger"> Belum Dibayar</span></a></td>
              @else
                  <td data-order="{{cekPembayaranCicilan($cicilan->id)}}"><a href="{{route('unitKavlingDetail',['id'=>$cicilan->pembelian->id])}}"> <span class="text-primary">Rp. {{number_format(cekPembayaranCicilan($cicilan->id))}}</span> </a></td>
              @endif
              @php
                  $totalTerbayar +=cekPembayaranCicilan($cicilan->id);
              @endphp
                @if(cekPembayaranEstimasi($cicilan->id)!=null)
                <td data-order="{{cekPembayaranEstimasi($cicilan->id)->tanggal}}">
                  {{formatTanggal(cekPembayaranEstimasi($cicilan->id)->tanggal)}}
                </td>
                @else
                <td></td>
              @endif
            </tr>
            @endif
          @endif
          @endforeach
        </tbody>
        <tfoot>
        </tfoot>
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
          <h4>Rp. {{number_format($totalCicilan)}}</h4>
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
          <h4>Rp. {{number_format($totalTerbayar)}}</h4>
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
   var $dTable = $('#cicilanAktif').DataTable({
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
    "dom": "<'row'<'col-sm-6'l><'col-sm-3' <'datesearchbox2'>><'col-sm-3'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>"
   });

   //menambahkan daterangepicker di dalam datatables
   $("div.datesearchbox2").html('<input type="text" class="form-control mb-3 mt-n2" id="datesearch2" placeholder="Filter tanggal pembayaran..">');

   document.getElementsByClassName("datesearchbox2")[0].style.textAlign = "right";

   //konfigurasi daterangepicker pada input dengan id datesearch
   $('#datesearch2').daterangepicker({
      autoUpdateInput: false
    });

   //menangani proses saat apply date range
    $('#datesearch2').on('apply.daterangepicker', function(ev, picker) {
       $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
       start_date=picker.startDate.format('DD/MM/YYYY');
       end_date=picker.endDate.format('DD/MM/YYYY');
       $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
       $dTable.draw();
    });

    $('#datesearch2').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      start_date='';
      end_date='';
      $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
      $dTable.draw();
    });
  });
</script>
@endsection