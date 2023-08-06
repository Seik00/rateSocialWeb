@extends('home.header')

@section('content')
<style>
	.services-block-fourteen .inner-box{
		height:100%;
	}
</style>
    <section class="call-to-action" style="background-image:url(/template/Finano/Finano-Placeholder/images/background/3.jpg)">
    
		<div class="auto-container" style="padding:50px 15px;">
			<div class="sec-title-two">
				<h2>{{ __('site.Our trusted partner') }}</h2>
			</div>
			
			
		</div>
	</section>
    
    <section class="services-section-nine">
		<div class="auto-container">
			
            
			<!-- Sec Title Two -->
			<div class="sec-title-two centered">
                <div class="image wow jello" data-wow-delay="0ms" data-wow-duration="1500ms">
				<img src="/template/Finano/Finano-Placeholder/images/binaxtion.png" alt="" />
			</div>
				<h2>{{ __('site.About') }} <span>BINAXTION</span></h2>
			</div>
			<div class="sec-title-two centered">
				<h2>{{ __('site.Binaxtion_1') }}<br> {{ __('site.Binaxtion_2') }}</h2>
				<div class="text">{{ __('site.Binaxtion_3') }}</div>
			</div>
			<div class="clearfix">
			
			<div class="sec-title-two centered">
				<h2>{{ __('site.Advantages of Binary Options?') }}</h2>
			</div>
				<div class="row clearfix">

					
					<!-- Services Block Fourteen -->
					<div class="services-block-fourteen col-lg-6 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
							<div class="box-one"></div>
							<div class="box-two"></div>
							<div class="icon-box">
								<span class="icon flaticon-earnings"></span>
							</div>
							<h6>{{ __('site.Trade in any situation/trend') }}</h6>
							<div class="text">{{ __('site.Binaxtion_4') }}</div>
						</div>
					</div>
					
					<!-- Services Block Fourteen -->
					<div class="services-block-fourteen col-lg-6 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms">
							<div class="box-one"></div>
							<div class="box-two"></div>
							<div class="icon-box">
								<span class="icon flaticon-budget-1"></span>
							</div>
							<h6>{{ __('site.Low Entry Point') }}</h6>
							<div class="text">{{ __('site.Binaxtion_5') }}<br/>{{ __('site.Binaxtion_6') }}</div>
						</div>
					</div>
					
					<!-- Services Block Fourteen -->
					<div class="services-block-fourteen col-lg-6 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1500ms">
							<div class="box-one"></div>
							<div class="box-two"></div>
							<div class="icon-box">
								<span class="icon flaticon-target"></span>
							</div>
							<h6>{{ __('site.Controlled Losses, Only Lose What You Trade') }}</h6>
							<div class="text">{{ __('site.Binaxtion_7') }}</div>
						</div>
					</div>
					
					<!-- Services Block Fourteen -->
					<div class="services-block-fourteen col-lg-6 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInUp" data-wow-delay="900ms" data-wow-duration="1500ms">
							<div class="box-one"></div>
							<div class="box-two"></div>
							<div class="icon-box">
								<span class="icon flaticon-car"></span>
							</div>
							<h6>{{ __('site.Simplicity') }}</h6>
							<div class="text">{{ __('site.Binaxtion_8') }}</div>
						</div>
					</div>

				</div>
				
			</div>
		</div>
	</section>

@stop