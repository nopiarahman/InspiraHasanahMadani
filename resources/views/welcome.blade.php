<!DOCTYPE html >
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <!--<![endif]-->

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="description" content="Glax">
<meta name="author" content="Marketify">
<link rel="shortcut icon" href="{{asset('assets/img/logo-color.png')}}">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>Inspira Property</title>

<!-- STYLES -->
<link rel="stylesheet" type="text/css" href="{{asset('splide/css/splide.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('frontPage/css/fontello.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('frontPage/css/skeleton.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('frontPage/css/plugins.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('frontPage/css/base.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('frontPage/css/style.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Rubik:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

<!--[if lt IE 9]> <script type="text/javascript" src="js/modernizr.custom.js"></script> <![endif]-->
<!-- /STYLES -->

</head>

<body>


<!-- WRAPPER ALL -->
	
<div class="glax_tm_wrapper_all">
	
	<!-- LANG BOX -->
	{{-- <div class="lang_box">
		<ul>
			<li><span>Eng</span></li>
			<li><a href="#">Spa</a></li>
			<li><a href="#">Rus</a></li>
		</ul>
	</div> --}}
	<!-- /LANG BOX -->
	
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
							<li><a href="https://web.facebook.com/rumahsyariahjambi" target="_blank"><i class="xcon-facebook"></i></a></li>
							<li><a href="https://www.instagram.com/rumahsyariahjambi/" target="_blank"><i class="xcon-instagram"></i></a></li>
							<li><a href="https://www.youtube.com/channel/UCK7yv-ba5yqGmn6OkngGf4A"><i class="xcon-youtube"></i></a></li>
						</ul>
					</div>
					<div class="language">
						<a class="selected" href="#">IDN</a>
					</div>
				</div>
				<div class="right_part_wrap">
					<ul>
						<li data-style="home">
							<a href="#"><img class="svg" src="{{asset('frontPage/img/svg/home.svg')}}" alt="" /></a>
						</li>
						{{-- <li data-style="message">
							<a href="#"><img class="svg" src="{{asset('frontPage/img/svg/message2.svg')}}" alt="" /></a>
						</li> --}}
						<li data-style="phone">
							<a href="#"><img class="svg" src="{{asset('frontPage/img/svg/old_phone.svg')}}" alt="" /></a>
						</li>
						<li data-style="clock">
							<a href="#"><img class="svg" src="{{asset('frontPage/img/svg/clock.svg')}}" alt="" /></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- /TOP BAR -->
	
	<div class="wrapper_all_inner_wrap">
		
		<!-- HEADER -->
		<div class="glax_tm_header_wrap" data-style="transparent" data-position="absolute">
			<div class="container">
				<div class="header_inner_wrap">
					<div class="menu_wrap">
						<ul>
							<li><a href="/">Beranda</a></li>
							<li>
								<a href="{{route('proyekWeb')}}">Proyek</a>
							</li>
							<li>
								<a href="{{route('blog')}}">Kabar Berita</a>
							</li>
							<li><a href="{{route('tentang')}}">Tentang Kami</a></li>
							<li><a href="{{route('kontak')}}">Kontak</a></li>
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
						<img src="{{asset('frontPage/img/desktop-logo.png')}}" alt="" />
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
								<li data-type="home"><a href="#"><img class="svg" src="{{asset('frontPage/img/svg/home.svg')}}" alt="" /></a></li>
								{{-- <li data-type="message"><a href="#"><img class="svg" src="{{asset('frontPage/img/svg/message2.svg')}}" alt="" /></a></li> --}}
								<li data-type="phone"><a href="#"><img class="svg" src="{{asset('frontPage/img/svg/old-phone.svg')}}" alt="" /></a></li>
								<li data-type="clock"><a href="#"><img class="svg" src="{{asset('frontPage/img/svg/clock.svg')}}" alt="" /></a></li>
							</ul>
						</div>
						<div class="mobile_socials_wrap">
							<ul>
								<li><a href="https://web.facebook.com/rumahsyariahjambi" target="_blank"><i class="xcon-facebook"></i></a></li>
								<li><a href="https://www.instagram.com/rumahsyariahjambi/" target="_blank"><i class="xcon-instagram"></i></a></li>
								<li><a href="https://www.youtube.com/channel/UCK7yv-ba5yqGmn6OkngGf4A"><i class="xcon-youtube"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="mobile_header_wrap">
				<div class="container">
					<div class="inner_wrap">
						<div class="logo_wrap " style="align-content: center">
							<a href="/"><img src="{{asset('frontPage/img/mobile-logo.png')}}" alt="" /></a>
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
								<a href="{{route('proyekWeb')}}">Proyek</a>
							</li>
							<li>
								<a href="{{route('blog')}}">Kabar Berita</a>
							</li>
							<li><a href="{{route('tentang')}}">Tentang Kami</a></li>
							<li><a href="{{route('kontak')}}">Kontak</a></li>
				</ul>
			</div>
			<!-- /MENU LIST -->
			
			<!-- DROPDOWN -->
			<div class="glax_tm_dropdown_wrap">
				<div class="container">
					<div class="drop_list home">
						<div class="adress_wrap">
							<div class="office_image">
								<img src="{{asset('assets/img/logo-color.png')}}" alt="" />
							</div>
							<div class="definitions_wrap">
								<h3>Kantor Graha Inspira</h3>
								<p>Jl. Mayjen. A. Thalib No.12-Telanaipura Kota Jambi</p>
								<p>Google Maps: <a href="https://goo.gl/maps/bEox4wYEJH3WpcBu5">Graha Inspira</a></p>
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
								<img src="{{asset('frontPage/img/estimate/call.png')}}" alt="" />
							</div>
							<h3>Telp</h3>
							<p>0741-000000</p>
							<h3>Whatsapp</h3>
							<p>0821-8307-9255</p>
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
							<a href="#"><img class="svg" src="{{asset('frontPage/img/svg/home.svg')}}" alt="" /></a>
						</li>
						{{-- <li class="message" data-style="message">
							<a href="#"><img class="svg" src="{{asset('frontPage/img/svg/message2.svg')}}" alt="" /></a>
						</li> --}}
						<li class="phone" data-style="phone">
							<a href="#"><img class="svg" src="{{asset('frontPage/img/svg/old_phone.svg')}}" alt="" /></a>
						</li>
						<li class="clock" data-style="clock">
							<a href="#"><img class="svg" src="{{asset('frontPage/img/svg/clock.svg')}}" alt="" /></a>
						</li>
					</ul>
				</div>
				
				<!-- WIDGET DROPDOWN -->
				<div class="widget_dropdown_wrap">
					<div class="drop_list home">
						<div class="adress_wrap">
							<div class="office_image">
								<img src="{{asset('assets/img/logo-color.png')}}" alt="" />
							</div>
							<div class="definitions_wrap">
								<h3>Kantor Graha Inspira</h3>
								<p>Jl. Mayjen. A. Thalib No.12-Telanaipura Kota Jambi</p>
								<p>Google Maps: <a href="https://goo.gl/maps/bEox4wYEJH3WpcBu5">Graha Inspira</a></p>
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
								<img src="{{asset('frontPage/img/estimate/call.png')}}" alt="" />
							</div>
							<h3>Telp</h3>
							<p>0741-000000</p>
							<h3>Whatsapp</h3>
							<p>0821-8307-9255</p>

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
		
		<!-- HERO HEADER -->
		{{-- SPLIDE --}}
		{{-- https://splidejs.com/ --}}
		<div style="background-color: black">
			<div id="image-slider" class="splide " >
				<div class="splide__track">
					<ul class="splide__list">
						<li class="splide__slide">
							<div  style="opacity: 0.5">
								<img src="{{asset('frontPage/img/slider/1.jpg')}}">
							</div>
							<div class="slider_text">
								<h2>INSPIRA GROUP</h2>
								<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo reiciendis ipsam dignissimos explicabo rerum est ea quis blanditiis enim, nulla modi perspiciatis voluptates, qui corporis! Quaerat deleniti voluptatum et quod.</p>
							</div>
						</li>
						<li class="splide__slide">
							<div  style="opacity: 0.5">
								<img src="{{asset('frontPage/img/slider/2.jpg')}}">
							</div>
							<div class="slider_text">
								<h2>Properti Syariah Tanpa Riba</h2>
								<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo reiciendis ipsam dignissimos explicabo rerum est ea quis blanditiis enim, nulla modi perspiciatis voluptates, qui corporis! Quaerat deleniti voluptatum et quod.</p>
							</div>
						</li>
						<li class="splide__slide">
							<div  style="opacity: 0.5">
								<img src="{{asset('frontPage/img/slider/3.jpg')}}">
							</div>
							<div class="slider_text">
								<h2>Tanpa Denda, Tanpa Sita</h2>
								<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo reiciendis ipsam dignissimos explicabo rerum est ea quis blanditiis enim, nulla modi perspiciatis voluptates, qui corporis! Quaerat deleniti voluptatum et quod.</p>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<script>
			document.addEventListener( 'DOMContentLoaded', function () {
				new Splide( '#image-slider',{
					'type':'loop',
					'cover'      : true,
					'heightRatio': 0.5,
					'autoplay':true,
					'interval':3000,
				} ).mount();
			} );
		</script>
		<!-- /HERO HEADER -->
		
		<!-- HOME INTRODUCE -->
		<div class="glax_tm_section introduce">
			<div class="container">
				<div class="qqq">
					<div class="glax_tm_introduce_wrap">
						<div class="inner_wrap">
							<div class="main_info_wrap">
								<span class="top_title">Perkenalkan</span>
								<h3 class="title">Inspira Group</h3>
								<p class="text">For over 47 years, the Glax family has been building relationships and projects that last. We build safe environments and eco-friendly solutions in the communities in which we work. Most importantly, we build strong relationships that allow us to build anything, anywhere. No matter the job, we go beyond building.</p>
							</div>
							<div class="experience_box">
								<div class="top">
									<p>Developer Property Syariah</p>
								</div>
								<div class="bottom">
									<div class="number">
										<span>5</span>
									</div>
									<div class="definition">
										<p>Tahun Pengalaman</p>
									</div>
								</div>
							</div>
						</div>
						<div class="play_video">
							<a class="popup-youtube" href="https://www.youtube.com/watch?v=ya7OKUSmAug"></a>
						</div>
					</div>
					<div class="shape_top">
						<span class="first"></span>
						<span class="second"></span>
					</div>
					<div class="shape_bottom">
						<span class="first"></span>
						<span class="second"></span>
					</div>
				</div>
			</div>
		</div>
		<!-- /HOME INTRODUCE -->
		
		<!-- HOME SERVICE -->
		<div class="glax_tm_section">
			<div class="container">
				<div class="glax_tm_home_service_list">
					<ul class="glax_tm_miniboxes">
						<li>
							<div class="inner_list glax_tm_minibox">
								<div class="icon_wrap">
									<img class="svg" src="{{asset('frontPage/img/svg/moon-svgrepo-com.svg')}}" alt="" />
								</div>
								<div class="title_holder">
									<h3>Lingkungan Islami dan Nyaman</h3>
								</div>
								<div class="description">
									<p>During this phase, we will work to provide a detailed analysis of the project and we will establish project expectations along...</p>
								</div>
								<div class="glax_tm_button_more_wrap">
									{{-- <a href="#">
										More Details
										<span class="arrow_wrap">
											<span class="first"><img class="svg" src="{{asset('frontPage/img/svg/arrow-right.svg')}}" alt="" /></span>
											<span class="second"><img class="svg" src="{{asset('frontPage/img/svg/arrow-right.svg')}}" alt="" /></span>
										</span>
									</a> --}}
								</div>
								<a class="service_link" href="service-single.html"></a>
							</div>
						</li>
						<li>
							<div class="inner_list glax_tm_minibox">
								<div class="icon_wrap">
									<img class="svg" src="{{asset('frontPage/img/svg/badge-svgrepo-com.svg')}}" alt="" />
								</div>
								<div class="title_holder">
									<h3>Dipercaya Oleh Ratusan Pelanggan</h3>
								</div>
								<div class="description">
									<p>The client retains an architect or engineer to design the project and to prepare the necessary drawings and specifications for...</p>
								</div>
								<div class="glax_tm_button_more_wrap">
									{{-- <a href="#">
										More Details
										<span class="arrow_wrap">
											<span class="first"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
											<span class="second"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
										</span>
									</a> --}}
								</div>
								<a class="service_link" href="service-single.html"></a>
							</div>
						</li>
						<li>
							<div class="inner_list glax_tm_minibox">
								<div class="icon_wrap">
									<img class="svg" src="{{asset('frontPage/img/svg/money-svgrepo-com.svg')}}" alt="" />
								</div>
								<div class="title_holder">
									<h3>Tanpa Akad Riba</h3>
								</div>
								<div class="description">
									<p>Under a Construction Management contract, the client secures the services of a construction manager to work with the design...</p>
								</div>
								<div class="glax_tm_button_more_wrap">
									{{-- <a href="#">
										More Details
										<span class="arrow_wrap">
											<span class="first"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
											<span class="second"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
										</span>
									</a> --}}
								</div>
								<a class="service_link" href="service-single.html"></a>
							</div>
						</li>
						<li>
							<div class="inner_list glax_tm_minibox">
								<div class="icon_wrap">
									<img class="svg" src="{{asset('frontPage/img/svg/mosque-svgrepo-com.svg')}}" alt="" />
								</div>
								<div class="title_holder">
									<h3>Fasilitas Lengkap</h3>
								</div>
								<div class="description">
									<p>In this section, we let clients select a design-build arrangement when they want to work with one contract entity...</p>
								</div>
								<div class="glax_tm_button_more_wrap">
									{{-- <a href="#">
										More Details
										<span class="arrow_wrap">
											<span class="first"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
											<span class="second"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
										</span>
									</a> --}}
								</div>
								<a class="service_link" href="service-single.html"></a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /HOME SERVICE -->
		<!-- HOME BLOG -->
		<div class="glax_tm_section">
			<div class="glax_tm_home_blog_wrap">
				<div class="container">
					<div class="inner_wrap">
						<div class="blog_title_holder">
							<h3>Kabar &amp; Berita</h3>
							<h5 class="blog_link first"> <a href="{{route('blog')}}" style="text-decoration: none; color:black">Selengkapnya..</a> 
								<span class="arrow_wrap">
									<span class="first"><img class="svg" src="{{asset('frontPage/img/svg/arrow-right.svg')}}" alt="" /></span>
								</span>
							</h5>
						</div>
						<div>
						</div>
						<div class="blog_list">
							<ul>
								@foreach($kabarBerita as $kb)
								<li>
									<div class="inner">
										<div class="image_holder">
											@if($kb->thumbnail)
											<img src="{{Storage::url($kb->thumbnail)}}" alt="" height="250px"/>
											<div class="main_image" data-img-url="{{Storage::url($kb->thumbnail)}}"></div>
											@else
											<img src="{{asset('assets/img/logo-color.png')}}" alt="" height="250px" />
											<div class="main_image" data-img-url="{{asset('assets/img/logo-color.png')}}"></div>
											@endif
											<div class="overlay"></div>
											<div class="date_wrap">
												<h3><span>{{Carbon\Carbon::parse($kb->tanggal)->isoformat('DD')}}</span></h3>
												<h5>{{Carbon\Carbon::parse($kb->tanggal)->isoformat('MMM')}}</h5>
												<h5>{{Carbon\Carbon::parse($kb->tanggal)->isoformat('YYYY')}}</h5>
											</div>
											<a class="full_link" href="{{route('kabar_berita',['id'=>$kb->id])}}"></a>
										</div>
										<div class="descriptions_wrap">
											<p class="category">
												<span class="author">By <a href="#">{{$kb->author}}</a></span>
												<span class="city">Di <a href="#">{{$kb->proyek->nama}}</a></span>
											</p>
										</div>
										<div class="title_holder">
											<h3><a href="{{route('kabar_berita',['id'=>$kb->id])}}">{{$kb->judul}}</a></h3>
											<p>
												{{-- {!! $kb->isi!!} --}}
												{!! \Illuminate\Support\Str::limit($kb->isi, 150, $end='...') !!}
											</p>
										</div>
										<div class="glax_tm_button_more_wrap">
											<a href="{{route('kabar_berita',['id'=>$kb->id])}}">
												Read More
												<span class="arrow_wrap">
													<span class="first"><img class="svg" src="{{asset('frontPage/img/svg/arrow-right.svg')}}" alt="" /></span>
													<span class="second"><img class="svg" src="{{asset('frontPage/img/svg/arrow-right.svg')}}" alt="" /></span>
												</span>
											</a>
										</div>
									</div>
								</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /HOME BLOG -->
		<!-- WHY CHOOSE US-->
		<div class="glax_tm_section">
			<div class="glax_tm_rating_wrap">
				<div class="container">
					<div class="inner">
						<div class="leftbox">
							<div class="title">
								<h3>Alasan Mengapa anda memilih kami</h3>
							</div>
							<div class="text">
								<p>To further develop our corporate strengths we have established a corporate mandate to maintain strong core values that truly reflect the companys philosophy.</p>
							</div>
							<div class="glax_tm_project_video">
								<span>
									<img class="svg" src="{{asset('frontPage/img/svg/play.svg')}}" alt="" />
								</span>
								<a class="project_time" href="#">View Company Promo Video</a>
								<a class="project_video_button popup-youtube" href="https://www.youtube.com/watch?v=RyDaPkFNfUE"></a>
							</div>
						</div>
						<div class="ratingbox">
							<div class="rating_wrap">
								<div class="inner_wrap">
									<div class="star">
										<img src="{{asset('img/rating/rate.png')}}" alt="" />
									</div>
									<div class="number">
										<span>500+</span>
									</div>
									<div class="title">
										<p>Pelanggan</p>
									</div>
								</div>
							</div>
							<div class="rating_text">
								<div class="inner">
									<span>Telah membeli property syariah</span>
								</div>
							</div>
						</div>
								<img src="{{asset('assets/img/logo-color.png')}}" alt="" height="45%" style="margin-top:5%">
					</div>
				</div>
			</div>
		</div>
		<!-- /WHY CHOOSE US-->
		
		<!-- PRINCIPLES WRAP-->
		<div class="glax_tm_section">
			<div class="glax_tm_principles_wrapper_all">
				<div class="container">
					<div class="glax_tm_twice_box_wrap">
						<div class="inner_box">
							<div class="leftbox">
								<div class="title_holder">
									<h3>Visi Misi Perusahaan</h3>
								</div>
								<div class="description">
									<p>For over 35 years, the Glax family has been building relationships and projects that last. As a diversified construction management, design-build, and general contracting firm, Glax is recognized as one of Upstate New York's largest construction companies.</p>
									<p>Serving an impressive list of long-term clients, we are an organization of seasoned professionals with a tremendous breadth of construction experience and expertise across multiple industries.</p>
								</div>
							</div>
							<div class="rightbox">
								<div class="glax_tm_principles_wrap">
									<div class="list_wrap">
										<ul class="masonry">
											<li class="item">
												<div class="inner">
														<span class="leftshape"></span>
															<span class="topshape"></span>
														<div class="in">
														<div class="title">
															<h3>Humility</h3>
														</div>
														<div class="definition">
															<p>Be humble in all dealings with our partners, clients and team members. True wisdom and understanding belong to the humble.</p>
														</div>
														<div class="number">
															<span>01</span>
														</div>
													</div>
												</div>
											</li>
											<li class="item">
												<div class="inner">
														<span class="leftshape"></span>
															<span class="topshape"></span>
														<div class="in">
														<div class="title">
															<h3>Honesty</h3>
														</div>
														<div class="definition">
															<p>Be sure of our facts and be honest and straightforward in all of our dealings with each other and good our clients.</p>
														</div>
														<div class="number">
															<span>02</span>
														</div>
													</div>
												</div>
											</li>
											<li class="item">
												<div class="inner">
														<span class="leftshape"></span>
															<span class="topshape"></span>
														<div class="in">
														<div class="title">
															<h3>Integrity</h3>
														</div>
														<div class="definition">
															<p>Over the years, we have gained a reputation for integrity and trust from our customers who continue to use our services.</p>
														</div>
														<div class="number">
															<span>03</span>
														</div>
													</div>
												</div>
											</li>
											<li class="item">
												<div class="inner">
														<span class="leftshape"></span>
															<span class="topshape"></span>
														<div class="in">
														<div class="title">
															<h3>Quality Work</h3>
														</div>
														<div class="definition">
															<p>We ensure that all projects are done with professionalism using quality materials while offering clients the support and accessibility.</p>
														</div>
														<div class="number">
															<span>04</span>
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
				</div>
			</div>
		</div>
		<!-- /PRINCIPLES WRAP-->
		
		<!-- RESPOSIBILITY-->
		<div class="glax_tm_section">
			<div class="glax_tm_main_responsibility_wrap">
				<div class="glax_tm_universal_parallax_wrap">
					<div class="main_bg">
						<div class="overlay_image responsibility jarallax" data-speed="0"></div>
						<div class="overlay_color responsibility"></div>
					</div>
					<div class="main_content responsibility">
						<div class="container">
							<div class="content_inner_wrap">
								<div class="glax_tm_experience_box">
									<div class="top">
										<p>Developer Property Syariah</p>
									</div>
									<div class="bottom">
										<div class="number">
											<span>5</span>
										</div>
										<div class="definition">
											<p>Tahun Pengalaman</p>
										</div>
									</div>
								</div>
								<div class="experience_list">
									<ul>
										<li><span>Tanpa Bank</span></li>
										<li><span>Tanpa Bunga</span></li>
										<li><span>Tanpa Denda</span></li>
										<li><span>Tanpa Sita</span></li>
										<li><span>Tanpa BI Checking</span></li>
										<li><span>Tanpa Asuransi</span></li>
										<li><span>Tanpa Akad Bathil</span></li>
										{{-- <li><span>Communication skills</span></li>
										<li><span>Responsive and Respectful</span></li>
										<li><span>Personalised solutions</span></li>
										<li><span>Functional Objectives</span></li>
										<li><span>Integrated Design</span></li>
										<li><span>Urban Context</span></li>
										<li><span>Critical thinking</span></li>
										<li><span>Problem solving</span></li> --}}
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /RESPOSIBILITY-->
		
		<!-- HOME PROJECT-->
		<div class="glax_tm_section">
			<div class="glax_tm_home_project_wrapper_all">
				<div class="container">
					<div class="glax_tm_twice_box_wrap fn_w_sminiboxes">
						<div class="inner_box">
							<div class="leftbox project fn_w_sminibox">
								<div class="constructify_fn_sticky_section">
									<div class="title_holder">
										<h3>Our Latest Projects</h3>
									</div>
									<div class="description">
										<p>For over 35 years, the Glax family has been building relationships and projects that last. As a diversified construction management, design-build, and general contracting firm, Glax is recognized as one of Upstate New York's largest construction companies.</p>
									</div>
									<div class="glax_tm_button_more_wrap">
									<a href="project.html">
										View All Projects
										<span class="arrow_wrap">
											<span class="first"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
											<span class="second"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
										</span>
									</a>
								</div>
								</div>
							</div>
							<div class="rightbox fn_w_sminibox">
								<div class="constructify_fn_sticky_section">
									<ul>
										<li>
											<div class="inner">
												<div class="image_wrap">
													<img src="{{asset('frontPage/img/portfolio/750x500.jpg')}}" alt="" />
													<div class="image" data-img-url="{{asset('frontPage/img/portfolio/1.jpg')}}"></div>
													<div class="overlay_color"></div>
													<span class="plus"></span>
													<div class="title_holder">
														<h3>Matao Gas and Oil Organization</h3>
														<div class="glax_tm_view_more_wrap">
															<a href="project-single.html">
																<span class="text">View More</span>
																<span class="arrow"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
															</a>
														</div>
													</div>
													<a class="link" href="project-single.html"></a>
												</div>
											</div>
										</li>
										<li>
											<div class="inner">
												<div class="image_wrap">
													<img src="{{asset('frontPage/img/portfolio/750x500.jpg')}}" alt="" />
													<div class="image" data-img-url="{{asset('frontPage/img/portfolio/2.jpg')}}"></div>
													<div class="overlay_color"></div>
													<span class="plus"></span>
													<div class="title_holder">
														<h3>Odeon Industry Machinery</h3>
														<div class="glax_tm_view_more_wrap">
															<a href="#">
																<span class="text">View More</span>
																<span class="arrow"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
															</a>
														</div>
													</div>
													<a class="link" href="project-single.html"></a>
												</div>
											</div>
										</li>
										<li>
											<div class="inner">
												<div class="image_wrap">
													<img src="{{asset('frontPage/img/portfolio/750x500.jpg')}}" alt="" />
													<div class="image" data-img-url="{{asset('frontPage/img/portfolio/3.jpg')}}"></div>
													<div class="overlay_color"></div>
													<span class="plus"></span>
													<div class="title_holder">
														<h3>Chaban Car Industry</h3>
														<div class="glax_tm_view_more_wrap">
															<a href="#">
																<span class="text">View More</span>
																<span class="arrow"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
															</a>
														</div>
													</div>
													<a class="link" href="project-single.html"></a>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /HOME PROJECT -->
		
		<!-- FOOTER -->
		<footer class="glax_tm_footer_wrap">
			<div class="glax_tm_universal_parallax_wrap">
				<div class="main_bg">
					<div class="overlay_image footer jarallax" data-speed="0"></div>
					<div class="overlay_video"></div>								
					<div class="overlay_color footer"></div>
				</div>
				<div class="main_content footer">
					<div class="glax_tm_subscribe_wrap">
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
					</div>
					<div class="glax_tm_footer_wrap">
						<div class="container">
							<div class="glax_tm_list_wrap footer" data-column="3" data-space="40">
								<ul class="glax_list">
									<li>
										<div class="inner">
											<div class="footer_section_title">
												<h3>About Company</h3>
											</div>
											<div class="definition">
												<p>We are an award winning construction company focused on user-driven outcomes. We strive to create meaningful connections for users through considered.</p>
											</div>
										</div>
									</li>
									<li>
										<div class="inner">
											<div class="footer_section_title">
												<h3>Business Hours</h3>
											</div>
											<div class="inner_list">
												<ul>
													<li>
														<div class="wrap">
															<span class="left">Monday-Friday:</span>
															<span class="right">9am to 5pm</span>
														</div>
													</li>
													<li>
														<div class="wrap">
															<span class="left">Saturday:</span>
															<span class="right">10am to 3pm</span>
														</div>
													</li>
													<li>
														<div class="wrap">
															<span class="left">Sunday:</span>
															<span class="right">Closed</span>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</li>
									<li>
										<div class="inner">
											<div class="footer_section_title">
												<h3>Helpful Links</h3>
											</div>
											<div class="helpful_links">
												<div class="inner_list">
													<ul>
														<li><a href="#">Our services</a></li>
														<li><a href="#">Diclaimer</a></li>
														<li><a href="#">Showcase</a></li>
														<li><a href="#">Privacy Policy</a></li>
														<li><a href="#">Affliates</a></li>
													</ul>
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
					<div class="links_wrap">
						<ul>
							<li><a href="#">Services</a></li>
							<li><a href="#">Affliates</a></li>
							<li><a href="#">Disclaimer</a></li>
							<li><a href="#">Privacy Policy</a></li>
							<li><a href="#">Career</a></li>
						</ul>
					</div>
					<div class="copyright">
						<p>&copy; 1934 - 2018 <a class="constructify" href="#">Glax, LCC</a>. All rights reserved. Template has been designed by <a class="marketify" href="https://themeforest.net/user/marketify">Marketify</a></p>
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


<!-- SCRIPTS -->
<script src="{{asset('frontPage/js/jquery.js')}}"></script>
<script src="{{asset('frontPage/js/plugins.js')}}"></script>
<!--[if lt IE 10]> <script type="text/javascript" src="js/ie8.js"></script> <![endif]-->	
<script src="{{asset('frontPage/js/init.js')}}"></script>
<script src="{{asset('splide/js/splide.js')}}"></script>
<!-- /SCRIPTS -->


</body>
</html>
