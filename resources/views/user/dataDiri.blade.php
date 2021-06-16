@extends('layouts.tema')
@section ('menuDataDiri','active')
@section('content')

<div class="section-header">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Data Diri</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item" aria-current="page"> Data Diri</li>
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
  </div>
</div>
@endsection