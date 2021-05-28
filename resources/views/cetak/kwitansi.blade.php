@extends('layouts.tema')
@section('content')
<div class="section-header">
    <h1>Cetak Kwitansi</h1>
</div>

<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row border-bottom my-3">
      <div class="col-12 pb-3">
        <div class="page-header">
          <div class="row">
            <div class="col-2">
              <img src="{{asset('assets/img/favicon.png')}}" alt="" class="pl-4">
            </div>
            <div class="col-7">
              <h4>PT. INSPIRA HASANAH MADANI</h4>
              <small style="font-size: medium">Jl. Jenderal A. Thalib no 12 Telanaipura. Jambi</small> <br>
              <small style="font-size: medium"> <i class="fa fa-phone" aria-hidden="true"></i> : 0741-3071990</small><br>
              <small style="font-size: medium"> <i class="fas fa-envelope    "></i> : inspirahasanahmadani@gmail.com</small>
            </div>
            <div class="col-3 ">
                <small style="font-size: medium">Invoice #007612 </small><br>
                <small style="font-size: medium">Order ID: 4F3S8J </small><br>
                <small style="font-size: medium">Payment Due: 2/22/2014< </small> <br>
                <small style="font-size: medium">Account: 968-34567 </small>
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
        <td > Telah Diterima Dari</td>
        <td>: Nopi Arahman</td>
        <th rowspan="2" class="justify-content"> Nominal</th>
      </tr>
      <tr>
        <td>Sejumlah Uang</td>
        <td>: Rp.800.000</td>
      </tr>
    </table>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row mt-2">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
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
            <td>El snort testosterone trophy driving gloves handsome</td>
            <td>Rp.800.000</td>
          </tr>
          </tbody>
          <tfoot>
            <tr>
              <th></th>
              <th class="text-right">Total:</th>
              <th>Rp.800.000</th>
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
        <span class="lead font-weight-bold">Metode Pembayaran: <span class="text-primary">TUNAI</span></span>

        <table class="table table-sm">
          <tr>
            <td>Total Hutang</td>
            <td>:</td>
          </tr>
          <tr>
            <td>Angsuran Ke</td>
            <td>:</td>
          </tr>
          <tr>
            <td>Nilai Angsuran</td>
            <td>:</td>
          </tr>
          <tr>
            <td>Total Angsuran Dibayarkan</td>
            <td>:</td>
          </tr>
          <tr>
            <td>Diskon</td>
            <td>:</td>
          </tr>
          <tr>
            <td>Sisa Hutang</td>
            <td>:</td>
          </tr>
          <tr>
            <td>Status</td>
            <td>: Belum Lunas</td>
          </tr>
          <tr>
            <td>Jatuh Tempo</td>
            <td>:</td>
          </tr>
        </table>
      </div>
      <!-- /.col -->
      <div class="col-6">
        <p class="lead">Amount Due 2/22/2014</p>

        <div class="table-responsive">
          <table class="table table-sm">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td>$250.30</td>
            </tr>
            <tr>
              <th>Tax (9.3%)</th>
              <td>$10.34</td>
            </tr>
            <tr>
              <th>Shipping:</th>
              <td>$5.80</td>
            </tr>
            <tr>
              <th>Total:</th>
              <td>$265.24</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@endsection