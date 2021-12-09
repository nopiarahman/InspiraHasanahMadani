@extends('layouts.tema')
@section('content')
<div class="section-header">
    <h1>Cetak Kwitansi Cicilan</h1> 
    <div class="kanan">
      <button onclick="cetak('wrapper')" class="btn btn-primary"> <i class="fas fa-print fa-L"></i> Cetak Kwitansi</button>
      <a type="button" href="{{route('cetakKwitansiPDF',['id'=>$id->id])}}" class="btn btn-info ml-2"> <i class="fas fa-file-pdf    "></i> Cetak PDF</a>
    </div>
</div>

<div class="wrapper" id="wrapper">
  <!-- Main content -->
<div> {{-- invoice --}}    

  <section class="invoice ">
    <!-- title row -->
    <div class="row border-bottom ">
      <div class="col-12 ">
        <div class="page-header">
          <div class="row">
            <div class="col-3">
              <img src="{{Storage::url($proyek->logoPT)}}" width="200px" alt="" >
            </div>
            <div class="col-6 ml-n4">
              <h4 style="font-weight:900">{{$proyek->namaPT}}</h4>
              <small style="font-size: medium">{{$proyek->alamatPT}}</small> <br>
              <small style="font-size: medium"> <i class="fa fa-phone" aria-hidden="true"></i> : {{$proyek->telpPT}}</small><br>
              <small style="font-size: medium"> <i class="fas fa-envelope    "></i> : {{$proyek->emailPT}}</small>
            </div>
            <div class="col-3 ">
                <small style="font-size: medium">Nomor Faktur:            
                  @if(jenisKepemilikan($pembelian->pelanggan_id)=='Kavling')
                  CK
                  @else
                  CB
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
        <h1 class="text-primary">KWITANSI</h1>
      </div>
      
    </div>
    <table class="table table-sm table-responsive" style="font-size: medium">
      <tr style="font-size: medium">
        <td style="width: 20%"> Telah Diterima Dari</td>
        <td style="width: 25%">: <span class="font-weight-bold">{{$pembelian->pelanggan->nama}}</span></td>
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
          <span class="text-primary">TRANSFER</span></span>
          {{-- <span class="text-primary">{{$id->sumber}}</span> --}}
          @endif
        </span>
        <table class="" style="border-collapse: collapse">
          <tr class="px-n1">
            <th style="width: 70%">Total Hutang</th>
            <td>: <span class="text-warning"> Rp {{number_format($pembelian->sisaKewajiban)}}</span></td>
          </tr>
          <tr>
            <th>Angsuran Ke</th>
            <td>: {{cicilanKe($id->pembelian_id,$id->tanggal)}} ( {{terbilang(cicilanKe($id->pembelian_id,$id->tanggal))}} )</td>
          </tr>
          <tr>
            <th>Total Angsuran Dibayarkan</th>
            <td>: Rp. {{number_format(cicilanTerbayar($id->pembelian_id,$id->tanggal))}}</td>
          </tr>
          <tr>
            <th>Sisa Hutang</th>
          <td>: <span class="text-warning">Rp.{{number_format($id->pembelian->sisaKewajiban-cicilanTerbayar($id->pembelian_id,$id->tanggal))}}</td>
            {{-- <td>: <span class="text-warning">Rp. {{number_format($pembelian->sisaKewajiban-$sampaiSekarang->sum('jumlah'))}}</span> </td> --}}
          </tr>
          <tr>
            <th>Status</th>
            <td>: 
              @if($id->pembelian->sisaKewajiban-cicilanTerbayar($id->pembelian_id,$id->tanggal) <=0)
              <span class="text-primary"> Lunas </span>
              @else
              <span class="text-warning"> Belum Lunas </span>
              @endif
            </td>
          </tr>
          <tr>
            <th>Jatuh Tempo</th>
            <td>: 
              @if($id->pembelian->sisaKewajiban-cicilanTerbayar($id->pembelian_id,$id->tanggal) <=0)
              -
              @else
              1-10 {{Carbon\Carbon::parse($id->tempo)->isoFormat('MMMM YYYY')}}
              @endif
            </td>
          </tr>
          @if($kekurangan > 0)
          <tr>
            <th>Kekurangan Angsuran</th>
            <td>: Rp {{number_format($kekurangan)}}</td>
          </tr>
          @endif
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
        @forelse($rekening as $r)
        <span>{{$r->namaBank}} | {{$r->atasNama}} | {{$r->noRekening}}</span>
        @empty
        -
        @endforelse
      </div>
    </div>
    <!-- /.row -->
    
  </section>
</div>
<div class="d-none kwitansi2 "> {{-- invoice --}}    
  <section class="invoice " style="margin-top: 100px">
    <!-- title row -->
    <div class="row border-bottom mt-n5">
      <div class="col-12 ">
        <div class="page-header ">
          <div class="row">
            <div class="col-3 ">
              <img src="{{Storage::url($proyek->logoPT)}}" alt="" width="200px" class="pr-4">
            </div>
            <div class="col-6  ml-n4" >
              <h4 style="font-weight:900">{{$proyek->namaPT}}</h4>
              <small style="font-size: medium">{{$proyek->alamatPT}}</small> <br>
              <small style="font-size: medium"> <i class="fa fa-phone" aria-hidden="true"></i> : {{$proyek->telpPT}}</small><br>
              <small style="font-size: medium"> <i class="fas fa-envelope    "></i> : {{$proyek->emailPT}}</small>
            </div>
            <div class="col-3 ">
                <small style="font-size: medium">Nomor Faktur:            
                  @if(jenisKepemilikan($pembelian->pelanggan_id)=='Kavling')
                  CK
                  @else
                  CB
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
        <h1 class="text-primary">KWITANSI</h1>
      </div>
      
    </div>
    <table class="table table-sm table-responsive" style="font-size: medium">
      <tr style="font-size: medium">
        <td style="width: 20%"> Telah Diterima Dari</td>
        <td style="width: 25%">: <span class="font-weight-bold">{{$pembelian->pelanggan->nama}}</span></td>
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
          <span class="text-primary">TRANSFER</span></span>
          {{-- <span class="text-primary">{{$id->sumber}}</span> --}}
          @endif
        </span>
        <table class="" style="border-collapse: collapse">
          <tr class="px-n1">
            <th style="width: 70%">Total Hutang</th>
            <td>: <span class="text-warning"> Rp {{number_format($pembelian->sisaKewajiban)}}</span></td>
          </tr>
          <tr>
            <th>Angsuran Ke</th>
            <td>: {{cicilanKe($id->pembelian_id,$id->tanggal)}} ( {{terbilang(cicilanKe($id->pembelian_id,$id->tanggal))}} )</td>
          </tr>
          <tr>
            <th>Total Angsuran Dibayarkan</th>
            <td>: Rp. {{number_format(cicilanTerbayar($id->pembelian_id,$id->tanggal))}}</td>
          </tr>
          <tr>
            <th>Sisa Hutang</th>
            <td>: <span class="text-warning">Rp.{{number_format($id->pembelian->sisaKewajiban-cicilanTerbayar($id->pembelian_id,$id->tanggal))}}</td>
            </tr>
          <tr>
            <th>Status</th>
            <td>: 
              @if($id->pembelian->sisaKewajiban-cicilanTerbayar($id->pembelian_id,$id->tanggal) <=0)
              <span class="text-primary"> Lunas </span>
              @else
              <span class="text-warning"> Belum Lunas </span>
              @endif
            </td>
          </tr>
          <tr>
            <th>Jatuh Tempo</th>
            <td>: 
              @if($id->pembelian->sisaKewajiban-cicilanTerbayar($id->pembelian_id,$id->tanggal) <=0)
              -
              @else
              1-10 {{Carbon\Carbon::parse($id->tempo)->isoFormat('MMMM YYYY')}}
              @endif
            </td>
          </tr>
          @if($kekurangan > 0)
          <tr>
            <th>Kekurangan Angsuran</th>
            <td>: Rp {{number_format($kekurangan)}}</td>
          </tr>
          @endif
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
        @forelse($rekening as $r)
        <span>{{$r->namaBank}} | {{$r->atasNama}} | {{$r->noRekening}}</span>
        @empty
        -
        @endforelse
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