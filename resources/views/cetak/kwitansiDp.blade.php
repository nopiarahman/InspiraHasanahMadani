@extends('layouts.tema')
@section('content')
<div class="section-header">
    <h1>Cetak Kwitansi DP</h1> 
    <div class="kanan">
      <button onclick="cetak('wrapper')" class="btn btn-primary"> <i class="fas fa-print fa-L"></i> Cetak Kwitansi</button>
      {{-- <a href="javascript:generatePDF()" class="btn btn-info ml-2"> <i class="fas fa-print fa-L"></i> Cetak PDF</a> --}}
      <a type="button" href="{{route('cetakDPPDF',['id'=>$id->id])}}" class="btn btn-info ml-2"> <i class="fas fa-file-pdf    "></i> Cetak PDF</a>
    </div>
</div>

<div class="wrapper" id="wrapper">
  <!-- Main content -->
<div> {{-- invoice --}}    
  <section class="invoice">
    <!-- title row -->
    <div class="row border-bottom d-none d-md-block">
      <div class="col-md-12 col-sm-12 ">
        <div class="page-header">
          <div class="row">
            <div class="col-md-2 col-sm-12">
              <img src="{{asset('assets/img/favicon.png')}}" alt="" class="pl-4">
            </div>
            <div class="col-md-7 col-sm-12">
              <h4 style="font-weight:900">PT. INSPIRA HASANAH MADANI</h4>
              <small style="font-size: medium">Jl. Jenderal A. Thalib no 12 Telanaipura. Jambi</small> <br>
              <small style="font-size: medium"> <i class="fa fa-phone" aria-hidden="true"></i> : 0741-3071990</small><br>
              <small style="font-size: medium"> <i class="fas fa-envelope    "></i> : inspirahasanahmadani@gmail.com</small>
            </div>
            <div class="col-md-3 col-sm-12">
                <small style="font-size: medium">Nomor Faktur:            
                  @if(jenisKepemilikan($pembelian->pelanggan_id)=='Kavling')
                  DK
                  @else
                  DB
                  @endif {{romawi(Carbon\Carbon::parse($id->tanggal)->isoFormat('MM'))}}/{{$id->ke}}</small><br>
                <small style="font-size: medium">Tanggal: {{formatTanggal($id->tanggal)}} </small> <br>
                <small style="font-size: medium">Kode Pelanggan: C{{$pembelian->kavling->blok}}</small>
            </div>
          </div>
        </h2>
      </div>
    </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info mt-2 justify-content-md-center">
      <div class="align-center">
        <h1 class="text-primary">KWITANSI DP</h1>
      </div>
      
    </div>
    <table class="table table-sm table-responsive" style="font-size: medium">
      <tr style="font-size: medium">
        <td style="width: 20%"> Telah Diterima Dari</td>
        <td style="width: 15%">: <span class="font-weight-bold">{{$pembelian->pelanggan->nama}}</span></td>
        <td></td>
        <th rowspan="2" style="width: 65%;vertical-align:middle" class="border border-success"> 
          <h5 class="text-center align-middle mb-n1" style="font-style: italic">{{terbilang($id->jumlah)}} Rupiah</h5> 
        </th>
      </tr>
      <tr>
        <td>Sejumlah Uang</td>
        <td>: <span class="font-weight-bold" > Rp. {{number_format($id->jumlah)}}</span></td>
      </tr>
    </table>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row ">
      <div class="col-12 table-responsive">
        <table class="table table-striped table-sm">
          <thead>
          <tr>
            <th>No</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>1</td>
            <td>{{$uraian}}</td>
            <td>Rp. {{number_format($id->jumlah)}}</td>
          </tr>
          </tbody>
          <tfoot>
            <tr>
              <th></th>
              <th class="text-right">Total:</th>
              <th>Rp. {{number_format($id->jumlah)}}</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
        <span class="lead font-weight-bold">Metode Pembayaran: 
          @if($id->sumber == 'Cash' || $id->sumber == 'cash')
          <span class="text-primary">TUNAI</span></span>
          @else
          <span class="text-primary">{{$id->sumber}}</span>
          @endif
        </span>
        <table class="" style="border-collapse: collapse">
          <tr class="px-n1">
            <th style="width: 70%">Total Hutang</th>
            <td>: <span class="text-warning"> Rp {{number_format($pembelian->dp)}}</span></td>
          </tr>
          <tr>
            <th>Angsuran DP Ke</th>
            <td>: {{$id->urut}} ( {{terbilang($id->urut)}} )</td>
          </tr>
          <tr>
            <th>Total Angsuran Dibayarkan</th>
            <td>: Rp. {{number_format($sampaiSekarang->sum('jumlah'))}}</td>
          </tr>
          <tr>
            <th>Sisa Hutang</th>
            <td>: <span class="text-warning">Rp. {{number_format($pembelian->dp-$sampaiSekarang->sum('jumlah'))}}</span> </td>
          </tr>
          <tr>
            <th>Status</th>
            <td>: 
              @if($pembelian->dp-$sampaiSekarang->sum('jumlah') <=0)
              <span class="text-primary"> Lunas </span>
              @else
              <span class="text-warning"> Belum Lunas </span>
              @endif
            </td>
          </tr>
          <tr>
            <th>Jatuh Tempo</th>
            <td>: 1-10 {{Carbon\Carbon::parse($id->tempo)->isoFormat('MMMM YYYY')}}
            </td>
          </tr>
        </table>
      </div>
      <!-- /.col -->
      <div class="col-6">
        <div style="height: 90%">
        </div>
        <div class="table-responsive">
          <table class="table table-sm" >
            <tr class="text-center">
              <th class=" border-top" width="50%">Kasir</th>
              <th class=" border-top ">Penyetor</th>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <div class="row justify-content-md-center mt-4">
      <div class="align-center ">
        <span>BNI Syariah | PT . Inspira Hasanah Madani | 2020011334</span>
      </div>
    </div>
    <!-- /.row -->
    
  </section>
</div>
<div class="d-none kwitansi2"> {{-- invoice --}}    
  <section class="invoice">
    <!-- title row -->
    <div class="row border-bottom ">
      <div class="col-md-12 col-sm-12">
        <div class="page-header">
          <div class="row">
            <div class="col-md-2 col-sm-12">
              <img src="{{asset('assets/img/favicon.png')}}" alt="" class="pl-4">
            </div>
            <div class="col-md-7 col-sm-12">
              <h4 style="font-weight:900">PT. INSPIRA HASANAH MADANI</h4>
              <small style="font-size: medium">Jl. Jenderal A. Thalib no 12 Telanaipura. Jambi</small> <br>
              <small style="font-size: medium"> <i class="fa fa-phone" aria-hidden="true"></i> : 0741-3071990</small><br>
              <small style="font-size: medium"> <i class="fas fa-envelope    "></i> : inspirahasanahmadani@gmail.com</small>
            </div>
            <div class="col-md-3 col-sm-12">
                <small style="font-size: medium">Nomor Faktur:            
                  @if(jenisKepemilikan($pembelian->pelanggan_id)=='Kavling')
                  DK
                  @else
                  DB
                  @endif {{romawi(Carbon\Carbon::parse($id->tanggal)->isoFormat('MM'))}}/{{$id->ke}}</small><br>
                <small style="font-size: medium">Tanggal: {{formatTanggal($id->tanggal)}} </small> <br>
                <small style="font-size: medium">Kode Pelanggan: C{{$pembelian->kavling->blok}}</small>
            </div>
          </div>
        </h2>
      </div>
    </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info mt-2 justify-content-md-center">
      <div class="align-center">
        <h1 class="text-primary">KWITANSI DP</h1>
      </div>
      
    </div>
    <table class="table table-sm table-responsive" style="font-size: medium">
      <tr style="font-size: medium">
        <td style="width: 20%"> Telah Diterima Dari</td>
        <td style="width: 15%">: <span class="font-weight-bold">{{$pembelian->pelanggan->nama}}</span></td>
        <td></td>
        <th rowspan="2" style="width: 65%;vertical-align:middle" class="border border-success"> 
          <h5 class="text-center align-middle mb-n1" style="font-style: italic">{{terbilang($id->jumlah)}} Rupiah</h5> 
        </th>
      </tr>
      <tr>
        <td>Sejumlah Uang</td>
        <td>: <span class="font-weight-bold" > Rp. {{number_format($id->jumlah)}}</span></td>
      </tr>
    </table>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row ">
      <div class="col-12 table-responsive">
        <table class="table table-striped table-sm">
          <thead>
          <tr>
            <th>No</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>1</td>
            <td>{{$uraian}}</td>
            <td>Rp. {{number_format($id->jumlah)}}</td>
          </tr>
          </tbody>
          <tfoot>
            <tr>
              <th></th>
              <th class="text-right">Total:</th>
              <th>Rp. {{number_format($id->jumlah)}}</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
        <span class="lead font-weight-bold">Metode Pembayaran: 
          @if($id->sumber == 'Cash' || $id->sumber == 'cash')
          <span class="text-primary">TUNAI</span></span>
          @else
          <span class="text-primary">{{$id->sumber}}</span>
          @endif
        </span>
        <table class="" style="border-collapse: collapse">
          <tr class="px-n1">
            <th style="width: 70%">Total Hutang</th>
            <td>: <span class="text-warning"> Rp {{number_format($pembelian->dp)}}</span></td>
          </tr>
          <tr>
            <th>Angsuran DP Ke</th>
            <td>: {{$id->urut}} ( {{terbilang($id->urut)}} )</td>
          </tr>
          <tr>
            <th>Total Angsuran Dibayarkan</th>
            <td>: Rp. {{number_format($sampaiSekarang->sum('jumlah'))}}</td>
          </tr>
          <tr>
            <th>Sisa Hutang</th>
            <td>: <span class="text-warning">Rp. {{number_format($pembelian->dp-$sampaiSekarang->sum('jumlah'))}}</span> </td>
          </tr>
          <tr>
            <th>Status</th>
            <td>: 
              @if($pembelian->dp-$sampaiSekarang->sum('jumlah') <=0)
              <span class="text-primary"> Lunas </span>
              @else
              <span class="text-warning"> Belum Lunas </span>
              @endif
            </td>
          </tr>
          <tr>
            <th>Jatuh Tempo</th>
            <td>: 1-10 {{Carbon\Carbon::parse($id->tempo)->isoFormat('MMMM YYYY')}}
            </td>
          </tr>
        </table>
      </div>
      <!-- /.col -->
      <div class="col-6">
        <div style="height: 90%">
        </div>
        <div class="table-responsive">
          <table class="table table-sm" >
            <tr class="text-center">
              <th class=" border-top" width="50%">Kasir</th>
              <th class=" border-top ">Penyetor</th>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <div class="row justify-content-md-center mt-4">
      <div class="align-center ">
        <span>BNI Syariah | PT . Inspira Hasanah Madani | 2020011334</span>
      </div>
    </div>
    <!-- /.row -->
    
  </section>
</div>
  <!-- /.content -->
</div>

<script>
  function cetak(el){
    var restorePage = document.body.innerHTML;
    var printContent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printContent;
    var inputBaru = document.querySelector('.kwitansi2');
    inputBaru.className ='kwitansi2';
    window.print();
    document.body.innerHTML = restorePage;
  }
</script>
@endsection