<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Insurance2u</title>
	<!-- Stylesheets -->
	<link href="/template/Finano/Finano-Placeholder/css/bootstrap.css" rel="stylesheet">
	<link href="/template/Finano/Finano-Placeholder/css/style.css" rel="stylesheet">
	<link href="/template/Finano/Finano-Placeholder/css/responsive.css" rel="stylesheet">

	<link rel="shortcut icon" href="/assets/web/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/assets/web/favicon.ico" type="image/x-icon">

	<!-- Responsive -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
	<!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
</head>
<!-- <style>
	.main-footer:before{
		background:none;
	}
	.main-footer:after{
		background:none;
	}
</style> -->
<body>

	<div class="page-wrapper">

		<!-- Preloader -->
		<div class="preloader"></div>

		<!-- Main Header-->
		<header class="main-header">

			<!--Header-Upper-->
			<div class="header-upper">
				<div class="auto-container">
					<div class="clearfix">

						<div class="pull-left logo-box">
							<div class="logo"><a href="/"><img src="/template/Finano/Finano-Placeholder/images/system_logo.png" alt="" title="" style="height:90px;width:200px"></a></div>
						</div>

						<div class="nav-outer clearfix">

							<!-- Main Menu -->
							<nav class="main-menu navbar-expand-md">
								<div class="navbar-header">
									<button class="navbar-toggler" type="button" data-toggle="collapse"
										data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
										aria-expanded="false" aria-label="Toggle navigation">
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
								</div>

								<div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
									<ul class="navigation clearfix">

                                        <li><a href="/">{{ __('site.Home') }}</a></li>
										<li class="dropdown"><a href="#">{{ __('site.Trusted Partners') }}</a>
											<ul>
												<li><a href="/home/binaxtion">BINAXTION</a></li>

											</ul>
										</li>
                                        <li><a href="/home/our_story">{{ __('site.Our Story') }}</a></li>

										<li><a href="/home/contact_us">{{ __('site.Contact us') }}</a></li>
										<li><a href="/web/sessions/signIn">{{ __('site.Login') }}</a></li>

										<li class="dropdown"><a href="#">{{ __('site.Language') }}</a>
											<ul>
												<li><a href="/lang/en">{{ __('site.English') }}</a></li>
												<li><a href="/lang/cn">{{ __('site.Chinese') }}</a></li>

											</ul>
										</li>
									</ul>
								</div>

							</nav>

						</div>

					</div>
				</div>
			</div>
			<!--End Header Upper-->

			<!--Sticky Header-->
			<div class="sticky-header">
				<div class="auto-container clearfix">
					<!--Logo-->
					<div class="logo pull-left">
						<a href="/" class="img-responsive"><img src="/template/Finano/Finano-Placeholder/images/system_logo.png" alt=""
								title="" style="height:90px;width:200px"></a>
					</div>

					<!--Right Col-->
					<div class="right-col pull-right">
						<!-- Main Menu -->
						<nav class="main-menu navbar-expand-md">
							<button class="navbar-toggler" type="button" data-toggle="collapse"
								data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1"
								aria-expanded="false" aria-label="Toggle navigation">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>

							<div class="navbar-collapse collapse clearfix" id="navbarSupportedContent1">
								<ul class="navigation clearfix">
									<li><a href="/">{{ __('site.Home') }}</a></li>
									<li class="dropdown"><a href="#">{{ __('site.Trusted Partners') }}</a>
										<ul>
											<li><a href="/home/binaxtion">BINAXTION</a></li>

										</ul>
									</li>
									<li><a href="/home/our_story">{{ __('site.Our Story') }}</a></li>

									<li><a href="/home/contact_us">{{ __('site.Contact us') }}</a></li>
									<li><a href="/web/sessions/signIn">{{ __('site.Login') }}</a></li>
									<li class="dropdown"><a href="#">{{ __('site.Language') }}</a>
										<ul>
											<li><a href="/lang/en">{{ __('site.English') }}</a></li>
											<li><a href="/lang/cn">{{ __('site.Chinese') }}</a></li>

										</ul>
									</li>
								</ul>
							</div>
						</nav><!-- Main Menu End-->
					</div>

				</div>
			</div>
			<!--End Sticky Header-->

		</header>
		<!--End Main Header -->

        @yield('content')

		<!--Main Footer-->
		<footer class="main-footer" >
			<div class="auto-container">
				<!--Widgets Section-->
				<div class="widgets-section">
					<div class="row clearfix">

						<!--Column-->
						<div class="big-column col-lg-6 col-md-12 col-sm-12">
							<div class="row clearfix">

								<!--Footer Column-->
								<div class="footer-column col-lg-7 col-md-6 col-sm-12">
									<div class="footer-widget logo-widget">
										<div class="logo">
											<a href="/"><img src="/template/Finano/Finano-Placeholder/images/footer_logo.png" alt="" style="height:200px;width:200px"/></a>
										</div>

										<!-- <ul class="list-style-two">
											<li><span class="icon fa fa-phone"></span> +123 (4567) 890</li>
											<li><span class="icon fa fa-envelope"></span> info@financ.com</li>
											<li><span class="icon fa fa-home"></span>380 St Kilda Road, Melbourne <br>
												VIC 3004, Australia</li>
										</ul> -->
									</div>
								</div>

								<!--Footer Column-->
								<div class="footer-column col-lg-5 col-md-6 col-sm-12">
									<div class="footer-widget links-widget">
										<h4>Links</h4>
										<ul class="list-link">
											<li><a href="/">{{ __('site.Home') }}</a></li>
											<li><a href="/home/binaxtion">{{ __('site.Trusted Partners') }}</a></li>
											<li><a href="/home/our_story">{{ __('site.Our Story') }}</a></li>
											<li><a href="/home/contact_us">{{ __('site.Contact us') }}</a></li>
											<li><a href="/web/sessions/signIn">{{ __('site.Login') }}</a></li>
										</ul>
									</div>
								</div>

							</div>
						</div>

						<!--Column-->
						<div class="big-column col-lg-6 col-md-12 col-sm-12">
							<div class="row clearfix">

								<div class="footer-column col-lg-6 col-md-6 col-sm-12">
									<!-- <div class="footer-widget links-widget">
									<div class="logo">
											<a href="/"><img src="/template/Finano/Finano-Placeholder/images/footer2.png" alt="" style="height:200px;width:300px"/></a>
										</div>
									</div> -->
								</div>
								<!-- <div class="footer-column col-lg-6 col-md-6 col-sm-12">
									<div class="footer-widget links-widget">
									<div class="logo">
											<a href="/"><img src="/template/Finano/Finano-Placeholder/images/footer2.png" alt="" style="height:200px;width:300px"/></a>
										</div>
									</div>
								</div> -->
							</div>
						</div>

					</div>
				</div>
			</div>
			<!-- Footer Bottom -->
			<div class="footer-bottom">
				<div class="auto-container">
					<div class="row clearfix">

						<!-- Copyright Column -->
						<div class="copyright-column col-lg-6 col-md-6 col-sm-12">
							<div class="copyright" style="color:black;">2022 &copy; All rights reserved by <a href="/" style="color:black;">Insurance2u</a></div>
						</div>

						<!-- Social Column -->
						<!-- <div class="social-column col-lg-6 col-md-6 col-sm-12">
							<ul>
								<li class="follow">Follow us: </li>
								<li><a href="#"><span class="fa fa-facebook-square"></span></a></li>
								<li><a href="#"><span class="fa fa-twitter-square"></span></a></li>
								<li><a href="#"><span class="fa fa-linkedin-square"></span></a></li>
								<li><a href="#"><span class="fa fa-google-plus-square"></span></a></li>
								<li><a href="#"><span class="fa fa-rss-square"></span></a></li>
							</ul>
						</div> -->

					</div>
				</div>
			</div>
		</footer>

	</div>
	<!--End pagewrapper-->


    <script src="/template/Finano/Finano-Placeholder/js/jquery.js"></script>
    <script src="/template/Finano/Finano-Placeholder/js/popper.min.js"></script>
    <script src="/template/Finano/Finano-Placeholder/js/bootstrap.min.js"></script>
    <script src="/template/Finano/Finano-Placeholder/js/sticky.js"></script>

	<script src="/template/Finano/Finano-Placeholder/js/jquery.js"></script>
	<script src="/template/Finano/Finano-Placeholder/js/sticky.js"></script>
	<script src="/template/Finano/Finano-Placeholder/js/popper.min.js"></script>
	<script src="/template/Finano/Finano-Placeholder/js/bootstrap.min.js"></script>
	<script src="/template/Finano/Finano-Placeholder/js/jquery.mCustomScrollbar.concat.min.js"></script>
	<!-- <script src="/template/Finano/Finano-Placeholder/js/jquery.fancybox.js"></script> -->
	<script src="/template/Finano/Finano-Placeholder/js/appear.js"></script>
	<script src="/template/Finano/Finano-Placeholder/js/owl.js"></script>
	<script src="/template/Finano/Finano-Placeholder/js/wow.js"></script>
	<script src="/template/Finano/Finano-Placeholder/js/jquery-ui.js"></script>
	<script src="/template/Finano/Finano-Placeholder/js/main.js"></script>
	<!--Google Map APi Key-->
	<!-- <script src="http://maps.google.com/maps/api/js?key=AIzaSyDTPlX-43R1TpcQUyWjFgiSfL_BiGxslZU"></script> -->
	<!-- <script src="/template/Finano/Finano-Placeholder/js/map-script.js"></script> -->
	<!--End Google Map APi-->

</body>

</html>
