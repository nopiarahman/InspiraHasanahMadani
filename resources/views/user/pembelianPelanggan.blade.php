@extends('layouts.tema')
@section ('menuPembelianPelanggan','active')
@section('content')

<div class="section-header">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Data Pembelian</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item" aria-current="page"> Data Pembelian</li>
          {{-- <li class="breadcrumb-item" > Detail </li> --}}
        </ol>
      </nav>
    </div>
  </div>
</div>
{{-- Detail Pelanggan --}}
<div class="row ">
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card profile-widget">
      <div class="profile-widget-header">
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
        <div class="profile-widget-name ml-4 text-primary"> <h4>{{jenisKepemilikan($id->id)}} {{$dataPembelian->kavling->blok}} </h4><div class="text-muted d-inline font-weight-normal">
        </div>
        </div>
          <table class="table table-hover ml-3">
            <tbody>
              
                <th>Objek</th>
                <td style="width: 30%">{{jenisKepemilikan($id->id)}} ( @if($dataKavling == null)Akad Dibatalkan @else{{$dataKavling->blok}}@endif )</td>
                <td></td>
              </tr>
              <tr>
                <th scope="row">Nomor Akad</th>
                <td>
                  @if($dataPembelian->nomorAkad != null)
                  {{$dataPembelian->nomorAkad}}
                </td>
                  @else
                  Belum ada
                  </td>
                  @endif
              </tr>
              <tr>
                <th scope="row">Tanggal Akad</th>
                <td>
                  @if($dataPembelian->tanggalAkad != null)
                  {{$dataPembelian->tanggalAkad}}
                </td>
                  @else
                  Belum ada
                  </td>
                  @endif
              </tr>
              <tr>
                <th scope="row">Status DP</th>
                <td>{{$dataPembelian->statusDp}}</td>
                <td></td>
              </tr>
              <tr>
                <th>Sisa Dp</th>
                <td>Rp.{{number_format($dataPembelian->sisaDp)}}  
                  @if($dataPembelian->sisaDp==0)
                  /
                  <span class="badge badge-info text-white"><i class="fas fa-check"></i> Lunas</span>
                  @endif 
                </td>
                <td>
                  <a href="{{route('DPPelanggan')}}" class="btn btn-white text-primary border-success">Lihat Pembayaran</a>
                </td>
              </tr>
              <tr>
                <th>Status Cicilan</th>
                <td>{{$dataPembelian->statusCicilan}}</td>
                <td></td>
              </tr>
              <tr>
                <th>Sisa Hutang</th>
                <td>Rp {{number_format($dataPembelian->sisaCicilan)}}
                  @if($dataPembelian->sisaCicilan==0)
                  /
                  <span class="badge badge-info"><i class="fas fa-check"></i> Lunas</span>
                  @endif </td>
                <td>
                  <a href="{{route('unitPelanggan')}}" class="btn btn-white text-primary border-success">Lihat Pembayaran</a>
                </td>
              </tr>
            </tbody>
          </table>
        {{-- Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>. --}}
      </div>
    </div>
  </div>
  </div>
</div>
@endsection