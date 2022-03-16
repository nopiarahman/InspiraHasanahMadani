<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="description" content="Glax">
    <meta name="author" content="Marketify">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo-color.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>Inspira Group</title>

    <!-- STYLES -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('splide/css/splide.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontPage/css/fontello.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontPage/css/skeleton.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontPage/css/plugins.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontPage/css/base.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontPage/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link
        href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

    <!--[if lt IE 9]> <script type="text/javascript" src="js/modernizr.custom.js"></script> <![endif]-->
    <!-- /STYLES -->

</head>

<body>


    <!-- WRAPPER ALL -->
    <div class="glax_tm_wrapper_all">


        <!-- BORDERS -->
        <div class="glax_tm_border_wrap">
            <div class="border top"></div>
            <div class="border left"></div>
            <div class="border right"></div>
        </div>
        <!-- /BORDERS -->

        <!-- HOLDER -->
        {{-- <div class="glax_tm_holder_wrap">
		<div class="holder left"></div>
		<div class="holder right"></div>
	</div> --}}
        <!-- /HOLDER -->

        <!-- TOP BAR -->
        <div class="glax_tm_topbar_wrap">
            <div class="container">
                <div class="inner_wrap">
                    <div class="left_part_wrap">
                        <div class="share_wrap">
                            <ul>
                                <li><a href="https://web.facebook.com/rumahsyariahjambi" target="_blank"><i
                                            class="xcon-facebook"></i></a></li>
                                <li><a href="https://www.instagram.com/rumahsyariahjambi/" target="_blank"><i
                                            class="xcon-instagram"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UCK7yv-ba5yqGmn6OkngGf4A"><i
                                            class="xcon-youtube"></i></a></li>
                            </ul>
                        </div>
                        <div class="language">
                            <a class="selected" href="#">IDN</a>
                        </div>
                    </div>
                    <div class="right_part_wrap">
                        <ul>
                            <li data-style="home">
                                <a href="#"><img class="svg"
                                        src="{{ asset('frontPage/img/svg/home.svg') }}" alt="" /></a>
                            </li>
                            {{-- <li data-style="message">
							<a href="#"><img class="svg" src="{{asset('frontPage/img/svg/message2.svg')}}" alt="" /></a>
						</li> --}}
                            <li data-style="phone">
                                <a href="#"><img class="svg"
                                        src="{{ asset('frontPage/img/svg/old_phone.svg') }}" alt="" /></a>
                            </li>
                            <li data-style="clock">
                                <a href="#"><img class="svg"
                                        src="{{ asset('frontPage/img/svg/clock.svg') }}" alt="" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /TOP BAR -->

        <div class="wrapper_all_inner_wrap">

            <!-- HEADER -->
            <div class="glax_tm_header_wrap" data-style="light" data-position="relative">
                <div class="container">
                    <div class="header_inner_wrap">
                        <div class="menu_wrap">
                            <ul>
                                <li><a href="/">Beranda</a></li>
                                <li>
                                    <a href="{{ route('daftarProyek') }}">Proyek</a>
                                </li>
                                <li>
                                    <a href="{{ route('blog') }}">Kabar Berita</a>
                                </li>
                                <li>
                                    <a href="{{ route('galeri') }}">Galeri</a>
                                </li>
                                <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
                                <li><a href="{{ route('kontak') }}">Kontak</a></li>
                            </ul>
                        </div>
                        <div class="purchase_button">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/home') }}">Home</a>
                                @else
                                    <a href="{{ route('login') }}">Login</a>

                                    {{-- @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Register</a>
                                @endif --}}
                                @endauth
                            @endif
                        </div>
                        <div class="logo_wrap">
                            <img src="{{ asset('frontPage/img/desktop-logo.png') }}" alt="" />
                            <span class="left"></span>
                            <span class="right"></span>
                            <span class="extra_first"></span>
                            <span class="extra_second"></span>
                            <a class="full_link" href="/"></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /HEADER -->

            <!-- MOBILE BAR -->
            <div class="glax_tm_mobile_bar_wrap">
                <div class="mobile_topbar_wrap">
                    <div class="container">
                        <div class="inner_wrap">
                            <div class="short_info_wrap">
                                <ul>
                                    <li data-type="home"><a href="#"><img class="svg"
                                                src="{{ asset('frontPage/img/svg/home.svg') }}" alt="" /></a></li>
                                    {{-- <li data-type="message"><a href="#"><img class="svg" src="{{asset('frontPage/img/svg/message2.svg')}}" alt="" /></a></li> --}}
                                    <li data-type="phone"><a href="#"><img class="svg"
                                                src="{{ asset('frontPage/img/svg/old-phone.svg') }}" alt="" /></a>
                                    </li>
                                    <li data-type="clock"><a href="#"><img class="svg"
                                                src="{{ asset('frontPage/img/svg/clock.svg') }}" alt="" /></a></li>
                                </ul>
                            </div>
                            <div class="mobile_socials_wrap">
                                <ul>
                                    <li><a href="https://web.facebook.com/rumahsyariahjambi" target="_blank"><i
                                                class="xcon-facebook"></i></a></li>
                                    <li><a href="https://www.instagram.com/rumahsyariahjambi/" target="_blank"><i
                                                class="xcon-instagram"></i></a></li>
                                    <li><a href="https://www.youtube.com/channel/UCK7yv-ba5yqGmn6OkngGf4A"><i
                                                class="xcon-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mobile_header_wrap">
                    <div class="container">
                        <div class="inner_wrap">
                            <div class="logo_wrap " style="align-content: center">
                                <a href="/"><img src="{{ asset('frontPage/img/mobile-logo.png') }}" alt="" /></a>
                            </div>
                            <div class="trigger_wrap">
                                <div class="hamburger hamburger--collapse-r">
                                    <div class="hamburger-box">
                                        <div class="hamburger-inner"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MENU LIST -->
                <div class="menu_list_wrap">
                    <ul class="nav">
                        <li><a href="/">Beranda</a></li>
                        <li>
                            <a href="{{ route('daftarProyek') }}">Proyek</a>
                        </li>
                        <li>
                            <a href="{{ route('blog') }}">Kabar Berita</a>
                        </li>
                        <li>
                            <a href="{{ route('galeri') }}">Galeri</a>
                        </li>
                        <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('kontak') }}">Kontak</a></li>
                    </ul>
                </div>
                <!-- /MENU LIST -->

                <!-- DROPDOWN -->
                <div class="glax_tm_dropdown_wrap">
                    <div class="container">
                        <div class="drop_list home">
                            <div class="adress_wrap">
                                <div class="office_image">
                                    <img src="{{ asset('assets/img/logo-color.png') }}" alt="" />
                                </div>
                                <div class="definitions_wrap">
                                    <h3>Kantor Graha Inspira</h3>
                                    <p>Jl. Mayjen. A. Thalib No.12-Telanaipura Kota Jambi</p>
                                    <p>Google Maps: <a href="https://goo.gl/maps/bEox4wYEJH3WpcBu5">Graha Inspira</a>
                                    </p>
                                    <p><span>Email:</span><a href="#">insprahasanahmadani@gmail.com</a></p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="drop_list message">
						<div class="short_contact">
							<h3 class="title">Request a Quote</h3>
							<p class="subtitle">Looking for a quality and affordable builder for your next project?</p>
							<div class="inputs_wrap">
								<form action="/" method="post">
									<div class="input_list_wrap">
										<ul>
											<li>
												<input type="text" placeholder="Your Name" />
											</li>
											<li>
												<input type="text" placeholder="E-mail Address" />
											</li>
											<li>
												<input type="text" placeholder="Main Subject" />
											</li>
										</ul>
									</div>
									<textarea placeholder="Message"></textarea>
									<div class="button">
										<a href="#">Send Message</a>
									</div>
								</form>
							</div>
						</div>
					</div> --}}
                        <div class="drop_list phone">
                            <div class="call_wrap">
                                <div class="image">
                                    <img src="{{ asset('frontPage/img/estimate/call.png') }}" alt="" />
                                </div>
                                <h3>Telp</h3>
                                <p>0741-000000</p>
                                <h3>Whatsapp</h3>
                                <p>0823-0000-0000</p>
                            </div>
                        </div>
                        <div class="drop_list clock">
                            <div class="working_hours_wrap_short">
                                <h3>Jam Operasional</h3>
                                <p class="subtitle">Insyaa Allah Kantor akan selalu buka di jam berikut:</p>
                                <div class="hour_list">
                                    <ul>
                                        <li>
                                            <span class="left">Senin-Jumat:</span>
                                            <span class="right">8.00 - 5.00</span>
                                        </li>
                                        <li>
                                            <span class="left">Sabtu:</span>
                                            <span class="right">08.00 - 12.00</span>
                                        </li>
                                        <li>
                                            <span class="left">Ahad:</span>
                                            <span class="right">Tutup</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /DROPDOWN -->

            </div>
            <!-- /MOBILE BAR -->

            <!-- SIDEBAR WIDGET -->
            <div class="glax_tm_widget_wrap">
                <div class="widget_inner_wrap">
                    <div class="widget_icons_wrap">
                        <ul>
                            <li class="home" data-style="home">
                                <a href="#"><img class="svg"
                                        src="{{ asset('frontPage/img/svg/home.svg') }}" alt="" /></a>
                            </li>
                            {{-- <li class="message" data-style="message">
							<a href="#"><img class="svg" src="{{asset('frontPage/img/svg/message2.svg')}}" alt="" /></a>
						</li> --}}
                            <li class="phone" data-style="phone">
                                <a href="#"><img class="svg"
                                        src="{{ asset('frontPage/img/svg/old_phone.svg') }}" alt="" /></a>
                            </li>
                            <li class="clock" data-style="clock">
                                <a href="#"><img class="svg"
                                        src="{{ asset('frontPage/img/svg/clock.svg') }}" alt="" /></a>
                            </li>
                        </ul>
                    </div>

                    <!-- WIDGET DROPDOWN -->
                    <div class="widget_dropdown_wrap">
                        <div class="drop_list home">
                            <div class="adress_wrap">
                                <div class="office_image">
                                    <img src="{{ asset('assets/img/logo-color.png') }}" alt="" />
                                </div>
                                <div class="definitions_wrap">
                                    <h3>Kantor Graha Inspira</h3>
                                    <p>Jl. Mayjen. A. Thalib No.12-Telanaipura Kota Jambi</p>
                                    <p>Google Maps: <a href="https://goo.gl/maps/bEox4wYEJH3WpcBu5">Graha Inspira</a>
                                    </p>
                                    <p><span>Email:</span><a href="#">insprahasanahmadani@gmail.com</a></p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="drop_list message">
						<div class="short_contact">
							<h3 class="title">Request a Quote</h3>
							<p class="subtitle">Looking for a quality and affordable builder for your next project?</p>
							<div class="inputs_wrap">
								<form action="/" method="post">
									<div class="input_list_wrap">
										<ul>
											<li>
												<input type="text" placeholder="Your Name" />
											</li>
											<li>
												<input type="text" placeholder="E-mail Address" />
											</li>
											<li>
												<input type="text" placeholder="Main Subject" />
											</li>
										</ul>
									</div>
									<textarea placeholder="Message"></textarea>
									<div class="button">
										<a href="#">Send Message</a>
									</div>
								</form>
							</div>
						</div>
					</div> --}}
                        <div class="drop_list phone">
                            <div class="call_wrap">
                                <div class="image">
                                    <img src="{{ asset('frontPage/img/estimate/call.png') }}" alt="" />
                                </div>
                                <h3>Telp</h3>
                                <p>0741-000000</p>
                                <h3>Whatsapp</h3>
                                <p>0823-0000-0000</p>
                            </div>
                        </div>
                        <div class="drop_list clock">
                            <div class="working_hours_wrap_short">
                                <h3>Jam Operasional</h3>
                                <p class="subtitle">Insyaa Allah Kantor akan selalu buka di jam berikut:</p>
                                <div class="hour_list">
                                    <ul>
                                        <li>
                                            <span class="left">Senin-Jumat:</span>
                                            <span class="right">8.00 - 5.00</span>
                                        </li>
                                        <li>
                                            <span class="left">Sabtu:</span>
                                            <span class="right">08.00 - 12.00</span>
                                        </li>
                                        <li>
                                            <span class="left">Ahad:</span>
                                            <span class="right">Tutup</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /WIDGET DROPDOWN -->
                </div>
            </div>
            <div class="glax_tm_widget_window_overlay"></div>
            <!-- /SIDEBAR WIDGET -->

            <!-- SERVICE SINGLE -->

            <div class="glax_tm_section">
                <div class="container">
                    <div class="glax_tm_service_single_wrap">
                        <div class="glax_tm_twicebox_wrap">
                            <div class="leftbox">
                                <div class="main_image_wrap">

                                </div>
                                <div class="container">
                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                                                class="rounded-circle profile-widget-picture" width="150px">
                                        </div>
                                        <div class="col-md-6 mt-5">
                                            <h3>Muchdian</h3>
                                            <p>Jl. H.M. Kamil No 46 Rt 015
                                                Kel : Wijaya Pura Jambi 36139.</p>
                                        </div>
                                        <div class="col-md-4 text-end mt-5">
                                            <p>
                                                <i class="fa fa-phone" aria-hidden="true"></i> Telp: +6285266014432
                                            </p>
                                            <p>
                                                <i class="fa fa-envelope mt-3" aria-hidden="true"></i> Email :
                                                muchdian.finwinner@gmail.com
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="card  shadow p-3 mb-3 ">
                                                <div class="card-header">
                                                    <h4>Pendidikan</h4>
                                                </div>
                                                <div class="card-body">
                                                    <ol class=" ms-3">
                                                        <li>
                                                            <h6>Universitas Mercu Buana (Jakarta, Juli 2003)</h6>
                                                            <p>Bachelor of Civil Enginering, </p>
                                                        </li>
                                                        <li>
                                                            <h6>Akademi Teknologi Sapta Taruna (Jakarta, August 1999)
                                                            </h6>
                                                            <p>Diploma 3 of Civil Enginering </p>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <div class="card shadow p-3 mb-3 ">
                                                <div class="card-header">
                                                    <h4>Training dan Seminar</h4>
                                                </div>
                                                <div class="card-body">
                                                    <ol class=" ms-3">
                                                        <li>
                                                            Training leadership for 2 week’s in LM Patra (Jakarta,2002)
                                                        </li>
                                                        <li>
                                                            English Course di IEC the Conversation Program (Jakarta,
                                                            2003)
                                                        </li>
                                                        <li>
                                                            Program AUTO CAD 2000 2D&3D Course in LP3KT (Jakarta, 2004)
                                                        </li>
                                                        <li>
                                                            Program 3D Max R5 Program Course in LP3KT (Jakarta, 2004)
                                                        </li>
                                                        <li>
                                                            Training Program Pendalaman & Sertifikasi Personel Astra
                                                            Friendly Company (Jambi, 2005)
                                                        </li>
                                                        <li>
                                                            Training & Seminar dengan Topic Pembahasan : Kemampuan dan
                                                            Strategi Marketing dalam
                                                            Pencapaian
                                                            Target Penjualan oleh motivator Andre Wongso (Jakarta, 2005)
                                                        </li>
                                                        <li>
                                                            Training Topic Pembahasan : Measuring Customer Satisfaction,
                                                            Marketing Plan, Business Plan
                                                            dan
                                                            Riset Pemasaran oleh Freddy Rangkuti & Associates
                                                            best-selling (Jambi, 2006)
                                                        </li>
                                                        <li>
                                                            Training Pendalaman Bisnis Syariah di Asuransi dan
                                                            Pembiayaan kendaraan di Selenggarakan
                                                            oleh
                                                            PT. Asuransi Astra dan PT. FIF (Jambi, 2007)
                                                        </li>
                                                        <li>
                                                            Training Persuasion and Selling skil with Neuro Linguistic
                                                            Programming oleh Ronny f.
                                                            Ronodirdjo (Jakarta, 2008)
                                                        </li>
                                                        <li>
                                                            Mengikuti Sertifikasi Profesi REGISTERED FINANCIAL PLANNER
                                                            (RFP) by FPSB bekerjasama
                                                            dengan
                                                            UNIVERSITAS INDONESIA (Jambi, May 2014)
                                                        </li>
                                                        <li>
                                                            Training dan Work Shop Akad Jual Beli pada Koperasi Syariah
                                                            by Erwandi Tarmizi Associated
                                                            /ETA
                                                            . (Palembang , Oktober 2017)
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <div class="card shadow p-3 mb-3 ">
                                                <div class="card-header">
                                                    <h4>Skills</h4>
                                                </div>
                                                <div class="card-body">
                                                    <ol class=" ms-3">
                                                        <li>
                                                            Strong leadership and interpersonal skills.
                                                        </li>
                                                        <li>
                                                            Negotiation skills.
                                                        </li>
                                                        <li>
                                                            Analytical skills including cost analysis and financial
                                                            skills.
                                                        </li>
                                                        <li>
                                                            Fluently speaking and writing in English
                                                        </li>
                                                        <li>
                                                            Computer literate (Win 98/2007/XP, Microsoft Office XP
                                                            programs ( Word, Excel. Power Point,
                                                            Corel Draw) MsOutlook, SAP, Lotus Note/E-mail user and Inte,
                                                            SAP, Lotus Note/E-mail user and
                                                            Internet tools).

                                                        </li>

                                                    </ol>
                                                </div>
                                            </div>
                                            <div class="card my-2 shadow p-3 mb-3 ">
                                                <div class="card-header">
                                                    <h4>Professional Experience</h4>
                                                </div>
                                                <div class="card-body">
                                                    <ol class=" ms-3">
                                                        <li>
                                                            <strong> PT. INSPIRA HASANAH ,MADANI</strong> Direktur Utama
                                                            2020- Now
                                                        </li>
                                                        <li>
                                                            <strong>
                                                                PT. TIFA TOUR
                                                            </strong>
                                                            Kepala Perwakilan (Jambi, 2019- 2020)
                                                        </li>
                                                        <li>
                                                            <strong>ELANG PROPERTY
                                                            </strong>
                                                            Kepala Perwakilan (Jambi, 2019-2020)
                                                        </li>
                                                        <li>
                                                            <strong>
                                                                PT. SANABIL UMROH
                                                            </strong>
                                                            Kepala Perwakilan (Jambi, 2018- 2019)
                                                        </li>
                                                        <li>
                                                            <strong>
                                                                PT. MTRA INSPIRA MADANI
                                                            </strong>
                                                            Directur Pemasaran (Jambi, 2017- 2019)
                                                        </li>
                                                        <li>
                                                            <strong>
                                                                PT. PRUDENTIAL LIFE ASSURANCE
                                                            </strong>
                                                            Agency Directur (Jambi, January 2011 –2017)
                                                            <ul class=" ms-3">
                                                                <li>
                                                                    Sebagai Financial Konsultan yang Memasarkan Produk
                                                                    Asuransi Unit Link secara
                                                                    langsung ke
                                                                    Customer atau Membuka Pasar Baru Melalui Jalur
                                                                    Jaringan team Agent.
                                                                </li>
                                                                <li>
                                                                    Memanaged & Supervisi agent (Recruitment, Produksi
                                                                    dan Report)
                                                                </li>
                                                                <li>
                                                                    Sebagai Team Trainer di Agency
                                                                </li>
                                                                <li>
                                                                    PIC Kantor Agency di Kota Muara Bulian
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <strong>
                                                                PT. BIODIESEL JAMBI (PMA From INDIA, Group KS Oils Palm
                                                                & Oil Plantation)
                                                            </strong><br>
                                                            Logistik Manager (Jambi, Oktober 2009 –2011)
                                                            <ul class=" ms-3">
                                                                <li>
                                                                    Reported to Direktur Operasional
                                                                </li>
                                                                <li>
                                                                    Managed dan Supervise Logistik Divisi.
                                                                </li>
                                                                <li>
                                                                    Memenuhi dan Membeli kebutuhan/ Permintaan Kantor
                                                                    dan Kebun.
                                                                </li>
                                                                <li>
                                                                    Menentukan Supplier dengan mempertimbangkan harga
                                                                    yang ekonomis & efisien.
                                                                </li>
                                                                <li>
                                                                    Melakukan Kontrol pembelian hingga sampai pengiriman
                                                                    ke office/gudang.
                                                                </li>
                                                                <li>
                                                                    Bertanggung jawab terhadap kebutuhan Gudang di kebun
                                                                    dan Membuat Repot Data stock
                                                                    bulanan
                                                                    berdasarkan hasil stock opname Div. Logistik
                                                                    perbulan.
                                                                </li>
                                                            </ul>

                                                            General Affair Manager (Jambi, Juni 2009- Oktober 2009)
                                                            <ul class=" ms-3">
                                                                <li>
                                                                    Reported to Direktur Umum
                                                                </li>
                                                                <li>
                                                                    Managed dan Supervise GA Divisi.
                                                                </li>
                                                                <li>
                                                                    Kontrol Kebutuhan Office dan Kebun (Maintenance
                                                                    Kendaraan, Alat Berat,Genset,
                                                                    gedung,
                                                                    Kebutuhan Atk, Perijinan & Legalitas Perusahaan,
                                                                    Asuransi Aset, dll)
                                                                </li>
                                                                <li>
                                                                    Membuat Repot Aset Perbulan dan Membuat Budget GA
                                                                    Divisi
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <strong>
                                                                PT. ASURANSI ASTRA / GARDA OTO (Group PT. Astra
                                                                International, Tbk)
                                                            </strong>
                                                            Senior Sales Officer (Jambi, 2008 – 2009)
                                                            <br>
                                                            Branch Promotion & Sales Officer ( Jambi, 2005 – 2008)
                                                            <ul class=" ms-3">
                                                                <li>
                                                                    Reporting to Branch Manager.
                                                                </li>
                                                                <li>
                                                                    Membuat Program/Kegiatan Promosi Asuransi Garda Oto
                                                                    di Cabang.
                                                                </li>
                                                                <li>
                                                                    Memasarkan Produk Asuransi Garda Oto secara langsung
                                                                    ke Customer atau Jalur
                                                                    Distribusi
                                                                    Penjualan Garda Oto ( Dealer, Banking, Leasing ).
                                                                </li>
                                                                <li>
                                                                    Memanaged & Supervisi Reguler / Referal agent
                                                                    (Recruitment, Produksi dan Report)
                                                                </li>
                                                                <li>
                                                                    Bertanggung jawab terhadap target produksi dari
                                                                    customer Retail di cabang ( Walk- in
                                                                    Customer,
                                                                    Agent, Amway, Dealer, Bangking, GO Coy).
                                                                </li>
                                                                <li>
                                                                    Membuat Report untuk Bahan Planning Cycle for Branch
                                                                    Review per kuartal
                                                                </li>
                                                                <li>
                                                                    Membuat mapping dan market share dari kondisi pasar
                                                                    untuk report cabang.
                                                                </li>
                                                                <li>
                                                                    Membuat budget dasar tahunan untuk program marketing
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <strong>
                                                                PT. L’ORÉAL INDONESIA (International Company L’ORÉAL
                                                                Group )
                                                            </strong>
                                                            Merchandising Officer (Jakarta, 2002 – 2005) <br>
                                                            Built and developed Merchandising Department. Managed
                                                            purchasing and logistics of Marketing
                                                            and
                                                            Sales Equipment. Maintained and managed key customer and
                                                            supplier relationship. Key
                                                            Contributions/Projects:
                                                            <ul class=" ms-3">
                                                                <li>
                                                                    Reporting to Senior DBU Manager PT. Loreal Indonesia
                                                                </li>
                                                                <li>
                                                                    Exspansi Jalur Distribusi ke Hypermarket Supermarket
                                                                    dan Dept. store
                                                                </li>
                                                                <li>
                                                                    Membuat Planogram dan Manajemen Perlertakan/Display
                                                                    Barang Jual.
                                                                </li>
                                                                <li>
                                                                    Instructur Training Merchandising.
                                                                </li>
                                                                <li>
                                                                    Supervisi Supplier dalam hal design Counter dan
                                                                    Technical Drawing.
                                                                </li>
                                                                <li>
                                                                    Menegosiasikan pembelian ke Supplier untuk
                                                                    mendapatkan harga terbaik.
                                                                </li>
                                                                <li>
                                                                    Mengawasi kualitas barang yg sedang diproduksi oleh
                                                                    Supplier.
                                                                </li>
                                                                <li>
                                                                    Mengatur/Mengurusi seluruh Counter dan event
                                                                    promosi.
                                                                </li>
                                                                <li>
                                                                    Mengajukan & Menegosiasikan Area dan Design Counter
                                                                    kepada Pihak Store.
                                                                </li>
                                                                <li>
                                                                    Membuat budget dasar untuk rencana marketing
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <strong>
                                                                PT. AASCO Consultant Jambi
                                                            </strong>
                                                            Staff Ahli Tehnik (Jambi, 2000 – 2002) (Kontrak)
                                                            <ul class=" ms-3">
                                                                <li>
                                                                    Team Leader Proyek Perencanaan
                                                                </li>
                                                                <li>
                                                                    Utusan Perusahaan dalam Tender Proyek
                                                                </li>
                                                                <li>
                                                                    Estimator Project
                                                                </li>
                                                                <li>
                                                                    Inspector
                                                                </li>
                                                                <li>
                                                                    Mengurusi Termyn Project untuk Perusahaan
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <strong>
                                                                PT. LENTERA CIPTA NUSA . ( Jakarta, 1999-2000)
                                                            </strong>
                                                            Supervisor Engineering ( Kontrak 1 tahun)
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <div class="card my-2 shadow p-3 mb-3 ">
                                                <div class="card-header">
                                                    <h4>Track Of Record</h4>
                                                </div>
                                                <div class="card-body">
                                                    <ol class=" ms-3">
                                                        <li>
                                                            <strong>
                                                                PT.PRUDENTIAL LIFE ASSURANCE
                                                            </strong>
                                                            <ul class=" ms-3">
                                                                <li>
                                                                    3 tahun mencapai Karir Agency Manager
                                                                    <ul>
                                                                        <li>
                                                                            2012 Unit Manager
                                                                        </li>
                                                                        <li>
                                                                            2013 Senior Unit Manager
                                                                        </li>
                                                                        <li>
                                                                            2014 Agency Manager.
                                                                        </li>
                                                                        <li>
                                                                            Tahun 2012 mencapai prestasi TOP NO 1 Unit
                                                                            Manager Di Agency National dan
                                                                            TOP 500 leader di Prudential Life ke KL
                                                                            Malaysia
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li>
                                                                    Tahun 2013 TOP No 2 Senior Unit Manager Di Agency
                                                                    National
                                                                </li>
                                                                <li>
                                                                    Tahun 2014 dipercaya menjadi Chairman di Agency (
                                                                    Kepala 66 Leader dan 300 agent )
                                                                </li>
                                                                <li>
                                                                    Tahun 2015 Membuka kantor perwakilan Agency di Muara
                                                                    Bulian.
                                                                </li>
                                                                <li>
                                                                    Tahun 2016 dipercaya sebagai PIC Syariah di Agency
                                                                    Finwinner.
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <strong>
                                                                PT. BIODIESEL JAMBI
                                                            </strong>
                                                            <ul class=" ms-3">
                                                                <li>
                                                                    Joint 4 bulan dimutasikan/dipercaya sebagai Logistik
                                                                    Manager.
                                                                </li>
                                                                <li>
                                                                    Efesiensi Pembelian Material Agronomis dan Tehnik
                                                                    Mencapai 20 % dari Pembelian
                                                                    sebelumnya
                                                                    sehingga Beban Project yang ditanggung Perusahaan
                                                                    makin kecil.
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <strong>
                                                                PT. ASURANSI ASTRA / GARDA OTO
                                                            </strong>
                                                            <ul class=" ms-3">
                                                                <li>
                                                                    Tahun 2007 Pemenang 10 besar SO Contest (Sales
                                                                    Countest) PT. Asuransi Astra Buana
                                                                    Seluruh
                                                                    Indonesia.
                                                                </li>
                                                                <li>
                                                                    Tahun 2007 menjadi pemenang Best of the Best STAR
                                                                    PROGRAM PT. Asuransi Astra Buana
                                                                    (Award
                                                                    karyawan terbaik seluruh indonesia)
                                                                </li>
                                                                <li>
                                                                    Tahun 2008 menjadi pemenang The Best Sales Officer
                                                                    PT. Asuransi Astra Buana
                                                                </li>
                                                                <li>
                                                                    Tahun 2008 menjadi pemenang Best of the Best STAR
                                                                    PROGRAM PT. Asuransi Astra Buana
                                                                    (Award
                                                                    karyawan terbaik seluruh indonesia)
                                                                </li>
                                                                <li>
                                                                    Tahun 2006 mengirim award 1 contestan sales dealer
                                                                    Jambi masuk nominasi 5 besar
                                                                    contes
                                                                    sales dealer seluruh Indonesia.
                                                                </li>
                                                                <li>
                                                                    Tahun 2008 mengirim contestan award sales delaer
                                                                    Jambi 2 orang menjadi nominasi 3
                                                                    besar
                                                                    contes sales dealer seluruh Indonesia.
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <strong>
                                                                PT. L’ORÉAL INDONESI A
                                                            </strong>
                                                            <ul class=" ms-3">
                                                                <li>
                                                                    Tahun 2003 Dipercaya handle 2 brand Loreal dan
                                                                    Maybelline di Dept. Store departement
                                                                </li>
                                                                <li>
                                                                    Tahun 2004 dalam 1 tahun meyelesaikan 55 project
                                                                    Counter Loreal & Maybelline
                                                                </li>
                                                                <li>
                                                                    Dari event promosi yang diadakan tahun 2004
                                                                    pencapaian Achievment penjualan
                                                                    mencapai 150 % dari target tahunan.
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /SERVICE SINGLE -->
            <!-- FOOTER -->
            <footer class="glax_tm_footer_wrap">
                <div class="glax_tm_universal_parallax_wrap">
                    <div class="main_bg">
                        <div class="overlay_image footer jarallax" data-speed="0"></div>
                        <div class="overlay_video"></div>
                        <div class="overlay_color footer"></div>
                    </div>
                    <div class="main_content footer">
                        {{-- <div class="glax_tm_subscribe_wrap">
						<div class="container">
							<div class="inner_wrap">
								<div class="left_wrap">
									<div class="book">
										<img class="svg" src="img/svg/open-book.svg" alt="" />
									</div>
									<div class="text">
										<p>Newsletter<span></span> get updates with latest topics</p>
									</div>
								</div>
								<div class="right_wrap">
									<input class="email" type="email" placeholder="Your e-mail address">
									<input class="button" type="button" value="subscribe">
								</div>
							</div>
						</div>
					</div> --}}
                        <div class="glax_tm_footer_wrap">
                            <div class="container">
                                <div class="glax_tm_list_wrap footer" data-column="3" data-space="40">
                                    <ul class="glax_list">
                                        <li>
                                            <div class="inner">
                                                <div class="footer_section_title">
                                                    <h3>Tentang Kami</h3>
                                                </div>
                                                <div class="definition">
                                                    <p>
                                                        Inspira Kreasindo membentuk kompetensi yang dimiliki dan
                                                        mengembangkan landasan usaha yang berkesinambungan untuk
                                                        membantu umat

                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="inner">
                                                <div class="footer_section_title">
                                                    <h3>Jam Kerja</h3>
                                                </div>
                                                <div class="inner_list">
                                                    <ul>
                                                        <li>
                                                            <div class="wrap">
                                                                <span class="left">Senin - Jumat:</span>
                                                                <span class="right">08.00 - 17.00</span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="wrap">
                                                                <span class="left">Sabtu:</span>
                                                                <span class="right">08.00 - 12.00</span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="wrap">
                                                                <span class="left">Ahad:</span>
                                                                <span class="right">Tidak Melayani</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="inner">
                                                <div class="footer_section_title">
                                                    <h3>Bergabung Bersama Kami</h3>
                                                </div>
                                                <div class="helpful_links">
                                                    <div class="inner_list">
                                                        <p style="color: #ccc;">Ayo bergabung bersama team kami sebagai
                                                            Marketing Freelance, informasi lebih lanjut silahkan klik
                                                            link dibawah ini</p>
                                                        <a href="#"
                                                            style="color: #fe7e00; text-decoration:none; font-weight:bold; ">
                                                            >> Daftar Marketing Freelance</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom_wrap">
                    <div class="container">
                        {{-- <div class="links_wrap">
						<ul>
							<li><a href="#">Services</a></li>
							<li><a href="#">Affliates</a></li>
							<li><a href="#">Disclaimer</a></li>
							<li><a href="#">Privacy Policy</a></li>
							<li><a href="#">Career</a></li>
						</ul>
					</div> --}}
                        <div class="copyright">
                            <p>&copy; 2021 <a class="constructify" href="#">Inspira Kreasindo</a>. All rights
                                reserved. </p>
                            <a class="glax_tm_totop" href="#">
                                <span class="shape"></span>
                                <span class="name">To Top</span>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- /FOOTER -->

        </div>
    </div>
    <!-- / WRAPPER ALL -->

    <!-- Modal -->
    <div class="modal fade   " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg  " role="document">
            <div class="modal-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 bg-img rounded-left m-h-60 d-none d-sm-block"
                            style="background-image: url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1742&q=80')">
                        </div>
                        <div class="col-md-6 py-5 px-sm-5 my-auto ">
                            <h2 class="pt-sm-3">Bergabung Bersama Kami </h2>
                            <p class="text-muted">
                                Sebagai Marketing Freelance
                            </p>
                            <form>
                                {{-- <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div> --}}

                                <button type="submit" class="btn btn-cstm-dark btn-block btn-cta mt-5"
                                    data-dismiss="modal" aria-label="Close">Subscribe</button>

                            </form>
                            <div class="pt-3 ">
                                <small><a href="#" data-bs-dismiss="modal" aria-label="Close"
                                        class="text-muted">Tutup</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Ends -->
    <!-- SCRIPTS -->
    <script src="{{ asset('frontPage/js/jquery.js') }}"></script>
    <script src="{{ asset('frontPage/js/plugins.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <!--[if lt IE 10]> <script type="text/javascript" src="js/ie8.js"></script> <![endif]-->
    <script src="{{ asset('frontPage/js/init.js') }}"></script>
    <script src="{{ asset('splide/js/splide.js') }}"></script>

    <!-- /SCRIPTS -->


</body>

</html>
