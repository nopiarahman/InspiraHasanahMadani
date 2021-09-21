@extends('layouts.tema')
@section ('menuDashboard','active')
@section('content')
<div class="section-header">
    <h1>Dashboard</h1>
  </div>
  @if(auth()->user()->role=="pelanggan")
  <div class="row ">
    <div class="col-6 col-md-6 col-sm-12">
      <div class="card profile-widget">
        <div class="profile-widget-header">
          <img style="width: 150px" alt="image" 
          @if (detailUser(auth()->user()->id)->poto != null)
              src="{{Storage::url(detailUser(auth()->user()->id)->poto)}}"
              @else
              src="{{asset('assets/img/avatar/avatar-1.png')}}"   
              @endif
          class="rounded-circle profile-widget-picture" st>
          <div class="profile-widget-items">
            <div class="profile-widget-item">
              <div class="profile-widget-item-label">Blok</div>
              <div class="profile-widget-item-value">@if($dataKavling == null)Akad Dibatalkan @else{{$dataKavling->blok}}@endif</div>
            </div>
            <div class="profile-widget-item">
              <div class="profile-widget-item-label">Jenis Kepemilikan</div>
              <div class="profile-widget-item-value">{{jenisKepemilikan($id->id)}}</div>
            </div>
          </div>
        </div>
        <div class="profile-widget-description">
          <div class="profile-widget-name ml-4 text-primary"> <h4> {{$id->nama}} </h4><div class="text-muted d-inline font-weight-normal">
          </div>
          </div>
            <table class="table table-hover ml-3">
              <tbody>
                <tr>
                  <th>Nama Lengkap</th>
                  <td>{{$id->nama}}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>{{$id->email}}</td>
                </tr>
                <tr>
                  <th>Tempat & Tanggal Lahir</th>
                  <td>{{$id->tempatLahir}} / {{carbon\carbon::parse($id->tanggalLahir)->isoFormat('DD MMMM YYYY')}}</td>
                </tr>
                <tr>
                  <th>Alamat</th>
                  <td>{{$id->alamat}}</td>
                </tr>
                <tr>
                  <th>Jenis Kelamin</th>
                  <td>{{$id->jenisKelamin}}</td>
                </tr>
                <tr>
                  <th>Status Pernikahan</th>
                  <td>{{$id->statusPernikahan}}</td>
                </tr>
                <tr>
                  <th>Pekerjaan</th>
                  <td>{{$id->pekerjaan}}</td>
                </tr>
                <tr>
                  <th>Nomor Telepon</th>
                  <td>{{$id->nomorTelepon}}</td>
                </tr>
                
              </tbody>
            </table>
          {{-- Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>. --}}
        </div>
      </div>
    </div>
    <div class="col-6 col-md-6 col-sm-12 mt-5">
      <div class="card card-hero ">
        <div class="card-header">
          <div class="card-icon" style="color: rgb(192, 125, 0)">
            <i class="fas fa-coins    "></i>
          </div>
          <div class="card-description">Status DP :
            @if($dataPembelian->sisaDp >0)
            Belum Lunas
            @else
            -
            @endif
          </div>
          
          @if($dataPembelian->sisaDp >0)
          <h4 style="font-size: x-large" >Sisa DP : Rp. {{number_format($dataPembelian->sisaDp)}}</h4>
          @else
          <h4>Lunas</h4>
          @endif
        </div>
        <div class="card-body p-0">
          <div class="tickets-list">
            <a href="#" class="ticket-item">
              <div class="ticket-title">
                <h4>Riwayat Pembayaran</h4>
              </div>
              @forelse($dpPelanggan->take(2)->sortByDesc('no') as $dp)
              <div class="ticket-info">
                <div>Cicilan DP Ke: {{$dp->urut}} Rp.{{number_format($dp->jumlah)}}</div>
                <div class="bullet"></div>
                <div class="text-primary">{{Carbon\Carbon::parse($dp->created_at)->diffForHumans()}}</div>
              </div>
              @empty
            </a>
            <div class="ticket-info">
              <div>Tidak Ada data</div>
            </div>
            @endforelse
            <a href="{{route('DPPelanggan')}}" class="ticket-item ticket-more">
              Lihat lengkap <i class="fas fa-chevron-right"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="card card-hero ">
        <div class="card-header" style="background-image: linear-gradient(to bottom, #8fe700, #03a827);">
          <div class="card-icon" style="color:green">
            <i class="fas fa-money-bill-wave " aria-hidden="true"></i>
          </div>
          <div class="card-description">Status Cicilan :
            @if($dataPembelian->sisaCicilan >0)
            Belum Lunas
            @else
            -
            @endif
          </div>
          
          @if($dataPembelian->sisaCicilan >0)
          <h4 style="font-size: x-large">Sisa Kewajiban : Rp. {{number_format($dataPembelian->sisaCicilan)}}</h4>
          @else
          Lunas
          @endif
        </div>
        <div class="card-body p-0">
          <div class="tickets-list">
            <a href="#" class="ticket-item">
              <div class="ticket-title">
                <h4>Riwayat Pembayaran</h4>
              </div>
              @forelse($cicilanPelanggan->take(2) as $cicilan)
              <div class="ticket-info">
                <div>Cicilan Ke: {{$cicilan->urut}} Rp.{{number_format($cicilan->jumlah)}}</div>
                <div class="bullet"></div>
                <div class="text-primary">{{Carbon\Carbon::parse($cicilan->created_at)->diffForHumans()}}</div>
              </div>
              @empty
            </a>
            <div class="ticket-info">
              <div>Tidak Ada data</div>
            </div>
            @endforelse
            <a href="{{route('unitPelanggan')}}" class="ticket-item ticket-more">
              Lihat lengkap <i class="fas fa-chevron-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
  @endif
  @if(auth()->user()->role=="admin" || auth()->user()->role=="projectmanager")
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
          <i class="fas fa-donate    "></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Kas Kecil</h4>
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
      {{-- @if(auth()->user()->role=="admin")
      <div class="row">
        <div class="col-md-6 col-12 col-sm-12">
          <div class="card card-hero ">
            <div class="card-header">
              <div class="card-icon" style="color: rgb(192, 125, 0)">
                <i class="fas fa-coins    "></i>
              </div>
              <h4>{{$transferDp->count()}}</h4>
              <div class="card-description">Pelanggan Transfer DP</div>
            </div>
            <div class="card-body p-0">
              <div class="tickets-list">
                @forelse($transferDp->take(2)->sortByDesc('created_at') as $dp)
                <a href="#" class="ticket-item">
                  <div class="ticket-title">
                    <h4>{{$dp->pelanggan->nama}}</h4>
                  </div>
                  <div class="ticket-info">
                    <div>{{jenisKepemilikan($dp->pelanggan->id)}} {{$dp->pelanggan->kavling->blok}}</div>
                    <div class="bullet"></div>
                    <div class="text-primary">{{Carbon\Carbon::parse($dp->created_at)->diffForHumans()}}</div>
                  </div>
                </a>
                @empty
                <div class="ticket-info">
                  <div>Tidak Ada data</div>
                </div>
                @endforelse
                <a href="{{route('cekTransferDPPelanggan')}}" class="ticket-item ticket-more">
                  View All <i class="fas fa-chevron-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-12 col-sm-12">
          <div class="card card-hero ">
            <div class="card-header" style="background-image: linear-gradient(to bottom, #8fe700, #03a827);">
              <div class="card-icon" style="color: green">
                <i class="fas fa-money-bill-wave" aria-hidden="true"></i>
              </div>
              <h4>{{$transferUnit->count()}}</h4>
              <div class="card-description">Pelanggan Transfer Cicilan</div>
            </div>
            <div class="card-body p-0">
              <div class="tickets-list">
                @forelse($transferUnit->take(2)->sortByDesc('created_at') as $dp)
                <a href="#" class="ticket-item">
                  <div class="ticket-title">
                    <h4>{{$dp->pelanggan->nama}}</h4>
                  </div>
                  <div class="ticket-info">
                    <div>{{jenisKepemilikan($dp->pelanggan->id)}} {{$dp->pelanggan->kavling->blok}}</div>
                    <div class="bullet"></div>
                    <div class="text-primary">{{Carbon\Carbon::parse($dp->created_at)->diffForHumans()}}</div>
                  </div>
                </a>
                @empty
                <a href="#" class="ticket-item">
                <div class="ticket-title">
                  <h4>Tidak Ada data</h4>
                </div>
              </a>
                @endforelse
                <a href="{{route('cekTransferDPPelanggan')}}" class="ticket-item ticket-more">
                  View All <i class="fas fa-chevron-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>
      @endif --}}
    </div>
    @endif
    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
      @if(auth()->user()->role=="admin")
      <div class="card">
        <div class="card-header">
          <h4>Quick Link</h4>
        </div>
        <div class="card-body">
          <a href="{{route('transaksiKeluar')}}" class="btn btn-icon icon-left btn-primary col-12 my-1"><i class="fas fa-money-bill"></i> Tambah Transaksi Keluar</a>
          <a href="{{route('kasPendaftaranMasuk')}}" class="btn btn-icon icon-left btn-primary col-12 my-1"><i class="fas fa-money-bill"></i> Kas Pendaftaran</a>
          <a href="{{route('pettyCash')}}" class="btn btn-icon icon-left btn-primary col-12 my-1"><i class="fas fa-piggy-bank    "></i> Kas Kecil</a>
        </div>
      </div>
      @endif
      @if(auth()->user()->role=="admin" || auth()->user()->role=="projectmanager")
      <div class="card">
        <div class="card-header">
          <h4>Status Proyek</h4>
        </div>
        <div class="card-body justify-content-center mb-3">
          <span>Jumlah Unit:</span><h4 class="text-large text-primary"> {{$kavling->count()}} Unit</h4>
          <span>Jumlah Unit Terjual:</span><h4 class="text-primary"> {{$kavling->where('pelanggan_id','!=',0)->count()}} Unit</h4>
        </div>
      </div>
      @endif
    </div>
  </div>
@endsection

@section('script')
{!! $chartKasBesar->script() !!} 
{{-- <script src="{{asset('assets/js/index.js')}}"></script> --}}
@endsection
