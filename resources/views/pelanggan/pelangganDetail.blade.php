@extends('layouts.tema')
@section ('menuPelanggan','active')
@section('content')

<div class="section-header">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Detail Pelanggan</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item"> <a href="{{route('pelangganIndex')}}"> Pelanggan</a></li>
          <li class="breadcrumb-item" aria-current="page"> Detail </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
    {{-- Alert --}}
    <div class="row">
      <div class="col-12">
        @if (session('status'))
          <div class="alert alert-success alert-dismissible show fade">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            {{session ('status')}}
          </div>
        @endif
      </div>
    </div>
{{-- Detail Pelanggan --}}
<div class="row mt-sm-4">
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card profile-widget">
      <div class="profile-widget-header">
        <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture">
        <div class="profile-widget-items">
          <div class="profile-widget-item">
            <div class="profile-widget-item-label">Blok</div>
            <div class="profile-widget-item-value">@if($dataKavling == null)Akad Dibatalkan @else{{$dataKavling->blok}}@endif</div>
          </div>
          <div class="profile-widget-item">
            <div class="profile-widget-item-label">Jenis Kepemilikan</div>
            <div class="profile-widget-item-value">{{jenisKepemilikan($id->id)}}</div>
          </div>
          <div class="profile-widget-item">
            <button onclick="cetak('cetakPelanggan')" class="btn btn-primary"> <i class="fas fa-print fa-L"></i> Cetak Pelanggan</button>
          </div>
        </div>
      </div>
      <div class="profile-widget-description">
        <div class="profile-widget-name ml-4 text-primary"> <h4> {{$id->nama}} </h4><div class="text-muted d-inline font-weight-normal">
        </div>
        </div>
          <table class="table table-hover">
            <tbody>
              <tr>
                <th>Objek</th>
                <td>{{jenisKepemilikan($id->id)}} ( @if($dataKavling == null)Akad Dibatalkan @else{{$dataKavling->blok}}@endif )</td>
                <td></td>
              </tr>
              <tr>
                <th scope="row">Nomor Akad</th>
                <td>
                  {{-- @if($dataKavling =! null) Akad Dibatalkan @else --}}
                  @if($dataPembelian->nomorAkad != null)
                  {{$dataPembelian->nomorAkad}}
                </td>
                  <td>
                    <a href="#" class="badge badge-warning text-dark"
                            data-toggle="modal" 
                            data-target="#nomorAkad">
                                Ubah
                    </a>
                  </td>
                  @else
                  Belum ada
                  </td>
                  <td>
                    <a href="#" class="badge badge-primary text-white"
                            data-toggle="modal" 
                            data-target="#nomorAkad">
                                Input
                    </a>
                  </td>
                  @endif
                  {{-- @endif --}}
                </td>
              </tr>
              <tr>
                <th scope="row">Tanggal Akad</th>
                <td>
                  @if($dataPembelian->tanggalAkad != null)
                  {{$dataPembelian->tanggalAkad}}
                </td>
                  <td>
                    <a href="#" class="badge badge-warning text-dark"
                            data-toggle="modal" 
                            data-target="#tanggalAkad">
                                Ubah
                    </a>
                  </td>
                  @else
                  Belum ada
                  </td>
                  <td>
                    <a href="#" class="badge badge-primary text-white"
                            data-toggle="modal" 
                            data-target="#tanggalAkad">
                                Input
                    </a>
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
                  <a href="{{route('DPKavlingTambah',['id'=>$dataPembelian->id])}}" class="badge badge-primary">Lihat Pembayaran</a>
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
                  <a href="{{route('unitKavlingDetail',['id'=>$dataPembelian->id])}}" class="badge badge-primary">Lihat Pembayaran</a>
                </td>
              </tr>
            </tbody>
          </table>
        {{-- Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>. --}}
      </div>
    </div>
  </div>
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="card-header">
          <h4>Edit Pelanggan</h4>

        </div>
        <form action="{{route('pelangganUpdate',['id'=>$id->id])}}" method="POST" enctype="multipart/form-data" onchange="hitung()">
          @method('patch')
          {{-- Part 1 --}}
          <form class="card-body" id="pertama">
            @csrf
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Lengkap</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{$dataPembelian->pelanggan->nama}}">
                @error('nama')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
              <div class="col-sm-12 col-md-7">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$dataPembelian->pelanggan->email}}">
                @error('email')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tempat & Tanggal Lahir</label>
              <div class="col-sm-6 col-md-3">
                <input type="text" class="form-control @error('tempatLahir') is-invalid @enderror" name="tempatLahir" value="{{$dataPembelian->pelanggan->tempatLahir}}">
                @error('tempatLahir')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
              <div class="col-sm-6 col-md-4">
                <input type="date" class="form-control @error('tanggalLahir') is-invalid @enderror" name="tanggalLahir" value="{{$dataPembelian->pelanggan->tanggalLahir}}">
                @error('tanggalLahir')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
              <div class="col-sm-12 col-md-7">
                <input type="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{$dataPembelian->pelanggan->alamat}}">
                @error('alamat')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Kelamin</label>
              <div class="col-sm-12 col-md-7">
                <label class="selectgroup-item">
                  <input type="radio" name="jenisKelamin" value="Laki-laki" class="selectgroup-input" @if($dataPembelian->pelanggan->jenisKelamin=='Laki-laki')checked @endif>
                  <span class="selectgroup-button">Laki-laki</span>
                </label>
                <label class="selectgroup-item">
                  <input type="radio" name="jenisKelamin" value="Perempuan" class="selectgroup-input"@if($dataPembelian->pelanggan->jenisKelamin=='Perempuan')checked @endif>
                  <span class="selectgroup-button">Perempuan</span>
                </label>
                @error('jenisKelamin')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Pernikahan</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('statusPernikahan') is-invalid @enderror" name="statusPernikahan" value="{{$dataPembelian->pelanggan->statusPernikahan}}">
                @error('statusPernikahan')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pekerjaan</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" name="pekerjaan" value="{{$dataPembelian->pelanggan->pekerjaan}}">
                @error('pekerjaan')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor Telepon</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class=" input-phone form-control @error('nomorTelepon') is-invalid @enderror" name="nomorTelepon" value="{{$dataPembelian->pelanggan->nomorTelepon}}">
                @error('nomorTelepon')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
              <div class="col-sm-12 col-md-7">
                <button class="btn btn-warning" type="submit">Edit Pelanggan</button>
              </div>
            </div>
          </form>
          {{-- </div> --}}
          @if($id->kavling != null)
          <div class="card-header ">
            <h4>Edit Data Unit</h4>   
              <button type="button" class="btn btn-sm btn-danger text-white ml-3" 
              data-toggle="modal" 
              data-target="#exampleModalCenter" 
              data-id="{{$id->id}}" 
              data-nama="{{$id->nama}}">
              <i class="fa fa-trash" aria-hidden="true" ></i> Batal Akad</button>       
            {{-- <a href="{{route('batalAkad',['id'=>$id->id])}}" class="btn btn-danger ml-3"> Batal Akad</a> --}}
          </div>
                    <!-- Modal Hapus-->
          <div class="modal fade exampleModalCenter" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Hapus Pelanggan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="" method="post" id="formHapus">
                    @method('patch')
                    @csrf
                    <p class="modal-text"></p>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Batal Akad!</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <script type="text/javascript">
            $(document).ready(function(){
              $('#exampleModalCenter').on('show.bs.modal', function (event) {
              var button = $(event.relatedTarget) // Button that triggered the modal
              var id = button.data('id') // Extract info from data-* attributes
              var nama = button.data('nama') 
              var modal = $(this)
              modal.find('.modal-text').text('Yakin ingin Membatalkan akad ' + nama+' ?')
              document.getElementById('formHapus').action='/batalAkad/'+id;
              })
            });
          </script>
          <div class="card-body" id="kedua">
            <form action="{{route('unitPelangganUpdate',['id'=>$id->id])}}" method="POST" enctype="multipart/form-data" onchange="hitung()">
              @method('patch')
              @csrf
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kavling</label>
              <div class="col-sm-12 col-md-7">
                {{-- <input type="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{$dataPembelian->kavling->blok}}"> --}}
                <select class="cari form-control @error('kavling_id') is-invalid @enderror" style="width:300px;height:calc(1.5em + .75rem + 2px);" name="kavling_id">
                  {{-- <option selected="selected">
                    {{$dataPembelian->kavling->blok}}
                  </option> --}}
                </select>
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                <script type="text/javascript">
                  $('.cari').select2({
                                      placeholder: 'Ganti Kavling...',
                                      ajax: {
                                      url: '/cariKavling',
                                      dataType: 'json',
                                      delay: 250,
                                      processResults: function (data) {
                                          return {
                                          results:  $.map(data, function (item) {
                                              return {
                                              text: item.blok, /* memasukkan text di option => <option>namaSurah</option> */
                                              id: item.id /* memasukkan value di option => <option value=id> */
                                              }
                                          })
                                          };
                                      },
                                      cache: true
                                      }
                                  });
                  </script>
                @error('kavling_id')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Termasuk Pembelian</label>
              <div class="col-sm-12 col-md-7">
                <label class="selectgroup-item">
                  <input type="radio" name="includePembelian" value="" class="selectgroup-input" @if($dataPembelian->rumah_id==null && $dataPembelian->kios_id == null) checked @endif id="notInclude">
                  <span class="selectgroup-button">Tidak Ada</span>
                </label>
                <label class="selectgroup-item">
                  <input type="radio" name="includePembelian" value="Rumah" class="selectgroup-input" id="rumah" @if($dataPembelian->rumah_id != null) checked @endif>
                  <span class="selectgroup-button">Rumah</span>
                </label>
                <label class="selectgroup-item">
                  <input type="radio" name="includePembelian" value="Kios" class="selectgroup-input" id="kios" @if($dataPembelian->kios_id != null) checked @endif>
                  <span class="selectgroup-button">Kios</span>
                </label>
                @error('includePembelian')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div id="luasBangunan" @if($dataPembelian->rumah_id!=null || $dataPembelian->kios_id != null) style="display:block" @else  style="display: none" @endif>
              <div class="form-group row mb-4" >
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Luas Bangunan</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control @error('luasBangunan') is-invalid @enderror" name="luasBangunan" value="{{luasBangunanPelanggan($dataPembelian->pelanggan_id)}}" placeholder="kosongkan jika data belum ada">
                  @error('luasBangunan')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor Akad</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('nomorAkad') is-invalid @enderror" name="nomorAkad" value="{{$dataPembelian->nomorAkad}}">
                
                @error('nomorAkad')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Akad</label>
              <div class="col-sm-12 col-md-7">
                <input type="date" class="form-control @error('tanggalAkad') is-invalid @enderror" name="tanggalAkad" value="{{$dataPembelian->tanggalAkad}}" >
                <div class="feedback mt-2">*kosongkan jika data belum ada</div>
                @error('tanggalAkad')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga</label>
              <div class="input-group col-sm-12 col-md-7">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    Rp
                  </div>
                </div>
                <input type="text" class="form-control harga" id="harga" name="harga" value="{{$dataPembelian->harga}}">
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskon</label>
              <div class="input-group col-sm-12 col-md-7">
                <input type="text" class="persenDiskon form-control @error('diskon') is-invalid @enderror" name="diskon" value="{{$persenDiskon}}" min="0" max="100" id="diskon">
                @error('diskon')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    %
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Diskon</label>
              <div class="input-group col-sm-12 col-md-7">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    Rp
                  </div>
                </div>
                <input type="text" readonly class="totalDiskon form-control @error('totalDiskon') is-invalid @enderror" name="totalDiskon" value="{{$dataPembelian->diskon}}" min="0" max="100" placeholder="diisi tanpa tanda %" id="totalDiskon">
                @error('totalDiskon')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">DP</label>
              <div class="input-group col-sm-12 col-md-7">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    Rp
                  </div>
                </div>
                <input type="text" class="dp form-control @error('dp') is-invalid @enderror" name="dp"  id="dp" value="{{$dataPembelian->dp}}">
                @error('dp')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
                
                <div class="input-group-prepend">
                  <div class="input-group-text " style="border: none">
                    <label class="selectgroup-item " >
                      <input type="radio" name="statusDp" value="Credit" class="selectgroup-input" @if($dataPembelian->statusDp == 'Credit') checked @endif>
                      <span class="selectgroup-button">Credit</span>
                    </label>
                    <label class="selectgroup-item ">
                      <input type="radio" name="statusDp" value="Cash" class="selectgroup-input" @if($dataPembelian->statusDp == 'Cash') checked @endif>
                      <span class="selectgroup-button">Cash</span>
                    </label>
                    @error('statusDp')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                </div>
                  {{-- <div class="col-sm-12 col-md-4 input-group-text "> --}}
                    
                {{-- </div> --}}
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sisa Kewajiban</label>
              <div class="input-group col-sm-12 col-md-7">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    Rp
                  </div>
                </div>
                <input type="text" readonly class="sisaKewajiban form-control" name="sisaKewajiban" value="{{$dataPembelian->sisaKewajiban}}" id="sisaKewajiban">
                
                <div class="input-group-prepend">
                  <div class="input-group-text " style="border: none">
                    <label class="selectgroup-item " >
                      <input type="radio" name="statusCicilan" value="Credit" class="selectgroup-input" checked="" id="statusCicilanCredit">
                      <span class="selectgroup-button">Credit</span>
                    </label>
                    <label class="selectgroup-item ">
                      <input type="radio" name="statusCicilan" value="Cash" class="selectgroup-input" id="statusCicilanCash" >
                      <span class="selectgroup-button">Cash</span>
                    </label>
                    @error('statusCicilan')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <div id="tenor" class="">
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tenor</label>
                <div class="input-group col-sm-12 col-md-7">
                  <input type="number" class=" form-control @error('tenor') is-invalid @enderror" name="tenor" value="{{$dataPembelian->tenor}}">
                  @error('tenor')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      bulan
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
              <div class="col-sm-12 col-md-7">
                <button class="btn btn-warning" type="submit">Edit Data Unit </button>
              </div>
            </div>
            
          </div>
        </form>

        @endif
    </div>
  </div>
</div>

{{-- tampilan cetak pelanggan --}}
<div class="cetak d-none " id="cetakPelanggan"> 
  <div class="card">
    <div class="profil-widget">
      <div class="profile-widget-header row justify-content-center mt-2 ">
        <img alt="image" src="../assets/img/avatar/avatar-1.png" class=" rounded-circle profile-widget-picture" width="150px">
      </div>
      <div class="row justify-content-center mt-2">
        <h4>{{$id->nama}}</h4>
      </div>

    </div>
    <div class="card-header">
      <h4>Data Pelanggan</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover table-sm">
        <tbody>
          <tr>
            <th style="width: 40%" scope="row">Nama Lengkap</th>
            <td>{{$id->nama}}</td>
          </tr>
          <tr>
            <th scope="row">Tempat & Tanggal Lahir</th>
            <td>{{$id->tempatLahir}}, {{formatTanggal($id->tanggalLahir)}}</td>
          </tr>
          <tr>
            <th scope="row">Jenis Kelamin</th>
            <td>{{$id->jenisKelamin}}</td>
          </tr>
          <tr>
            <th scope="row">Alamat</th>
            <td>{{$id->alamat}}</td>
          </tr>
          <tr>
            <th scope="row">Status Pernikahan</th>
            <td>{{$id->statusPernikahan}}</td>
          </tr>
          <tr>
            <th scope="row">Pekerjaan</th>
            <td>{{$id->pekerjaan}}</td>
          </tr>
          <tr>
            <th scope="row">Nomor Telepon</th>
            <td>{{$id->nomorTelepon}}</td>
          </tr>
          <tr>
            <th scope="row">Email</th>
            <td>{{$id->email}}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="card-header">
      <h4>Data Unit Pelanggan</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover table-sm">
        <tbody>
          <tr>
            <th scope="row" style="width: 40%">Objek</th>
            <td>{{jenisKepemilikan($id->id)}} (@if($dataKavling == null)Akad Dibatalkan @else{{$dataKavling->blok}}@endif)</td>
            
          </tr>
          <tr>
            <th scope="row">Nomor Akad</th>
            <td>
              {{-- @if($dataKavling =! null) Akad Dibatalkan @else  --}}
              @if($dataPembelian->nomorAkad != null)
              {{$dataPembelian->nomorAkad}}
              @else
              Belum ada
              @endif
            </td>
          </tr>
          <tr>
            <th scope="row">Tanggal Akad</th>
            <td>
              @if($dataPembelian->tanggalAkad != null)
              {{formatTanggal($dataPembelian->tanggalAkad)}}
            </td>
              @else
              Belum ada
              </td>
              @endif
              {{-- @endif --}}
          </tr>
          <tr>
            <th scope="row">Harga</th>
            <td>Rp. {{number_format($dataPembelian->harga)}}</td>
          </tr>
          <tr>
            <th scope="row">Diskon</th>
            @if($dataPembelian->diskon != 0)
            <td>Rp. {{number_format($dataPembelian->diskon)}} ({{$persenDiskon}}%)</td>
            @else
            <td>Rp. {{number_format($dataPembelian->diskon)}}%</td>
            @endif
          </tr>
          <tr>
            <th scope="row">DP</th>
            <td>Rp. {{number_format($dataPembelian->dp)}}</td>
          </tr>
          <tr>
            <th scope="row">Tenor</th>
            <td>{{$dataPembelian->tenor}} bulan</td>
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
              /Lunas
              @endif 
            </td>
          </tr>
          <tr>
            <th>Status Cicilan</th>
            <td>{{$dataPembelian->statusCicilan}}</td>
            <td></td>
          </tr>
          <tr>
            <th>Sisa Cicilan</th>
            <td>Rp {{number_format($dataPembelian->sisaCicilan)}}
              @if($dataPembelian->sisaCicilan==0)
              /
              <span class="badge badge-info"><i class="fas fa-check"></i> Lunas</span>
              @endif </td>
          </tr>
        </tbody>

      </table>
    </div>
    <div class="card-header">
      <h4>Data Cicilan DP</h4>
    </div>
    <div class="card-body">
      <table class="table table-sm table-hover">
        <thead>
          <tr>
            <th scope="col">Cicilan Ke</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Sisa DP</th>
            <th scope="col">Nomor Faktur</th>
          </tr>
        </thead>
        <tbody>
          @foreach($dataDp as $cicilanDp)
          <tr>
            <th scope="row">{{$cicilanDp->urut}}</th>
            <td>{{formatTanggal($cicilanDp->tanggal)}}</td>
            <td>Rp.{{number_format($cicilanDp->jumlah)}}</td>
            <td>Rp.{{number_format($cicilanDp->sisaDp)}}</td>
            <td>
              @if(jenisKepemilikan($id->id)=='Kavling')
              DK
              @else
              DB
              @endif
              {{romawi(Carbon\Carbon::parse($cicilanDp->tanggal)->isoFormat('MM'))}}/{{$cicilanDp->ke}}
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot class="bg-light  border-top">
          <tr >
            <th style="text-align: right" colspan="2">Total Terbayar</th>
            <th>Rp.{{number_format($dataDp->sum('jumlah'))}}</th>
            <td></td>
            <td></td>
            <td></td>
          </tr>
  
        </tfoot>
      </table>
    </div>
    <div class="card-header">
      <h4>Data Cicilan</h4>
    </div>
    <div class="card-body">
      <table class="table table-sm table-hover"> 
        <thead>
          <tr>
            <th scope="col">Cicilan Ke</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Sisa Hutang</th>
            <th scope="col">Nomor Faktur</th>
          </tr>
        </thead>
        <tbody>
          @foreach($dataCicilan as $cicilanUnit)
          <tr>
            <th scope="row">{{$cicilanUnit->urut}}</th>
            <td>{{formatTanggal($cicilanUnit->tanggal)}}</td>
            <td>Rp.{{number_format($cicilanUnit->jumlah)}}</td>
            <td>Rp.{{number_format($cicilanUnit->sisaKewajiban)}}</td>
            <td>
              @if(jenisKepemilikan($id->id)=='Kavling')
              CK
              @else
              CB
              @endif
              {{romawi(Carbon\Carbon::parse($cicilanUnit->tanggal)->isoFormat('MM'))}}/{{$cicilanUnit->ke}}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot class="bg-light">
          <tr >
            <th style="text-align: right" colspan="2">Total Terbayar</th>
            <th>Rp.{{number_format($dataCicilan->sum('jumlah'))}}</th>
            <td></td>
            <td></td>
            <td></td>
          </tr>
  
        </tfoot>
      </table>
    </div>
  </div>
</div>
<script>
  function cetak(el){
    var restorePage = document.body.innerHTML;
    var printContent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printContent;
    var inputBaru = document.querySelector('.cetak');
    // inputBaru.className ='cetak';
    window.print();
    document.body.innerHTML = restorePage;
  }
</script>

  <!-- Modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="nomorAkad" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Input Nomor Akad</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{route('simpanNomorAkad',['id'=>$dataPembelian->id])}}" class="" enctype="multipart/form-data">
            @csrf
            <div class="row mb-1"> 
              <div class="col-sm-4">
                <label for="nomorAkad" class=" col-form-label">Nomor Akad</label>
              </div>
              <div class="col-sm-8 ">
                  <input type="text"
                      class="form-control  @error('nomorAkad') is-invalid @enderror"
                      id="nomorAkad" name="nomorAkad" value="{{$dataPembelian->nomorAkad}}">
                  @error('nomorAkad')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-primary" value="Simpan">
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="tanggalAkad" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pilih Tanggal Akad</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{route('simpanTanggalAkad',['id'=>$dataPembelian->id])}}" class="" enctype="multipart/form-data">
            @csrf
            <div class="row mb-1"> 
              <div class="col-sm-4">
                <label for="tanggalAkad" class=" col-form-label">Tanggal Akad</label>
              </div>
              <div class="col-sm-8 ">
                  <input type="date"
                      class="form-control  @error('tanggalAkad') is-invalid @enderror"
                      id="tanggalAkad" name="tanggalAkad" value="{{$dataPembelian->tanggalAkad}}">
                  @error('tanggalAkad')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-primary" value="Simpan">
          </div>
        </form>
      </div>
    </div>
  </div>
  @endsection

@section('script')
<script src="{{ mix("js/jquery.min.js") }}"></script>
<script type="text/javascript">
  function hitung(){
  var harga = parseInt((document.getElementById('harga').value).replace(/,/g, ''));
  var diskon = parseInt((document.getElementById('diskon').value).replace(/,/g, ''));
  var dp = parseInt((document.getElementById('dp').value).replace(/,/g, ''));

  var totalDiskon = harga*diskon/100;
  if(isNaN(totalDiskon)){
    document.getElementById("totalDiskon").value =0;
    var kewajiban = harga-dp;
    }else{
    document.getElementById("totalDiskon").value = totalDiskon; 
    var cleave = new Cleave('.totalDiskon', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
    });
    var kewajiban = harga-dp-totalDiskon;
    }

    if(isNaN(kewajiban)){
      document.getElementById("sisaKewajiban").value =0;
    }else{
    document.getElementById("sisaKewajiban").value = kewajiban; 
    var cleave = new Cleave('.sisaKewajiban', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
    });
    }

    if(document.getElementById('statusCicilanCredit').checked){
      document.getElementById('tenor').style.display = 'block';
    }else{
      document.getElementById('tenor').style.display = 'none';
    }
        if(document.getElementById('rumah').checked || document.getElementById('kios').checked){
      document.getElementById('luasBangunan').style.display = 'block';
    }else{
      document.getElementById('luasBangunan').style.display = 'none';
    }
    
    
  }

</script>
{{-- Install package --}}
{{-- npm install --save cleave.js --}}
{{-- dokumentasi https://nosir.github.io/cleave.js/ --}}
{{-- insert script dengan laravel Mix helper -- lokasi file webpack.mix.js -- run npm run dev setelah import--}}
<script src="{{ mix("js/cleave.min.js") }}"></script>
<script src="{{ mix("js/addons/cleave-phone.id.js") }}"></script>
<script>
  var cleave = new Cleave('.input-phone', {
    phone: true,
    phoneRegionCode: 'ID'
  });
  var cleave = new Cleave('.harga', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
  var cleave = new Cleave('.dp', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
  var cleave = new Cleave('.sisaKewajiban', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
  var cleave = new Cleave('.totalDiskon', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
  


</script>
@endsection