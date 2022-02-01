<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Inspira Property</title>

  @yield('head')
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ mix("css/app.css") }}">
  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/chocolat.css')}}" type="text/css" media="screen" >
  <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/daterangepicker.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">

</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar " >
        <ul class=" mr-3 navbarMarker">
          <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg navbarMarker"><i class="fas fa-bars mt-3"></i></a></li>
          {{-- <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li> --}}
        </ul>
        @if(auth()->user()->role=="pelanggan")
        <h3 class="text-white align-center mt-2">{{auth()->user()->proyek->nama}}</h3>
        @endif
        @if(auth()->user()->role=="admin" || auth()->user()->role=="projectmanager" || auth()->user()->role=="marketing" || auth()->user()->role=="adminGudang"|| auth()->user()->role=='kasir')
        <form action="{{route('cariPelangganHome')}}" method="post" enctype="multipart/form-data" class="form-inline mr-auto d-none d-md-block">
        @csrf
          <div class="row ">
          <div class="input-group col-9">
            <select class="cariPelanggan js-example-responsive" name="id"></select>
              <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
              <script type="text/javascript">
                $('.cariPelanggan').select2({
                                    placeholder: 'Cari Pelanggan...',
                                    ajax: {
                                    url: '/cariPelangganDaftar',
                                    dataType: 'json',
                                    delay: 250,
                                    processResults: function (data) {
                                        return {
                                        results:  $.map(data, function (item) {
                                          // console.log(data);
                                            return {
                                            text: item.nama +" "+item.kavling['blok'], /* memasukkan text di option => <option>namaSurah</option> */
                                            id: item.id /* memasukkan value di option => <option value=id> */
                                            }
                                        })
                                        };
                                    },
                                    cache: true
                                    }
                                });
                </script>
          </div>
          <div class="input-group-prepend col-2">
            <div class="input-group-text">
              <i class="fas fa-search"></i><input type="submit" class="submitCari" value="Cari">
            </div>
          </div>
        </div>
        </form>
        @endif
        <ul class="navbar-nav navbar-right kanan">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user" aria-expanded="false">
            <img alt="image" 
            @if (detailUser(auth()->user()->id)->poto != null)
            src="{{Storage::url(detailUser(auth()->user()->id)->poto)}}"
            @else
            src="{{asset('assets/img/avatar/avatar-1.png')}}"   
            @endif
            class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Assalamualaikum, {{cekNamaUser()}}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title"> {{auth()->user()->role}}</div>
              @if(auth()->user()->role=="pelanggan")
              <a href="{{route('dataDiri')}}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profil
              </a>
              @endif
              {{-- <a href="features-activities.html" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Activities
              </a> --}}
              <a href="{{route('pengaturan')}}" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Pengaturan
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}"
                                      onclick="event.preventDefault();
                                      document.getElementById('logout-form2').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
                                      @csrf
                                  </form>
                {{-- <i class="fas fa-sign-out-alt"></i> Logout --}}
              {{-- </a> --}}
            </div>
          </li>
         
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{url('/')}}">
              <img src="{{asset('assets/img/logo-color.png')}}" alt="" width="200px" style="padding-top: 3em;">
            </a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">Menu</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li class="@yield('menuDashboard')"><a class="nav-link" href="{{route('home')}}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
          
          @if(auth()->user()->role=="projectmanager")
          <li class="menu-header">Menu Proyek</li>
          <li class="@yield('menuProyek')"><a class="nav-link" href="{{route('proyek')}}"><i class="fas fa-archway"></i> <span>Proyek</span></a></li>
          <li class="nav-item dropdown @yield('menuDataProyek')">
            <a href="" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-home"></i> <span>Data Proyek</span></a>
            <ul class="dropdown-menu">
              <li class="@yield('menuKavling')"><a class="nav-link" href="{{route('kavling')}}">Unit</a></li>
              <li class="@yield('menuRAB')"><a class="nav-link" href="{{route('RAB')}}">RAB</a></li>
            </ul>
          </li>
          <li class="menu-header">Menu Project Manager</li>
          <li class=" @yield('menuUser')"> <a class="nav-link" href="{{route('kelolaUser')}}"> <i class="fas fa-user-friends    "></i> <span> Kelola User</span></a></li>
          <li class=" @yield('menuDaftarPengadaan')"><a class="nav-link" href="{{route('pengadaan')}}"><i class="fas fa-box-open    "></i> <span> Pengadaan Barang</span></a></li>

          @endif

          @if(auth()->user()->role=="admin")
          <li class="menu-header">Menu Proyek</li>
          <li class="nav-item dropdown @yield('menuDataProyek')">
            <a href="" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-home"></i> <span>Data Proyek</span></a>
            <ul class="dropdown-menu">
              <li class="@yield('menuKavling')"><a class="nav-link" href="{{route('kavling')}}">Unit</a></li>
              <li class="@yield('menuRAB')"><a class="nav-link" href="{{route('RAB')}}">RAB</a></li>
            </ul>
          </li>
          @endif
          @if(auth()->user()->role=="projectmanager" || auth()->user()->role=="admin")
          <li class="menu-header">Menu Pelanggan</li>
          <li class="nav-item dropdown @yield('menuPelanggan')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-clipboard-check"></i> <span>Pelanggan</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menupelangganIndex')"><a class="nav-link" href="{{route('pelangganIndex')}}">Aktif</a></li>
              <li class=" @yield('menupelangganNonAktif')"><a class="nav-link" href="{{route('pelangganNonAktif')}}">Tidak Aktif</a></li>
              <li class=" @yield('menupelangganTerhapus')"><a class="nav-link" href="{{route('pelangganTerhapus')}}">Terhapus</a></li>
            </ul>
          </li>
          <li class=" @yield('menuCicilanDP')"><a class="nav-link" href="{{route('DPKavling')}}"><i class="fas fa-coins"></i> <span> Cicilan DP</span></a></li>
          <li class=" @yield('menuCicilanUnit')"><a class="nav-link" href="{{route('cicilanKavling')}}"><i class="fas fa-money-bill-wave"></i> <span> Cicilan Unit</span></a></li>
          <li class="menu-header">Menu Keuangan</li>
          <li class="nav-item dropdown @yield('menuTransaksi')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-handshake"></i> <span>Transaksi</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuTransaksiMasuk')"><a href="{{route('transaksiMasuk')}}">Masuk</a></li>
              <li class=" @yield('menuTransaksiKeluar')"><a href="{{route('transaksiKeluar')}}">Keluar</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown @yield('menuPengadaan')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-box-open    "></i> <span>Pengadaan</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuDaftarPengadaan')"><a href="{{route('pengadaan')}}">Daftar Pengadaan</a></li>
              <li class=" @yield('menuDaftarBarang')"><a href="{{route('barang')}}">Daftar Barang</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown @yield('menuEstimasi')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-box-open    "></i> <span>Estimasi Pemasukan</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuEstimasiDp')"><a href="{{route('estimasiDp')}}">DP</a></li>
              <li class=" @yield('menuEstimasiCicilan')"><a href="{{route('estimasiCicilan')}}">Cicilan</a></li>
              <li class=" @yield('menuEstimasiTunggakan')"><a href="{{route('estimasiTunggakan')}}">Tunggakan</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown @yield('menuKas')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-book"></i> <span>KAS</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuKasBesar')"><a href="{{route('cashFlow')}}">Kas Besar</a></li>
              <li class=" @yield('menuKasPendaftaran')"><a class="nav-link" href="{{route('kasPendaftaranMasuk')}}">Pendaftaran</a></li>
              <li class=" @yield('menuKasKecil')"><a class="nav-link" href="{{route('pettyCash')}}">Kas Kecil</a></li>
              <li class=" @yield('menuKasKecilLapangan')"><a class="nav-link" href="{{route('kasKecilLapangan')}}">Kas Kecil Lapangan</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown @yield('menuGudang')">
            <a href="" class="nav-link has-dropdown"> <i class="fas fa-warehouse    "></i> <span>Gudang</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuGudangSisa')"><a href="{{route('gudang')}}">Stok Sisa</a></li>
              <li class=" @yield('menuGudangHabis')"><a href="{{route('gudangHabis')}}">Stok Habis</a></li>
            </ul>
          </li>
        <li class=" @yield('menuRekening')"><a class="nav-link" href="{{route('rekening')}}"> <i class="fas fa-dollar-sign    "></i> <span> Rekening</span></a></li>
        <li class="nav-item dropdown @yield('menuLaporan')">
        <a href="" class="nav-link has-dropdown"><i class="fas fa-clipboard-check"></i> <span>Laporan</span></a>
        <ul class="dropdown-menu">
          <li class=" @yield('menuLaporanBulanan')"><a class="nav-link" href="{{route('laporanBulanan')}}">Bulanan</a></li>
          <li class=" @yield('menuLaporanTahunan')"><a class="nav-link" href="{{route('laporanTahunan')}}">Tahunan</a></li>
        </ul>
        </li>
          @endif
          
          @if(auth()->user()->role=="adminGudang")
          <li class="menu-header">Menu Proyek</li>
          <li class="nav-item dropdown @yield('menuDataProyek')">
            <a href="" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-home"></i> <span>Data Proyek</span></a>
            <ul class="dropdown-menu">
              <li class="@yield('menuKavling')"><a class="nav-link" href="{{route('kavling')}}">Unit</a></li>
              <li class="@yield('menuRABGudang')"><a class="nav-link" href="{{route('RABGudang')}}">RAB</a></li>
            </ul>
          </li>
          <li class="menu-header">Menu Pelanggan</li>
          <li class="nav-item dropdown @yield('menuPelanggan')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-clipboard-check"></i> <span>Pelanggan</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menupelangganIndex')"><a class="nav-link" href="{{route('pelangganIndex')}}">Aktif</a></li>
              <li class=" @yield('menupelangganNonAktif')"><a class="nav-link" href="{{route('pelangganNonAktif')}}">Tidak Aktif</a></li>
              <li class=" @yield('menupelangganTerhapus')"><a class="nav-link" href="{{route('pelangganTerhapus')}}">Terhapus</a></li>
            </ul>
          </li>
          <li class=" @yield('menuCicilanDP')"><a class="nav-link" href="{{route('DPKavling')}}"><i class="fas fa-coins"></i> <span> Cicilan DP</span></a></li>
          <li class=" @yield('menuCicilanUnit')"><a class="nav-link" href="{{route('cicilanKavling')}}"><i class="fas fa-money-bill-wave"></i> <span> Cicilan Unit</span></a></li>
          <li class="menu-header">Menu Keuangan</li>
          <li class="nav-item dropdown @yield('menuTransaksi')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-handshake"></i> <span>Transaksi</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuTransaksiKeluar')"><a href="{{route('transaksiKeluar')}}">Keluar</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown @yield('menuPengadaan')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-box-open    "></i> <span>Pengadaan</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuDaftarPengadaan')"><a href="{{route('pengadaan')}}">Daftar Pengadaan</a></li>
              <li class=" @yield('menuDaftarBarang')"><a href="{{route('barang')}}">Daftar Barang</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown @yield('menuEstimasi')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-box-open    "></i> <span>Estimasi Pemasukan</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuEstimasiDp')"><a href="{{route('estimasiDp')}}">DP</a></li>
              <li class=" @yield('menuEstimasiCicilan')"><a href="{{route('estimasiCicilan')}}">Cicilan</a></li>
              <li class=" @yield('menuEstimasiTunggakan')"><a href="{{route('estimasiTunggakan')}}">Tunggakan</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown @yield('menuGudang')">
            <a href="" class="nav-link has-dropdown"> <i class="fas fa-warehouse    "></i> <span>Gudang</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuGudangSisa')"><a href="{{route('gudang')}}">Stok Sisa</a></li>
              <li class=" @yield('menuGudangHabis')"><a href="{{route('gudangHabis')}}">Stok Habis</a></li>
            </ul>
          </li>
          <li class=" @yield('menuRekening')"><a class="nav-link" href="{{route('rekening')}}"> <i class="fas fa-dollar-sign    "></i> <span> Rekening</span></a></li>
          <li class="nav-item dropdown @yield('menuLaporan')">
          <a href="" class="nav-link has-dropdown"><i class="fas fa-clipboard-check"></i> <span>Laporan</span></a>
          <ul class="dropdown-menu">
            <li class=" @yield('menuLaporanBulanan')"><a class="nav-link" href="{{route('laporanBulanan')}}">Bulanan</a></li>
            <li class=" @yield('menuLaporanTahunan')"><a class="nav-link" href="{{route('laporanTahunan')}}">Tahunan</a></li>
          </ul>
          </li>
          @endif

          @if(auth()->user()->role=="marketing")
          <li class="menu-header">Menu Proyek</li>
          <li class="nav-item dropdown @yield('menuDataProyek')">
            <a href="" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-home"></i> <span>Data Proyek</span></a>
            <ul class="dropdown-menu">
              <li class="@yield('menuKavling')"><a class="nav-link" href="{{route('kavling')}}">Unit</a></li>
              <li class="@yield('menuPengembalianBatalAkad')"><a class="nav-link" href="{{route('PengembalianBatalAkad')}}">Pengembalian Batal Akad</a></li>
            </ul>
          </li>
          <li class="menu-header">Menu Pelanggan</li>
          <li class="nav-item dropdown @yield('menuPelanggan')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-clipboard-check"></i> <span>Pelanggan</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menupelangganIndex')"><a class="nav-link" href="{{route('pelangganIndex')}}">Aktif</a></li>
              <li class=" @yield('menupelangganNonAktif')"><a class="nav-link" href="{{route('pelangganNonAktif')}}">Tidak Aktif</a></li>
              <li class=" @yield('menupelangganTerhapus')"><a class="nav-link" href="{{route('pelangganTerhapus')}}">Terhapus</a></li>
            </ul>
          </li>
          <li class=" @yield('menuCicilanDP')"><a class="nav-link" href="{{route('DPKavling')}}"><i class="fas fa-coins"></i> <span> Cicilan DP</span></a></li>
          <li class=" @yield('menuCicilanUnit')"><a class="nav-link" href="{{route('cicilanKavling')}}"><i class="fas fa-money-bill-wave"></i> <span> Cicilan Unit</span></a></li>
          <li class="menu-header">Menu Keuangan</li>
          <li class="nav-item dropdown @yield('menuTransaksi')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-handshake"></i> <span>Transaksi</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuTransaksiMasuk')"><a href="{{route('transaksiMasuk')}}">Masuk</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown @yield('menuPengadaan')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-box-open    "></i> <span>Pengadaan</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuDaftarPengadaan')"><a href="{{route('pengadaan')}}">Daftar Pengadaan</a></li>
              <li class=" @yield('menuDaftarBarang')"><a href="{{route('barang')}}">Daftar Barang</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown @yield('menuEstimasi')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-box-open    "></i> <span>Estimasi Pemasukan</span></a>
            <ul class="dropdown-menu">
              {{-- <li class=" @yield('menuAkun')"><a href="{{route('akun')}}">Akun</a></li> --}}
              <li class=" @yield('menuEstimasiDp')"><a href="{{route('estimasiDp')}}">DP</a></li>
              <li class=" @yield('menuEstimasiCicilan')"><a href="{{route('estimasiCicilan')}}">Cicilan</a></li>
              <li class=" @yield('menuEstimasiTunggakan')"><a href="{{route('estimasiTunggakan')}}">Tunggakan</a></li>
            </ul>
          </li>
          <li class=" @yield('menuRekening')"><a class="nav-link" href="{{route('rekening')}}"> <i class="fas fa-dollar-sign    "></i> <span> Rekening</span></a></li>
          <li class="nav-item dropdown @yield('menuLaporan')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-clipboard-check"></i> <span>Laporan</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuLaporanBulanan')"><a class="nav-link" href="{{route('laporanBulanan')}}">Bulanan</a></li>
              <li class=" @yield('menuLaporanTahunan')"><a class="nav-link" href="{{route('laporanTahunan')}}">Tahunan</a></li>
            </ul>
          </li>
          @endif

          @if(auth()->user()->role=="pelanggan")
              <li class="menu-header">Menu Pelanggan</li>
              <li class=" @yield('menuDataDiri')"><a class="nav-link" href="{{route('dataDiri')}}"><i class="fas fa-book-open"></i> <span> Data Diri</span></a></li>
              <li class=" @yield('menuPembelianPelanggan')"><a class="nav-link" href="{{route('pembelianPelanggan')}}"><i class="fas fa-handshake    "></i><span> Pembelian</span></a></li>
              <li class=" @yield('menuDPPelanggan')"><a class="nav-link" href="{{route('DPPelanggan')}}"><i class="fas fa-coins    "></i> <span> Cicilan DP</span></a></li>
              <li class=" @yield('menuUnitPelanggan')"><a class="nav-link" href="{{route('unitPelanggan')}}"><i class="fas fa-money-bill    "></i> <span> Cicilan Unit</span></a></li>
          @endif

          @if(auth()->user()->role=='adminWeb')
              <li class="menu-header">Menu Website</li>
              <li class=" @yield('menuPopUp')"><a class="nav-link" href="{{route('popup')}}"> <i class="fas fa-file-image    "></i> <span> Pop Up</span></a></li>
              <li class=" @yield('menuBanner')"><a class="nav-link" href="{{route('banner')}}"> <i class="fas fa-file-image    "></i> <span> Banner </span></a></li>
              <li class=" @yield('menuSlider')"><a class="nav-link" href="{{route('slider')}}"> <i class="fas fa-image    "></i><span>Slider</span></a></li>
              <li class=" @yield('menuProyekWeb')"><a class="nav-link" href="{{route('proyekWeb')}}"><i class="fas fa-archway"></i> <span> Proyek</span></a></li>
              <li class=" @yield('menuKabarBerita')"><a class="nav-link" href="{{route('kabarBerita')}}"><i class="fas fa-book-open"></i> <span> Kabar Berita</span></a></li>
          @endif
          
          @if(auth()->user()->role=="gudang" )
          <li class="nav-item dropdown @yield('menuGudang')">
            <a href="" class="nav-link has-dropdown"> <i class="fas fa-warehouse    "></i> <span>Gudang</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuGudangSisa')"><a href="{{route('gudang')}}">Stok Sisa</a></li>
              <li class=" @yield('menuGudangHabis')"><a href="{{route('gudangHabis')}}">Stok Habis</a></li>
            </ul>
          </li>
          @endif

          @if(auth()->user()->role=="kasir" )
          <li class="menu-header">Menu Pelanggan</li>
          <li class="nav-item dropdown @yield('menuPelanggan')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-clipboard-check"></i> <span>Pelanggan</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menupelangganIndex')"><a class="nav-link" href="{{route('pelangganIndex')}}">Aktif</a></li>
              <li class=" @yield('menupelangganNonAktif')"><a class="nav-link" href="{{route('pelangganNonAktif')}}">Tidak Aktif</a></li>
              <li class=" @yield('menupelangganTerhapus')"><a class="nav-link" href="{{route('pelangganTerhapus')}}">Terhapus</a></li>
            </ul>
          </li>
          <li class=" @yield('menuCicilanDP')"><a class="nav-link" href="{{route('DPKavling')}}"><i class="fas fa-coins"></i> <span> Cicilan DP</span></a></li>
          <li class=" @yield('menuCicilanUnit')"><a class="nav-link" href="{{route('cicilanKavling')}}"><i class="fas fa-money-bill-wave"></i> <span> Cicilan Unit</span></a></li>
          <li class=" @yield('menuTransaksiMasuk')"><a class="nav-link" href="{{route('transaksiMasuk')}}"> <i class="fas fa-money-bill"></i> <span> Transaksi Masuk</span></a></li>
          <li class="nav-item dropdown @yield('menuKas')">
            <a href="" class="nav-link has-dropdown"><i class="fas fa-book"></i> <span>KAS</span></a>
            <ul class="dropdown-menu">
              <li class=" @yield('menuKasBesar')"><a href="{{route('cashFlow')}}">Input Kas Besar</a></li>
             </ul>
          </li>
          @endif


              <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                {{-- <a href="https://getstisla.com" class="btn btn-primary btn-lg btn-block btn-icon-split">
                </a> --}}
                <a class="btn btn-primary btn-lg btn-block btn-icon-split" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                                        {{-- {{ __('Logout') }} --}}
                                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Logout
                                      </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                      @csrf
                                  </form>
              </div>
            </aside>
          </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          {{-- Container --}}
          @yield('content')
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2021 <div class="bullet"></div>Build And Design By  <a href="https://www.instagram.com/khadijah.itsolution/"><i class="fab fa-instagram" aria-hidden="true"></i> Khadijah.itsolution</a>
        </div>
        <div class="footer-right">
          1.0.1
        </div>
      </footer>
    </div>
  </div>
  
  <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>   --}}
  @yield('script')
  <!-- General JS Scripts -->
  <script src="{{ mix("js/bootstrap.js") }}"></script>
  <script src="{{ mix("js/popper.js") }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <script src="{{asset('assets/js/stisla.js')}}"></script>
  <!-- JS Libraies -->
  <script src="{{asset('assets/js/chocolat.js')}}"></script>
  
  <!-- Template JS File -->
  <script src="{{asset('assets/js/scripts.js')}}"></script>
  <script src="{{asset('assets/js/custom.js')}}"></script>
  <script src="{{asset('assets/js/daterangepicker.js')}}"></script>

  <!-- Page Specific JS File -->

</body>

</html>
