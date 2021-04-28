<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>PT Inspira Hasanah Madani</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/chocolat.css')}}" type="text/css" media="screen" >
  <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          {{-- <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result">
              <div class="search-header">
                Histories
              </div>
              <div class="search-item">
                <a href="#">How to hack NASA using CSS</a>
                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
              </div>
              <div class="search-item">
                <a href="#">Kodinger.com</a>
                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
              </div>
              <div class="search-item">
                <a href="#">#Stisla</a>
                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
              </div>
              <div class="search-header">
                Result
              </div>
              <div class="search-item">
                <a href="#">
                  <img class="mr-3 rounded" width="30" src="../assets/img/products/product-3-50.png" alt="product">
                  oPhone S9 Limited Edition
                </a>
              </div>
              <div class="search-item">
                <a href="#">
                  <img class="mr-3 rounded" width="30" src="../assets/img/products/product-2-50.png" alt="product">
                  Drone X2 New Gen-7
                </a>
              </div>
              <div class="search-item">
                <a href="#">
                  <img class="mr-3 rounded" width="30" src="../assets/img/products/product-1-50.png" alt="product">
                  Headphone Blitz
                </a>
              </div>
              <div class="search-header">
                Projects
              </div>
              <div class="search-item">
                <a href="#">
                  <div class="search-icon bg-danger text-white mr-3">
                    <i class="fas fa-code"></i>
                  </div>
                  Stisla Admin Template
                </a>
              </div>
              <div class="search-item">
                <a href="#">
                  <div class="search-icon bg-primary text-white mr-3">
                    <i class="fas fa-laptop"></i>
                  </div>
                  Create a new Homepage Design
                </a>
              </div>
            </div>
          </div> --}}
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
              <li class="nav-item dropdown @yield('menuDataProyek')"">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-home"></i> <span>Data Proyek</span></a>
                <ul class="dropdown-menu">
                  <li class="@yield('menuUnit')"><a class="nav-link" href="{{route('unit')}}">Unit</a></li>
                  <li class="@yield('menuRAB')"><a class="nav-link" href="{{route('RAB')}}">RAB</a></li>
                  <li class="@yield('menuPengeluaran')"><a class="nav-link" href="{{route('pengeluaran')}}">Pengeluaran</a></li>
                </ul>
              </li>
              <li class="menu-header">Menu Costumer</li>
              <li class="@yield('menuCostumer')"><a class="nav-link" href="{{route('costumerIndex')}}"><i class="fas fa-user-friends"></i> <span>Costumer</span></a></li>
              <li class="nav-item dropdown @yield('menuCicilanDP')">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-coins"></i> <span>Cicilan DP</span></a>
                <ul class="dropdown-menu">
                  <li class=" @yield('menuCicilanDPRumah')"><a class="nav-link " href="{{route('DPRumah')}}">Rumah</a></li>
                  <li class=" @yield('menuCicilanDPKavling')"><a class="nav-link" href="{{route('DPKavling')}}">Kavling</a></li>
                  <li class=" @yield('menuCicilanDPKios')"><a class="nav-link " href="{{route('DPKios')}}">Kios</a></li>
                  
                </ul>
              </li>
              <li class="nav-item dropdown @yield('menuCicilanUnit')">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-money-bill-wave"></i> <span>Cicilan Unit</span></a>
                <ul class="dropdown-menu">
                  <li class=" @yield('menuCicilanUnitRumah')"><a class="nav-link" href="{{route('cicilanRumah')}}">Rumah</a></li>
                  <li class=" @yield('menuCicilanUnitKavling')"><a class="nav-link" href="{{route('cicilanKavling')}}">Kavling</a></li>
                  <li class=" @yield('menuCicilanUnitKios')"><a class="nav-link" href="{{route('cicilanKios')}}">Kios</a></li>
                  
                </ul>
              </li>
              
            </li>
            <li class="menu-header">Menu Keuangan</li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-handshake"></i> <span>Transaksi</span></a>
                <ul class="dropdown-menu">
                  <li><a href="auth-forgot-password.html">Masuk</a></li>
                  <li><a href="auth-login.html">Keluar</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i> <span>KAS</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="errors-503.html">Besar</a></li>
                  <li><a class="nav-link" href="errors-403.html">Kecil</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-clipboard-check"></i> <span>Laporan</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="features-activities.html">Bulanan</a></li>
                  <li><a class="nav-link" href="features-post-create.html">Tahunan</a></li>
                </ul>
              </li>
              {{-- <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-ellipsis-h"></i> <span>Utilities</span></a>
                <ul class="dropdown-menu">
                  <li><a href="utilities-contact.html">Contact</a></li>
                  <li><a class="nav-link" href="utilities-invoice.html">Invoice</a></li>
                  <li><a href="utilities-subscribe.html">Subscribe</a></li>
                </ul>
              </li>
              <li><a class="nav-link" href="credits.html"><i class="fas fa-pencil-ruler"></i> <span>Credits</span></a></li>
            </ul>

            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
              </a>
            </div> --}}
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
          2.3.0
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{asset('assets/js/stisla.js')}}"></script>

  <!-- JS Libraies -->
  {{-- <script src="../node_modules/chart.js/dist/Chart.min.js"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2/dist/Chart.min.js"></script>
  <script src="{{asset('assets/js/chocolat.js')}}"></script>

  <!-- Template JS File -->
  <script src="{{asset('assets/js/scripts.js')}}"></script>
  <script src="{{asset('assets/js/custom.js')}}"></script>

  <!-- Page Specific JS File -->
  @yield('script')

</body>
</html>
