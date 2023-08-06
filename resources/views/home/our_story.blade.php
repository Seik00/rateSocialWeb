@extends('home.header')

@section('content')
<style>
	.services-block-fourteen .inner-box{
		height:100%;
	}
	.services-block-three{
		margin-top:50px;
	}
	.call-to-action:before{
		background-color: rgba(0, 0, 0, 0);
	}
	section.call-to-action {
		background-repeat: no-repeat;
		background-size: 100% 50%;
	}
</style>
	<section class="call-to-action" style="background-image:url(/template/Finano/Finano-Placeholder/images/web7.png)">
    
		<div class="auto-container" style="padding:50px 15px;">
			<div class="sec-title-two">
				<h2>{{ __('site.Our Story') }}</h2>
			</div>
			
			
		</div>
	</section>
    
    <section class="services-section-three" style="padding: 50px 0px 110px">
		<div class="auto-container">
			<div class="row clearfix">
			<div class="sec-title-two centered">
				<div class="text">{{ __('site.Our_stroy_1') }}</div>
				<div class="text">{{ __('site.Our_stroy_2') }}</div>
			</div>
				<!-- Services Block -->
				<div class="services-block-three style-two col-lg-6 col-md-6 col-sm-12">
					<div class="inner-box wow fadeIn" data-wow-delay="0ms" data-wow-duration="1500ms">
						<div class="icon-box">
							<span class="icon flaticon-bar-chart"></span>
						</div>
						<h6><a href="#">{{ __('site.Mission') }}</a></h6>
						<div class="text">{{ __('site.Our_stroy_3') }}</div>
					</div>
				</div>
				
				<!-- Services Block -->
				<div class="services-block-three style-two col-lg-6 col-md-6 col-sm-12">
					<div class="inner-box wow fadeIn" data-wow-delay="300ms" data-wow-duration="1500ms">
						<div class="icon-box">
							<span class="icon flaticon-board"></span>
						</div>
						<h6><a href="#">{{ __('site.Vision') }}</a></h6>
						<div class="text">{{ __('site.Our_stroy_4') }}</div>
					</div>
				</div>
				
			</div>
		</div>
	</section>

@stop