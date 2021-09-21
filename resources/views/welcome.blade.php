<!DOCTYPE html >
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <!--<![endif]-->

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="description" content="Glax">
<meta name="author" content="Marketify">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>Inspira Property</title>

<!-- STYLES -->
<link rel="stylesheet" type="text/css" href="{{asset('frontPage/css/fontello.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('frontPage/css/skeleton.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('frontPage/css/plugins.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('frontPage/css/base.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('frontPage/css/style.css')}}" />
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
	<div class="lang_box">
		<ul>
			<li><span>Eng</span></li>
			<li><a href="#">Spa</a></li>
			<li><a href="#">Rus</a></li>
		</ul>
	</div>
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
							<li><a href="#"><i class="xcon-facebook"></i></a></li>
							<li><a href="#"><i class="xcon-twitter"></i></a></li>
							<li><a href="#"><i class="xcon-instagram"></i></a></li>
							<li><a href="#"><i class="xcon-pinterest"></i></a></li>
							<li><a href="#"><i class="xcon-behance"></i></a></li>
						</ul>
					</div>
					<div class="language">
						<a class="selected" href="#">Eng</a>
					</div>
				</div>
				<div class="right_part_wrap">
					<ul>
						<li data-style="home">
							<a href="#"><img class="svg" src="{{asset('frontPage/img/svg/home.svg')}}" alt="" /></a>
						</li>
						<li data-style="message">
							<a href="#"><img class="svg" src="{{asset('frontPage/img/svg/message2.svg')}}" alt="" /></a>
						</li>
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
							<li><a href="index.html">Beranda</a></li>
							<li class="shape">
								<a href="project.html">Proyek</a>
								<div class="submenu_wrap">
									<ul>
										<li><a href="project.html">Project</a></li>
										<li><a href="project-single.html">Project Single</a></li>
									</ul>
								</div>
							</li>
							<li class="shape">
								<a href="#">Kabar Berita</a>
								<div class="submenu_wrap">
									<ul>
										<li><a href="blog.html">News</a></li>
										<li><a href="blog-single.html">News Single</a></li>
									</ul>
								</div>
							</li>
							<li><a href="about.html">Tentang Kami</a></li>
							<li><a href="contact.html">Kontak</a></li>
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
						<a class="full_link" href="index.html"></a>
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
								<li data-type="message"><a href="#"><img class="svg" src="{{asset('frontPage/img/svg/message2.svg')}}" alt="" /></a></li>
								<li data-type="phone"><a href="#"><img class="svg" src="{{asset('frontPage/img/svg/old-phone.svg')}}" alt="" /></a></li>
								<li data-type="clock"><a href="#"><img class="svg" src="{{asset('frontPage/img/svg/clock.svg')}}" alt="" /></a></li>
							</ul>
						</div>
						<div class="mobile_socials_wrap">
							<ul>
								<li><a href="#"><i class="xcon-facebook"></i></a></li>
								<li><a href="#"><i class="xcon-twitter"></i></a></li>
								<li><a href="#"><i class="xcon-instagram"></i></a></li>
								<li><a href="#"><i class="xcon-pinterest"></i></a></li>
								<li><a href="#"><i class="xcon-behance"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="mobile_header_wrap">
				<div class="container">
					<div class="inner_wrap">
						<div class="logo_wrap " style="align-content: center">
							<a href="index.html"><img src="{{asset('frontPage/img/mobile-logo.png')}}" alt="" /></a>
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
					<li><a href="index.html">Homepage</a></li>
					<li>
						<a href="#">Projects</a>
						<ul class="sub_menu">
							<li><a href="project.html">Project</a></li>
							<li><a href="project-single.html">Project Single</a></li>
						</ul>
					</li>
					<li>
						<a href="#">Our Services</a>
						<ul class="sub_menu">
							<li><a href="service.html">Service</a></li>
							<li><a href="service-single.html">Service Single</a></li>
						</ul>
					</li>
					<li><a href="blog.html">Blog</a></li>
					<li><a href="about.html">About Us</a></li>
					<li><a href="contact.html">Contact</a></li>
				</ul>
			</div>
			<!-- /MENU LIST -->
			
			<!-- DROPDOWN -->
			<div class="glax_tm_dropdown_wrap">
				<div class="container">
					<div class="drop_list home">
						<div class="adress_wrap">
							<div class="office_image">
								<img src="{{asset('frontPage/img/contact/1.jpg')}}" alt="" />
							</div>
							<div class="definitions_wrap">
								<h3>Head Office in New-York</h3>
								<p>775 New York Ave, Brooklyn, NY 11203</p>
								<p>Phone: +1 202-415-7234</p>
								<p><span>Email:</span><a href="#">w.constructify@gmail.com</a></p>
							</div>
						</div>
					</div>
					<div class="drop_list message">
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
					</div>
					<div class="drop_list phone">
						<div class="call_wrap">
							<div class="image">
								<img src="{{asset('frontPage/img/estimate/call.png')}}" alt="" />
							</div>
							<h3>Toll Free</h3>
							<p>1-800-987-6543</p>
						</div>
					</div>
					<div class="drop_list clock">
						<div class="working_hours_wrap_short">
							<h3>Working Hours</h3>
							<p class="subtitle">We are happy to meet you during our working hours. Please make an appointment.</p>
							<div class="hour_list">
								<ul>
									<li>
										<span class="left">Monday-Friday:</span>
										<span class="right">9am to 5pm</span>
									</li>
									<li>
										<span class="left">Saturday:</span>
										<span class="right">10am to 3pm</span>
									</li>
									<li>
										<span class="left">Sunday:</span>
										<span class="right">Closed</span>
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
						<li class="message" data-style="message">
							<a href="#"><img class="svg" src="{{asset('frontPage/img/svg/message2.svg')}}" alt="" /></a>
						</li>
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
								<img src="{{asset('frontPage/img/contact/1.jpg')}}" alt="" />
							</div>
							<div class="definitions_wrap">
								<h3>Head Office in New-York</h3>
								<p>775 New York Ave, Brooklyn, NY 11203</p>
								<p>Phone: +1 202-415-7234</p>
								<p><span>Email:</span><a href="#">w.constructify@gmail.com</a></p>
							</div>
						</div>
					</div>
					<div class="drop_list message">
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
					</div>
					<div class="drop_list phone">
						<div class="call_wrap">
							<div class="image">
								<img src="{{asset('frontPage/img/estimate/call.png')}}" alt="" />
							</div>
							<h3>Toll Free</h3>
							<p>1-800-987-6543</p>
						</div>
					</div>
					<div class="drop_list clock">
						<div class="working_hours_wrap_short">
							<h3>Working Hours</h3>
							<p class="subtitle">We are happy to meet you during our working hours. Please make an appointment.</p>
							<div class="hour_list">
								<ul>
									<li>
										<span class="left">Monday-Friday:</span>
										<span class="right">9am to 5pm</span>
									</li>
									<li>
										<span class="left">Saturday:</span>
										<span class="right">10am to 3pm</span>
									</li>
									<li>
										<span class="left">Sunday:</span>
										<span class="right">Closed</span>
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
		<div class="glax_tm_hero_header_wrap">
			<div class="slider_total_wrap">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<div class="image_wrap swiper-slide">
							<div class="bg_img" data-img-url="{{asset('frontPage/img/slider/1.jpg')}}"></div>
							<div class="swiper_content">
								<div class="texts_wrap">
									<h3>Inspira Group</h3>
									<p>The foundations and aspirations of our business remain true to those established by our visionary founders, and their innovation and energy continue to be our inspiration. Our passion and entrepreneurial culture will ensure that we deliver for our customers in safety, quality and assurance – today and in the future.</p>
								</div>
								<div class="switches">
									<div class="prev_next">
										<div class="tm_next_button"></div>
										<div class="tm_prev_button"></div>
									</div>
									<div class="swiper-pagination my_swiper_pagination"></div>
								</div>
							</div>
						</div>
						<div class="image_wrap swiper-slide">
							<div class="bg_img" data-img-url="{{asset('frontPage/img/slider/2.jpg')}}"></div>
							<div class="swiper_content">
								<div class="texts_wrap">
									<h3>Dapatkan Rumah Tanpa Riba</h3>
									<p>The foundations and aspirations of our business remain true to those established by our visionary founders, and their innovation and energy continue to be our inspiration. Our passion and entrepreneurial culture will ensure that we deliver for our customers in safety, quality and assurance – today and in the future.</p>
								</div>
								<div class="switches">
									<div class="prev_next">
										<div class="tm_next_button"></div>
										<div class="tm_prev_button"></div>
									</div>
									<div class="swiper-pagination my_swiper_pagination"></div>
								</div>
							</div>
						</div>
						<div class="image_wrap swiper-slide">
							<div class="bg_img" data-img-url="{{asset('frontPage/img/slider/3.jpg')}}"></div>
							<div class="swiper_content">
								<div class="texts_wrap">
									<h3>We are more than industrial company</h3>
									<p>The foundations and aspirations of our business remain true to those established by our visionary founders, and their innovation and energy continue to be our inspiration. Our passion and entrepreneurial culture will ensure that we deliver for our customers in safety, quality and assurance – today and in the future.</p>
								</div>
								<div class="switches">
									<div class="prev_next">
										<div class="tm_next_button"></div>
										<div class="tm_prev_button"></div>
									</div>
									<div class="swiper-pagination my_swiper_pagination"></div>
								</div>
							</div>
						</div>
						<div class="image_wrap swiper-slide">
							<div class="bg_img" data-img-url="{{asset('frontPage/img/slider/4.jpg')}}"></div>
							<div class="swiper_content">
								<div class="texts_wrap">
									<h3>We are more than industrial company</h3>
									<p>The foundations and aspirations of our business remain true to those established by our visionary founders, and their innovation and energy continue to be our inspiration. Our passion and entrepreneurial culture will ensure that we deliver for our customers in safety, quality and assurance – today and in the future.</p>
								</div>
								<div class="switches">
									<div class="prev_next">
										<div class="tm_next_button"></div>
										<div class="tm_prev_button"></div>
									</div>
									<div class="swiper-pagination my_swiper_pagination"></div>
								</div>
							</div>
						</div>
						<div class="image_wrap swiper-slide">
							<div class="bg_img" data-img-url="{{asset('frontPage/img/slider/5.jpg')}}"></div>
							<div class="swiper_content">
								<div class="texts_wrap">
									<h3>We are more than industrial company</h3>
									<p>The foundations and aspirations of our business remain true to those established by our visionary founders, and their innovation and energy continue to be our inspiration. Our passion and entrepreneurial culture will ensure that we deliver for our customers in safety, quality and assurance – today and in the future.</p>
								</div>
								<div class="switches">
									<div class="prev_next">
										<div class="tm_next_button"></div>
										<div class="tm_prev_button"></div>
									</div>
									<div class="swiper-pagination my_swiper_pagination"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="glax_tm_swiper_content">
				<div class="container swiper">
					<div class="swiper_content">
						<div class="texts_wrap">
							<h3>Dapatkan Property Syariah Tanpa Riba</h3>
							<p>The foundations and aspirations of our business remain true to those established by our visionary founders, and their innovation and energy continue to be our inspiration. Our passion and entrepreneurial culture will ensure that we deliver for our customers in safety, quality and assurance – today and in the future.</p>
						</div>
						<div class="switches">
							<div class="prev_next">
								<div class="tm_next_button"></div>
								<div class="tm_prev_button"></div>
							</div>
							<div class="swiper-pagination my_swiper_pagination"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="swiper_overlay"></div>
		</div>
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
							<a class="popup-youtube" href="https://www.youtube.com/watch?v=se4yc09w7Ic"></a>
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
									<img class="svg" src="{{asset('frontPage/img/svg/service-flasks.svg')}}" alt="" />
								</div>
								<div class="title_holder">
									<h3>Basic &amp; Industrial Chemicals</h3>
								</div>
								<div class="description">
									<p>During this phase, we will work to provide a detailed analysis of the project and we will establish project expectations along...</p>
								</div>
								<div class="glax_tm_button_more_wrap">
									<a href="#">
										More Details
										<span class="arrow_wrap">
											<span class="first"><img class="svg" src="{{asset('frontPage/img/svg/arrow-right.svg')}}" alt="" /></span>
											<span class="second"><img class="svg" src="{{asset('frontPage/img/svg/arrow-right.svg')}}" alt="" /></span>
										</span>
									</a>
								</div>
								<a class="service_link" href="service-single.html"></a>
							</div>
						</li>
						<li>
							<div class="inner_list glax_tm_minibox">
								<div class="icon_wrap">
									<img class="svg" src="{{asset('frontPage/img/svg/service-tower.svg')}}" alt="" />
								</div>
								<div class="title_holder">
									<h3>Construction &amp; Engineering</h3>
								</div>
								<div class="description">
									<p>The client retains an architect or engineer to design the project and to prepare the necessary drawings and specifications for...</p>
								</div>
								<div class="glax_tm_button_more_wrap">
									<a href="#">
										More Details
										<span class="arrow_wrap">
											<span class="first"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
											<span class="second"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
										</span>
									</a>
								</div>
								<a class="service_link" href="service-single.html"></a>
							</div>
						</li>
						<li>
							<div class="inner_list glax_tm_minibox">
								<div class="icon_wrap">
									<img class="svg" src="{{asset('frontPage/img/svg/service-transformer.svg')}}" alt="" />
								</div>
								<div class="title_holder">
									<h3>Energy and Commodities Industry</h3>
								</div>
								<div class="description">
									<p>Under a Construction Management contract, the client secures the services of a construction manager to work with the design...</p>
								</div>
								<div class="glax_tm_button_more_wrap">
									<a href="#">
										More Details
										<span class="arrow_wrap">
											<span class="first"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
											<span class="second"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
										</span>
									</a>
								</div>
								<a class="service_link" href="service-single.html"></a>
							</div>
						</li>
						<li>
							<div class="inner_list glax_tm_minibox">
								<div class="icon_wrap">
									<img class="svg" src="{{asset('frontPage/img/svg/service-oil.svg')}}" alt="" />
								</div>
								<div class="title_holder">
									<h3>The Shale Oil &amp; Gas Revolution</h3>
								</div>
								<div class="description">
									<p>In this section, we let clients select a design-build arrangement when they want to work with one contract entity...</p>
								</div>
								<div class="glax_tm_button_more_wrap">
									<a href="#">
										More Details
										<span class="arrow_wrap">
											<span class="first"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
											<span class="second"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
										</span>
									</a>
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
						</div>
						<div class="blog_list">
							<ul>
								<li>
									<div class="inner">
										<div class="image_holder">
											<img src="{{asset('frontPage/img/blog/370x250.jpg')}}" alt="" />
											<div class="main_image" data-img-url="{{asset('frontPage/img/blog/1.jpg')}}"></div>
											<div class="overlay"></div>
											<div class="date_wrap">
												<h3><span>08</span></h3>
												<h5>Aug</h5>
												<h5>2020</h5>
											</div>
											<a class="full_link" href="blog-single.html"></a>
										</div>
										<div class="descriptions_wrap">
											<p class="category">
												<span class="author">By <a href="#">Admin</a></span>
												<span class="city">Di <a href="#">Kampung Tahfidz Al Kausar</a></span>
											</p>
										</div>
										<div class="title_holder">
											<h3><a href="blog-single.html">Peletakan Batu Pertama Kampung Tahfidz Al Kausar</a></h3>
										</div>
										<div class="glax_tm_button_more_wrap">
											<a href="blog-single.html">
												Read More
												<span class="arrow_wrap">
													<span class="first"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
													<span class="second"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
												</span>
											</a>
										</div>
									</div>
								</li>
								<li>
									<div class="inner">
										<div class="image_holder">
											<img src="{{asset('frontPage/img/blog/370x250.jpg')}}" alt="" />
											<div class="main_image" data-img-url="{{asset('frontPage/img/blog/2.jpg')}}"></div>
											<div class="overlay"></div>
											<div class="date_wrap">
												<h3><span>07</span></h3>
												<h5>Aug</h5>
												<h5>2018</h5>
											</div>
											<a class="full_link" href="blog-single.html"></a>
										</div>
										<div class="descriptions_wrap">
											<p class="category">
												<span class="author">By <a href="#">Admin</a></span>
												<span class="city">In <a href="#">Kampung Tahfidz Al Kausar</a></span>
											</p>
										</div>
										<div class="title_holder">
											<h3><a href="blog-single.html">Pembukaan Lahan</a></h3>
										</div>
										<div class="glax_tm_button_more_wrap">
											<a href="blog-single.html">
												Read More
												<span class="arrow_wrap">
													<span class="first"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
													<span class="second"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
												</span>
											</a>
										</div>
									</div>
								</li>
								<li>
									<div class="inner">
										<div class="image_holder">
											<img src="{{asset('frontPage/img/blog/370x250.jpg')}}" alt="" />
											<div class="main_image" data-img-url="{{asset('frontPage/img/blog/3.jpg')}}"></div>
											<div class="overlay"></div>
											<div class="date_wrap">
												<h3><span>06</span></h3>
												<h5>Aug</h5>
												<h5>2018</h5>
											</div>
											<a class="full_link" href="blog-single.html"></a>
										</div>
										<div class="descriptions_wrap">
											<p class="category">
												<span class="author">By <a href="#">Admin</a></span>
												<span class="city">In <a href="#">Kampung Tahfidz Al Kausar</a></span>
											</p>
										</div>
										<div class="title_holder">
											<h3><a href="blog-single.html">Proses Penimbunan Jalan dan Pemasangan Gorong-gorong</a></h3>
										</div>
										<div class="glax_tm_button_more_wrap">
											<a href="blog-single.html">
												Read More
												<span class="arrow_wrap">
													<span class="first"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
													<span class="second"><img class="svg" src="img/svg/arrow-right.svg" alt="" /></span>
												</span>
											</a>
										</div>
									</div>
								</li>
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
								<h3>World's Leading Building Corporation</h3>
							</div>
							<div class="text">
								<p>To further develop our corporate strengths we have established a corporate mandate to maintain strong core values that truly reflect the companys philosophy.</p>
							</div>
							<div class="glax_tm_project_video">
								<span>
									<img class="svg" src="img/svg/play.svg" alt="" />
								</span>
								<a class="project_time" href="#">View Company Promo Video</a>
								<a class="project_video_button popup-youtube" href="https://www.youtube.com/watch?v=se4yc09w7Ic"></a>
							</div>
						</div>
						<div class="ratingbox">
							<div class="rating_wrap">
								<div class="inner_wrap">
									<div class="star">
										<img src="img/rating/rate.png" alt="" />
									</div>
									<div class="number">
										<span>9.7</span>
									</div>
									<div class="title">
										<p>Customer Rating</p>
									</div>
								</div>
							</div>
							<div class="rating_text">
								<div class="inner">
									<span>Full reviews at Trustpilot</span>
								</div>
							</div>
						</div>
						<div class="rightbox">
							<div class="bg_image"></div>
						</div>
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
									<h3>Our Guiding Principles</h3>
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
										<p>World's Leading Industry Corporation</p>
									</div>
									<div class="bottom">
										<div class="number">
											<span>47</span>
										</div>
										<div class="definition">
											<p>Years of experience</p>
										</div>
									</div>
								</div>
								<div class="experience_list">
									<ul>
										<li><span>Unrivalled workmanship</span></li>
										<li><span>Professional and Qualified</span></li>
										<li><span>Competitive prices</span></li>
										<li><span>Performance Measures</span></li>
										<li><span>Environmental Sensitivity</span></li>
										<li><span>Core Placement</span></li>
										<li><span>Communication skills</span></li>
										<li><span>Responsive and Respectful</span></li>
										<li><span>Personalised solutions</span></li>
										<li><span>Functional Objectives</span></li>
										<li><span>Integrated Design</span></li>
										<li><span>Urban Context</span></li>
										<li><span>Critical thinking</span></li>
										<li><span>Problem solving</span></li>
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
<!-- /SCRIPTS -->


</body>
</html>

{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PT Inspira Hasanah Madani</title>
        <link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <img src="{{asset('assets/img/logo-mini.png')}}" alt="">
                <div class="title m-b-md">
                    <span style="font-size:xx-large"> PT. Inspira Hasanah Madani</span>
                </div>
            </div>
        </div>
    </body>
</html> --}}
