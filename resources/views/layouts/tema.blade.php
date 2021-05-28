<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>PT Inspira Hasanah Madani</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ mix("css/app.css") }}">
  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/chocolat.css')}}" type="text/css" media="screen" >
  <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/daterangepicker.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">

  @yield('head')
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg sticky-top"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky-top" >
        <ul class=" mr-3 navbarMarker">
          <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg navbarMarker"><i class="fas fa-bars mt-3"></i></a></li>
          {{-- <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li> --}}
        </ul>
        <form action="{{route('cariPelangganHome')}}" method="post" enctype="multipart/form-data" class="form-inline mr-auto">
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
                                            return {
                                            text: item.nama, /* memasukkan text di option => <option>namaSurah</option> */
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
        <ul class="navbar-nav navbar-right">

          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{cekNamaUser()}}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title"><i class="fas fa-cog"></i>   Pengaturan</div>
              <a href="features-profile.html" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <a href="features-activities.html" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Activities
              </a>
              <a href="features-settings.html" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}"
                                      onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
            <a href="index.html"><img src="{{asset('assets/img/logo-mini.png')}}" alt=""></a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">Menu</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li class="@yield('menuDashboard')"><a class="nav-link" href="{{route('home')}}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
              <li class="menu-header">Menu Proyek</li>
              <li class="@yield('menuProyek')"><a class="nav-link" href="{{route('proyek')}}"><i class="fas fa-archway"></i> <span>Proyek</span></a></li>
              <li class="nav-item dropdown @yield('menuDataProyek')">
                <a href="" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-home"></i> <span>Data Proyek</span></a>
                <ul class="dropdown-menu">
                  <li class="@yield('menuKavling')"><a class="nav-link" href="{{route('kavling')}}">Unit</a></li>
                  <li class="@yield('menuRAB')"><a class="nav-link" href="{{route('RAB')}}">RAB</a></li>
                  
                </ul>
              </li>
              <li class="menu-header">Menu Pelanggan</li>
              <li class="@yield('menuPelanggan')"><a class="nav-link" href="{{route('pelangganIndex')}}"><i class="fas fa-user-friends"></i> <span>Pelanggan</span></a></li>
              <li class=" @yield('menuCicilanDP')"><a class="nav-link" href="{{route('DPKavling')}}"><i class="fas fa-coins"></i> <span> Cicilan DP</span></a></li>
              {{-- <li class="nav-item dropdown @yield('menuCicilanDP')">
                <a href="" class="nav-link has-dropdown"><i class="fas fa-coins"></i> <span>Cicilan DP</span></a>
                <ul class="dropdown-menu">
                  <li class=" @yield('menuCicilanDPRumah')"><a class="nav-link " href="{{route('DPRumah')}}">Rumah</a></li>
                  <li class=" @yield('menuCicilanDPKios')"><a class="nav-link " href="{{route('DPKios')}}">Kios</a></li>
                  
                </ul> --}}
              </li>
              <li class=" @yield('menuCicilanUnit')"><a class="nav-link" href="{{route('cicilanKavling')}}"><i class="fas fa-money-bill-wave"></i> <span> Cicilan Unit</span></a></li>
              {{-- <li class="nav-item dropdown @yield('menuCicilanUnit')">
                <a href="" class="nav-link has-dropdown"><i class="fas fa-money-bill-wave"></i> <span>Cicilan Unit</span></a>
                <ul class="dropdown-menu">
                  <li class=" @yield('menuCicilanUnitRumah')"><a class="nav-link" href="{{route('cicilanRumah')}}">Rumah</a></li>
                  <li class=" @yield('menuCicilanUnitKios')"><a class="nav-link" href="{{route('cicilanKios')}}">Kios</a></li>
                  
                </ul>
              </li> --}}
              
            </li>
            <li class="menu-header">Menu Keuangan</li>
            <li class=" @yield('menuAkun')"><a class="nav-link" href="{{route('akun')}}"><i class="fas fa-book-open"></i> <span> Akun</span></a></li>
              <li class="nav-item dropdown @yield('menuTransaksi')">
                <a href="" class="nav-link has-dropdown"><i class="far fa-handshake"></i> <span>Transaksi</span></a>
                <ul class="dropdown-menu">
                  {{-- <li class=" @yield('menuAkun')"><a href="{{route('akun')}}">Akun</a></li> --}}
                  <li class=" @yield('menuTransaksiMasuk')"><a href="{{route('transaksiMasuk')}}">Masuk</a></li>
                  <li class=" @yield('menuTransaksiKeluar')"><a href="{{route('transaksiKeluar')}}">Keluar</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown @yield('menuKas')">
                <a href="" class="nav-link has-dropdown"><i class="fas fa-book"></i> <span>KAS</span></a>
                <ul class="dropdown-menu">
                  <li class=" @yield('menuKasBesar')"><a href="{{route('cashFlow')}}">Kas Besar</a></li>
                  {{-- <li class=" @yield('menuKasBesar')"><a class="nav-link" href="{{route('kasBesar')}}">Besar</a></li> --}}
                  <li class=" @yield('menuKasPendaftaran')"><a class="nav-link" href="{{route('kasPendaftaranMasuk')}}">Pendaftaran</a></li>
                  <li class=" @yield('menuKasKecil')"><a class="nav-link" href="{{route('pettyCash')}}">Petty Cash</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown @yield('menuLaporan')">
                <a href="" class="nav-link has-dropdown"><i class="fas fa-clipboard-check"></i> <span>Laporan</span></a>
                <ul class="dropdown-menu">
                  <li class=" @yield('menuLaporanBulanan')"><a class="nav-link" href="{{route('laporanBulanan')}}">Bulanan</a></li>
                  <li class=" @yield('menuLaporanTahunan')"><a class="nav-link" href="{{route('laporanTahunan')}}">Tahunan</a></li>
                </ul>
              </li>
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
          Copyright &copy; 2021 <div class="bullet"></div>Build And Design By Nopi Arahman</a>
        </div>
        <div class="footer-right">
          1.0.1
        </div>
      </footer>
    </div>
  </div>
  
  @yield('script')
  <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
  <!-- General JS Scripts -->
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="{{ mix("js/popper.js") }}"></script>
  <script src="{{ mix("js/bootstrap.js") }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2/dist/Chart.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
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
