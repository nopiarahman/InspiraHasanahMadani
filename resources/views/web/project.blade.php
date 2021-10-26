<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="description" content="Glax">
	<meta name="author" content="Marketify">
	<link rel="shortcut icon" href="{{asset('assets/img/logo-color.png')}}">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<title>Inspira Property</title>
	
	<!-- STYLES -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{asset('frontPage/css/fontello.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('splide/css/splide.min.css')}}" />
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
		<div class="glax_tm_header_wrap" data-style="light" data-position="relative">
			<div class="container">
				<div class="header_inner_wrap">
					<div class="menu_wrap">
						<ul>
							<li><a href="/">Beranda</a></li>
							<li>
								<a href="{{route('daftarProyek')}}">Proyek</a>
							</li>
							<li>
								<a href="{{route('blog')}}">Kabar Berita</a>
							</li>
							<li>
								<a href="{{route('galeri')}}">Galeri</a>
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
								<a href="{{route('daftarProyek')}}">Proyek</a>
							</li>
							<li>
								<a href="{{route('blog')}}">Kabar Berita</a>
							</li>
							<li>
								<a href="{{route('galeri')}}">Galeri</a>
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
		
		<!-- PROJECTS -->
		<div class="glax_tm_section">
			<div class="glax_tm_main_title_holder">
				<div class="container">
					<div class="title_holder">
						<h3>Proyek</h3>
					</div>
					<div class="builify_tm_breadcrumbs">
						<ul>
							<li><a href="/">Beranda</a></li>
							<li class="shape"><span></span></li>
							<li><span>Proyek</span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="glax_tm_section">
			<div class="container">
				<div class="glax_tm_projects_wrap">
					<div class="filter_wrap">
						<div class="all_projects">
							<span><a href="#">Semua Proyek</a></span>
						</div>
						<div class="filter_list">
							<ul class="glax_tm_portfolio_filter">
								<li><a href="#" class="current" data-filter="*">Semuanya</a></li>
								@foreach($daftarProyek as $proyek)
								<li><a href="#" data-filter=".{{$proyek->kategori}}">{{$proyek->kategori}}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
					<ul class="glax_tm_portfolio_list gallery_zoom">
						@forelse($daftarProyek as $proyek)
						<li class="{{$proyek->kategori}}">
							<div class="inner">
								<div class="image_wrap">
									<img src="{{Storage::url($proyek->cover)}}" alt="" />
									<div class="image" data-img-url="{{Storage::url($proyek->cover)}}"></div>
									<div class="overlay_color"></div>
									<span class="plus"></span>
									<div class="title_holder">
										<h3>{{$proyek->nama}}</h3>
										<div class="glax_tm_view_more_wrap">
											<a href="#">
												<span class="text">Selengkapnya</span>
												<span class="arrow"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
											</a>
										</div>
									</div>
									<a class="link" href="{{route('detailProyek',['id'=>$proyek->id])}}"></a>
								</div>
							</div>
						</li>
						@empty
						tidak ada proyek
						@endforelse
					</ul>
				</div>
			</div>
		</div>
		<div class="glax_tm_section">
			<div class="container">
				<div class="glax_tm_pagination">
					<ul>
						{{$daftarProyek->links()}}
							{{-- <li><span>Prev</span></li> --}}
						{{-- <li class="active"><a href="#">Next</a></li> --}}
					</ul>
				</div>
			</div>
		</div>
		<!-- /PROJECTS -->
		
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
											Inspira Kreasindo membentuk kompetensi yang dimiliki dan mengembangkan  landasan usaha yang berkesinambungan untuk  membantu umat

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
											<p style="color: #ccc;">Ayo bergabung bersama team kami sebagai Marketing Freelance, informasi lebih lanjut silahkan klik link dibawah ini</p>
											<a href="#" style="color: #fe7e00; text-decoration:none; font-weight:bold; "> >> Daftar Marketing Freelance</a>
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
				<p>&copy; 2021 <a class="constructify" href="#">Inspira Kreasindo</a>. All rights reserved. </p>
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
<div class="modal fade   "  id="myModal"  tabindex="-1" role="dialog"
 aria-labelledby="myModal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered  modal-lg  " role="document">
	<div class="modal-content">
			<div class="container-fluid">
						<div class="row">
								<div class="col-md-6 bg-img rounded-left m-h-60 d-none d-sm-block" style="background-image: url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1742&q=80')">
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

												<button type="submit" class="btn btn-cstm-dark btn-block btn-cta mt-5" data-dismiss="modal" aria-label="Close">Subscribe</button>
												
											</form>
											<div class="pt-3 ">
												<small><a href="#" data-bs-dismiss="modal" aria-label="Close" class="text-muted">Tutup</a></small>
										</div>
								</div>
						</div>
				</div>
		</div>
</div>
</div>
<!-- Modal Ends -->
<!-- SCRIPTS -->
<script src="{{asset('frontPage/js/jquery.js')}}"></script>
<script src="{{asset('frontPage/js/plugins.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!--[if lt IE 10]> <script type="text/javascript" src="js/ie8.js"></script> <![endif]-->	
<script src="{{asset('frontPage/js/init.js')}}"></script>
<script src="{{asset('splide/js/splide.js')}}"></script>
<script src="{{asset('js/fslightbox.js')}}"></script>
<script>
	var splide = new Splide( '.splide', {
  type    : 'loop',
  perPage : 3,
  autoplay: true,
	cover:true,
	heightRatio:0.2,
} );

splide.mount();
</script>

<!-- /SCRIPTS -->


</body>
</html>
