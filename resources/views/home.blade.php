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
          <canvas id="sales-chart" height="63" width="269" style="display: block; height: 71px; width: 300px;" class="chartjs-render-monitor"></canvas>
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
          <canvas id="balance-chart" height="63" width="269" style="display: block; height: 71px; width: 300px;" class="chartjs-render-monitor"></canvas>
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
          <canvas id="sales-chart" height="63" width="269" style="display: block; height: 71px; width: 300px;" class="chartjs-render-monitor"></canvas>
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
          <h4>Statistics</h4>
          <div class="card-header-action">
            <div class="btn-group">
              <a href="#" class="btn btn-primary">Week</a>
              <a href="#" class="btn">Month</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="myChart" height="182"></canvas>
          <div class="statistic-details mt-sm-4">
            <div class="statistic-details-item">
              <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 7%</span>
              <div class="detail-value">$243</div>
              <div class="detail-name">Today's Sales</div>
            </div>
            <div class="statistic-details-item">
              <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</span>
              <div class="detail-value">$2,902</div>
              <div class="detail-name">This Week's Sales</div>
            </div>
            <div class="statistic-details-item">
              <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>9%</span>
              <div class="detail-value">$12,821</div>
              <div class="detail-name">This Month's Sales</div>
            </div>
            <div class="statistic-details-item">
              <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 19%</span>
              <div class="detail-value">$92,142</div>
              <div class="detail-name">This Year's Sales</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
      <div class="card">
        <div class="card-header">
          <h4>Recent Activities</h4>
        </div>
        <div class="card-body">
          <ul class="list-unstyled list-unstyled-border">
            <li class="media">
              <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-1.png" alt="avatar">
              <div class="media-body">
                <div class="float-right text-primary">Now</div>
                <div class="media-title">Farhan A Mujib</div>
                <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
              </div>
            </li>
            <li class="media">
              <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-2.png" alt="avatar">
              <div class="media-body">
                <div class="float-right">12m</div>
                <div class="media-title">Ujang Maman</div>
                <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
              </div>
            </li>
            <li class="media">
              <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-3.png" alt="avatar">
              <div class="media-body">
                <div class="float-right">17m</div>
                <div class="media-title">Rizal Fakhri</div>
                <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
              </div>
            </li>
            <li class="media">
              <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-4.png" alt="avatar">
              <div class="media-body">
                <div class="float-right">21m</div>
                <div class="media-title">Alfa Zulkarnain</div>
                <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
              </div>
            </li>
          </ul>
          <div class="text-center pt-1 pb-1">
            <a href="#" class="btn btn-primary btn-lg btn-round">
              View All
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
{{-- <script src="{{asset('assets/js/page/index-0.js')}}"></script> --}}
@endsection
