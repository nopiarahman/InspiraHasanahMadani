@extends('layouts.tema')
@section ('menuDashboard','active')
@section('content')
<div class="section-header">
    <h1>Dashboard</h1>
  </div>
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12">
      <a href="{{route('cashFlow')}}">
      <div class="card card-statistic-2">
        <div class="card-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          {{-- <canvas id="sales-chart" height="63" width="269" style="display: block; height: 71px; width: 300px;" class="chartjs-render-monitor"></canvas> --}}
        </div>
        <div class="card-icon shadow-primary bg-primary">
          <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Kas Besar</h4>
          </div>
          <div class="card-body">
            <h4>
              Rp. {{number_format(saldoTerakhir())}}
            </h4>
          </div>
        </div>
      </div>
      </a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
      <a href="{{route('kasPendaftaranMasuk')}}">
      <div class="card card-statistic-2">
        <div class="card-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          {{-- <canvas id="balance-chart" height="63" width="269" style="display: block; height: 71px; width: 300px;" class="chartjs-render-monitor"></canvas> --}}
        </div>
        <div class="card-icon shadow-primary bg-primary">
          <i class="fas fa-coins"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Kas Pendaftaran</h4>
          </div>
          <div class="card-body">
            <h4>
              Rp. {{number_format(saldoTerakhirKasPendaftaran())}}
            </h4>
          </div>
        </div>
      </div>
      </a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12">
      <a href="{{route('pettyCash')}}">
      <div class="card card-statistic-2">
        <div class="card-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          {{-- <canvas id="sales-chart" height="63" width="269" style="display: block; height: 71px; width: 300px;" class="chartjs-render-monitor"></canvas> --}}
        </div>
        <div class="card-icon shadow-primary bg-primary">
          <i class="fas fa-piggy-bank"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Petty Cash</h4>
          </div>
          <div class="card-body">
            <h4>
              Rp. {{number_format(saldoTerakhirPettyCash())}}
            </h4>
          </div>
        </div>
      </div>
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-8 col-md-12 col-12 col-sm-12">
      <div class="card">
        <div class="card-header">
          <h4>Kas Besar</h4>
          <div class="card-header-action">
            {{-- <div class="btn-group">
              <a href="#" class="btn btn-primary">Week</a>
              <a href="#" class="btn">Month</a>
            </div> --}}
          </div>
        </div>
        <div class="card-body">
          <div style="height: 400px">
            {!! $chartKasBesar->container() !!}
        </div>
        </div>
      </div>
    </div>
    @if(auth()->user()->role=="admin")
    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
      <div class="card">
        <div class="card-header">
          <h4>Quick Link</h4>
        </div>
        <div class="card-body">
          <a href="{{route('transaksiKeluar')}}" class="btn btn-icon icon-left btn-primary col-12"><i class="fas fa-money-bill"></i> Tambah Transaksi Keluar</a>
        </div>
      </div>
    </div>
    @endif
  </div>
@endsection

@section('script')
{!! $chartKasBesar->script() !!} 
{{-- <script src="{{asset('assets/js/index.js')}}"></script> --}}
@endsection
