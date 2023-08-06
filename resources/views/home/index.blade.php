<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />

	<!-- Stylesheets
	============================================= -->
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&display=swap" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="/template/insurance2u/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="/template/insurance2u/style.css" type="text/css" />
	<link rel="stylesheet" href="/template/insurance2u/css/swiper.css" type="text/css" />
	<link rel="stylesheet" href="/template/insurance2u/css/dark.css" type="text/css" />
	<link rel="stylesheet" href="/template/insurance2u/css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="/template/insurance2u/css/animate.css" type="text/css" />
	<link rel="stylesheet" href="/template/insurance2u/css/magnific-popup.css" type="text/css" />

	<link rel="stylesheet" href="/template/insurance2u/css/custom.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- Document Title
	============================================= -->
	<title>Insurance2U</title>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		<header id="header" class="full-header transparent-header" data-sticky-class="not-dark">
			<div id="header-wrap">
				<div class="container">
					<div class="header-row">

						<!-- Logo
						============================================= -->
						<div id="logo">
							<a href="/" class="standard-logo"><img src="/template/insurance2u/images/logo.png" alt="Canvas Logo"></a>
							<a href="/" class="retina-logo"><img src="/template/insurance2u/images/logo.png" alt="Canvas Logo"></a>
						</div><!-- #logo end -->

						

						<div id="primary-menu-trigger">
							<svg class="svg-trigger" viewBox="0 0 100 100"><path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path><path d="m 30,50 h 40"></path><path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path></svg>
						</div>

						<!-- Primary Navigation
						============================================= -->
						<nav class="primary-menu">

							<ul class="menu-container">
								<li class="menu-item">
									<a class="menu-link" href="#"><div>{{ __('site.Language') }}</div></a>
									<ul class="sub-menu-container">
										<li class="menu-item">
											<a class="menu-link" href="/lang/en"><div>{{ __('site.English') }}</div></a>
										</li>
										<li class="menu-item">
											<a class="menu-link" href="/lang/cn"><div>{{ __('site.Chinese') }}</div></a>
										</li>
										<li class="menu-item">
											<a class="menu-link" href="/lang/th"><div>{{ __('site.Thailand') }}</div></a>
										</li>
										<li class="menu-item">
											<a class="menu-link" href="/lang/vn"><div>{{ __('site.Vietnam') }}</div></a>
										</li>
										<li class="menu-item">
											<a class="menu-link" href="/lang/kr"><div>{{ __('site.Korea') }}</div></a>
										</li>
									</ul>
								</li>
								<li class="menu-item">
									<li class="menu-item">
										<a class="menu-link" href="https://insurance2u.club/web/sessions/signIn"><div>{{ __('site.Login') }}</div></a>
									</li>
								</li>
								<li class="menu-item">
									<li class="menu-item">
										<a class="menu-link" href="https://insurance2u.club/web/register"><div>{{ __('site.SignUp') }}</div></a>
									</li>
								</li>
							</ul>
						</nav><!-- #primary-menu end -->

						<form class="top-search-form" action="search.html" method="get">
							<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter.." autocomplete="off">
						</form>

					</div>
				</div>
			</div>
			<div class="header-wrap-clone"></div>
		</header><!-- #header end -->

		<section id="slider" class="slider-element slider-parallax swiper_wrapper min-vh-60 min-vh-md-100 include-header">
			<div class="slider-inner">

				<div class="swiper-container swiper-parent">
					<div class="swiper-wrapper">
						<div class="swiper-slide dark">
							<div class="container">
								<div class="slider-caption slider-caption-center">
									<h2 data-animate="fadeInUp">{{ __('site.Welcome to Insurance2U') }}</h2>
									<!-- <p class="d-none d-sm-block" data-animate="fadeInUp" data-delay="200">Create just what you need for your Perfect Website. Choose from a wide range of Elements &amp; simply put them on your own Canvas.</p> -->
								</div>
							</div>
							<div class="swiper-slide-bg" style="background-image: url('/template/insurance2u/images/bg3.jpg');"></div>
						</div>
						
						
					</div>
					<!-- <div class="slider-arrow-left"><i class="icon-angle-left"></i></div>
					<div class="slider-arrow-right"><i class="icon-angle-right"></i></div> -->
				</div>

				<a href="#" data-scrollto="#content" data-offset="100" class="one-page-arrow dark"><i class="icon-angle-down infinite animated fadeInDown"></i></a>

			</div>
		</section>

		<!-- Content
		============================================= -->
		<section id="content">
			<div class="content-wrap">
				<div class="container">
					<div class="row col mb-5">
						<div class="col-lg-12">
							<div class="heading-block center">
								<h2>{{ __('site.PARTICULARS OF THE MODERN INSURANCE') }}</h2>
							</div>
						</div>
					
						<div class="col-lg-4">
							<i class="i-plain color i-large icon-line2-screen-desktop inline-block" style="margin-bottom: 15px;"></i>
							<div class="heading-block border-bottom-0" style="margin-bottom: 15px;">
								<h4>{{ __('site.INVESTMENT') }}</h4>
							</div>
							<p>{{ __('site.Investing wisely in insurance is a great move for your future financial well-being.') }}</p>
						</div>

						<div class="col-lg-4">
							<i class="i-plain color i-large icon-line2-energy inline-block" style="margin-bottom: 15px;"></i>
							<div class="heading-block border-bottom-0" style="margin-bottom: 15px;">
								<h4>{{ __('site.WEALTH PLANNING') }}</h4>
							</div>
							<p>{{ __('site.Making a plan with a professional can help you stay on the right road and avoid making mistakes.') }}</p>
						</div>

						<div class="col-lg-4">
							<i class="i-plain color i-large icon-line2-equalizer inline-block" style="margin-bottom: 15px;"></i>
							<div class="heading-block border-bottom-0" style="margin-bottom: 15px;">
								<h4>{{ __('site.LOSS PREVENTION') }}</h4>
							</div>
							<p>{{ __('site.Unexpected events may occur at any time; thus, avoid thinking about "what ifs" when things do not go as planned.') }}</p>
						</div>

					</div>

				</div>

				<div class="container clearfix">

					<div class="row align-items-center col-mb-50">
						<div class="col-md-4 center">
							<img data-animate="fadeInLeft" src="/template/insurance2u/images/insurance.jpg" alt="Iphone">
						</div>

						<div class="col-md-8 text-center text-md-left">
							<div class="heading-block border-bottom-0">
								<h3>{{ __('site.INSURANCE – A RISK MANAGEMENT TOOL') }}</h3>
							</div>

							<p>{{ __('site.By transferring risks, insurance can offer a blanket of security for people, thereby minimising changes in their financial situation.') }}</p>

							<p>{{ __('site.Because of this, insurance is a crucial risk management strategy. Anyone can have a strong and stable financial future by making a long-term plan for their finances.') }}</p>

							<p>{{ __('site.Whatever stage of life you are in at the moment, there is undoubtedly a suitable insurance plan to meet your needs. With the appropriate insurance coverage, you can manage your financial situation and be ready for unforeseen events.') }}</p>

							<p>{{ __('site.As requirements and wants vary throughout time, insurance patterns also shift. Modern insurance has been developed in this era of technology for the client’s peace of mind when facing uncertainties in the internet world') }}</p>

						</div>
					</div>

				</div>

				<div class="section parallax dark mb-0 py-0" style="background-image: url('/template/insurance2u/images/group.png'); padding: 100px 0;background-size: cover;" data-bottom-top="background-position:0px 300px;" data-top-bottom="background-position:0px -300px;">
					<div style="padding: 100px 0px;background: #0000008c;">
						<div class="heading-block center">
							<h3>{{ __('site.INSURANCE2U GROUP') }}</h3>
						</div>

						<div class="fslider testimonial testimonial-full" data-animation="fade" data-arrows="false">
							<div class="flexslider">
								<div class="slider-wrap">
									<div class="slide">
										<div class="testi-content">
											<p>{{ __('site.As an insurance provider for the entertainment sector, INSURANCE2U GROUP was founded in Hong Kong in 2020.') }}</p>
											<div class="testi-meta">
											{{ __('site.We quickly exceeded a total insured sum of US$50 million thanks to a strong offering and a wealth of industry knowledge.') }}
											</div>
										</div>
									</div>
									<div class="slide">
										<div class="testi-content">
											<p>{{ __('site.WHAT WE SEE') }}</p>
											<div class="testi-meta">
											{{ __('site.being the most respected insurance provider in the entertainment sector and expanding the insurance market.') }}
											</div>
										</div>
									</div>
									<div class="slide">
										<div class="testi-content">
											<p>{{ __('site.OUR PURPOSE') }}</p>
											<div class="testi-meta">
											{{ __('site.committed to developing cutting-edge insurance products with a primary focus on the rapidly developing entertainment industry.') }}
											</div>
										</div>
									</div>
									<div class="slide">
										<div class="testi-content">
											<p>{{ __('site.OUR VIEWS') }}</p>
											<div class="testi-meta">
											{{ __('site.In the end, we want to offer our customers a complete and distinctive portfolio of entertainment insurance.') }}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					

				</div>

				<div class="row clearfix align-items-stretch">

					<div class="col-lg-6 center col-padding" style="background: url('/template/insurance2u/images/services/main-bg.jpg') center center no-repeat; background-size: cover;">
					</div>

					<div class="col-lg-6 col-padding" style="background-color: #F5F5F5;">
						<div class="heading-block border-bottom-0">
							<h3>{{ __('site.THE INSURANCE2U GROUP’S INTRODUCTION') }}</h3>
						</div>

						<p class="lead mb-0">{{ __('site.We have extensive experience managing businesses, including business development, finance, the actuarial department, as well as regular business operations. We are originally from other significant entertainment industries.') }}</p>

						<p class="lead mb-0 mt-4">{{ __('site.We initially began with a straightforward insurance programme that offered protection for the baccarat game, but later broadened our coverages to include other forms of entertainment like horse racing and sports betting.') }}</p>
						
						<p class="lead mb-0 mt-4" style="text-align:left!important;">{{ __('site.Hong Kong, 2022') }} <br/> {{ __('site.THE INSURANCE2U GROUP’S INTRODUCTION') }}</p>
					</div>

				</div>

				<div class="container clearfix">

					<div class="row col-mb-50 mt-6">
						<div class="col-lg-12">
							<div class="heading-block center">
								<h2>{{ __('site.WHY CHOOSE US?') }}</h2>
								<span class="mx-auto">{{ __('site.We offer unique insurance protection for the entertainment industry. We create our products with players in mind. As a result, we are aware of your desire to reduce risks and raise the likelihood of an upside profit.') }}</span>
							</div>
						</div>
						
						<div class="col-sm-6 col-lg-4">
							<div class="feature-box fbox-center fbox-effect border-bottom-0" data-animate="fadeIn">
								<div class="fbox-icon">
									<a href="#"><i class="icon-phone2"></i></a>
								</div>
								<div class="fbox-content">
									<h3>{{ __('site.Unique Design') }}</h3>
								</div>
							</div>
						</div>

						<div class="col-sm-6 col-lg-4">
							<div class="feature-box fbox-center fbox-effect border-bottom-0" data-animate="fadeIn">
								<div class="fbox-icon">
									<a href="#"><i class="icon-eye"></i></a>
								</div>
								<div class="fbox-content">
									<h3>{{ __('site.Cover all of your wagers') }}</h3>
								</div>
							</div>
						</div>

						<div class="col-sm-6 col-lg-4">
							<div class="feature-box fbox-center fbox-effect border-bottom-0" data-animate="fadeIn">
								<div class="fbox-icon">
									<a href="#"><i class="icon-star2"></i></a>
								</div>
								<div class="fbox-content">
									<h3>{{ __('site.Generate outstanding income') }}</h3>
								</div>
							</div>
						</div>

						<div class="col-lg-12">
							<div class="heading-block center">
								<span class="mx-auto">{{ __('site.By selecting Insurance2u Group as your protector, we will right away offer a special yet straightforward strategy to produce sizable money while fully protecting your bets!') }}</span>
							</div>
						</div>
					</div>
				</div>

				<section id="content">
					<div class="content-wrap">
						<div class="container clearfix">
							
							<div class="accordion accordion-bg">

								<div class="accordion-header">
									<div class="accordion-icon">
										<i class="accordion-closed icon-ok-circle"></i>
										<i class="accordion-open icon-remove-circle"></i>
									</div>
									<div class="accordion-title">
									{{ __('site.PREMIER SERIES by Insurance2U') }}
									</div>
								</div>
								<div class="accordion-content">
										{{ __('site.1. As a result of the pandemic, many people have been forced to live in protracted seclusion, which has led to an increase in online user hours, user activity, and many other factors.') }}<br/>
										{{ __('site.2. A few users claimed that they "don’t often play games, but have started doing so as a result of the extended isolation caused by the pandemic."') }}<br/>
										{{ __('site.3. This demonstrates that there are still a lot of prospective players out there, and the majority of them will stick around long after the pandemic is finished.') }}
									
								</div>

								<div class="accordion-header">
									<div class="accordion-icon">
										<i class="accordion-closed icon-ok-circle"></i>
										<i class="accordion-open icon-remove-circle"></i>
									</div>
									<div class="accordion-title">
									{{ __('site.THE REASON FOR THE NEED FOR INSURANCE SECURITY') }}
									</div>
								</div>
								<div class="accordion-content">
										{{ __('site.Many businesses have shifted to operating online as a result of the rising demand for this service, including the gaming entertainment industry.') }}
								</div>

								<div class="accordion-header">
									<div class="accordion-icon">
										<i class="accordion-closed icon-ok-circle"></i>
										<i class="accordion-open icon-remove-circle"></i>
									</div>
									<div class="accordion-title">
									{{ __('site.PREMIER SERIES OF Insurance2U: A PLAN CREATED FOR YOU') }}
									</div>
								</div>
								<div class="accordion-content">{{ __('site.We are aware of the risks and have developed a specific insurance package to give them peace of mind while playing games and maximising their platform earnings.') }}
								</div>
								<div class="accordion-header">
									<div class="accordion-icon">
										<i class="accordion-closed icon-ok-circle"></i>
										<i class="accordion-open icon-remove-circle"></i>
									</div>
									<div class="accordion-title">
									{{ __('site.KICKSTART YOUR CAREER AS AN Insurance2U AGENT') }}
									</div>
								</div>
								<div class="accordion-content">
										{{ __('site.a chance to control your own career in a large industry') }}
								</div>
								
								<div class="accordion-header">
									<div class="accordion-icon">
										<i class="accordion-closed icon-ok-circle"></i>
										<i class="accordion-open icon-remove-circle"></i>
									</div>
									<div class="accordion-title">
									{{ __('site.PREMIER SERIES OF Insurance2U: A PLAN CREATED FOR YOU') }}
									</div>
								</div>
								<div class="accordion-content">{{ __('site.We are aware of the risks and have developed a specific insurance package to give them peace of mind while playing games and maximising their platform earnings.') }}
								</div>
								<div class="accordion-header">
									<div class="accordion-icon">
										<i class="accordion-closed icon-ok-circle"></i>
										<i class="accordion-open icon-remove-circle"></i>
									</div>
									<div class="accordion-title">
									{{ __('site.JOIN US TO UNDERSTAND YOUR POTENTIAL.') }}
									</div>
								</div>
								<div class="accordion-content">
										{{ __('site.Being an Insurance2U agent offers you the chance to make a significant contribution to your community, as well as the financial stability and personal fulfilment you’ve always desired.') }}
								</div>
								
							</div>
						</div>
					</div>
				</section><!-- #content end -->
				<div class="container">
					<div class="line"></div>

					<div class="row align-items-center col-mb-50">
						<div class="col-md-5 order-md-last">
							<img src="/template/insurance2u/images/disclaimer.jpg">
						</div>

						<div class="col-md-7 text-center text-md-center">
							<div class="heading-block border-bottom-0">
								<h4>{{ __('site.DISCLAIMER OF FAITH') }}</h4><br/>
								
								<span>{{ __('site.COMMITMENT TO FAST CLAIM SETTLEMENT;') }}</span>
								<span>{{ __('site.RISING ENTERTAINMENT TREND;') }}</span>
								<span>{{ __('site.STRONG BUSINESS SUPPORT SYSTEM;') }}</span>
								<span>{{ __('site.FAST GROWING GAMING COMMUNITY') }}</span>
							</div>

							<p>{{ __('site.As an agent with Insurance2U Group, you can rely on us to help you succeed. We equip our agents with the necessary information and resources so they can manage their careers and keep their profits under control.') }}</p>

							<p>{{ __('site.Join the Insurance2U family to become a part of the international brand that has insured more than $50 Million in a short period of time!') }}</p>

							<p>{{ __('site.When it comes to money and job happiness, an Insurance2U agent has a lot of potential, but it doesn’t end there! Agents with Insurance2U are recognised with benefits and remuneration for reaching sales milestones as well as with awards.') }}</p>

						</div>
					</div>
				</div>

				<div class="section">
					<div class="container">

						<div class="row col-mb-50">

							<div class="col-md-3">
								<div class="feature-box fbox-plain">
									<div class="fbox-icon">
										<a href="#"><i class="i-alt">1.</i></a>
									</div>
									<div class="fbox-content">
										<h3>{{ __('site.TRAINING') }}</h3>
										<p>{{ __('site.Organized learning about a company’s goods and services, facilitated by knowledgeable trainers.') }}</p>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="feature-box fbox-plain">
									<div class="fbox-icon">
										<a href="#"><i class="i-alt">2.</i></a>
									</div>
									<div class="fbox-content">
										<h3>{{ __('site.TECHNOLOGY') }}</h3>
										<p>{{ __('site.a cutting-edge portal that offers updates, point-of-sale functionality, and other regular applications.') }}</p>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="feature-box fbox-plain">
									<div class="fbox-icon">
										<a href="#"><i class="i-alt">3.</i></a>
									</div>
									<div class="fbox-content">
										<h3>{{ __('site.TOOLS') }}</h3>
										<p>{{ __('site.Agents will be given multilingual sales materials for an effective sales pitch.') }}</p>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="feature-box fbox-plain">
									<div class="fbox-icon">
										<a href="#"><i class="i-alt">4.</i></a>
									</div>
									<div class="fbox-content">
										<h3>{{ __('site.REWARDS') }}</h3>
										<p>{{ __('site.Once Insurance2U agents reach certain milestones, they will receive exclusive rewards.') }}</p>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

			</div>
		</section><!-- #content end -->

		<!-- Footer
		============================================= -->
		<footer id="footer" class="dark">
			

			<!-- Copyrights
			============================================= -->
			<div id="copyrights">
				<div class="container">

					<div class="row col-mb-30">

						<div class="col-md-6 text-center text-md-left">
							Copyrights &copy; 2020 All Rights Reserved by Insurance2U.<br>
						</div>

						<div class="col-md-6 text-center text-md-right">
							<div class="d-flex justify-content-center justify-content-md-end">
								
							</div>

							<div class="clear"></div>

							
						</div>

					</div>

				</div>
			</div><!-- #copyrights end -->
		</footer><!-- #footer end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- JavaScripts
	============================================= -->
	<script src="/template/insurance2u/js/jquery.js"></script>
	<script src="/template/insurance2u/js/plugins.min.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script src="/template/insurance2u/js/functions.js"></script>

</body>
</html>