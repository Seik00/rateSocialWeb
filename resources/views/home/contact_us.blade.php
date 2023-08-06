@extends('home.header')

@section('content')
<style>
	.services-block-fourteen .inner-box{
		height:100%;
	}
	.call-to-action:before{
		background-color: rgba(0, 0, 0, 0);
	}
	section.call-to-action {
		background-repeat: no-repeat;
		background-size: 100% 50%;
	}
	@media screen and (max-width: 600px) {
		section.call-to-action {
		background-repeat: no-repeat;
		background-size: 100% 25%;
	}
	}
</style>
    <section class="call-to-action" style="background-image:url(/template/Finano/Finano-Placeholder/images/web6.png)">
    
		<div class="auto-container" style="padding:50px 15px;">
			<div class="sec-title-two">
				<h2>{{ __('site.Contact us') }}</h2>
			</div>
			
			
		</div>
	</section>
    
    <section class="contact-page-section">
		<div class="auto-container">
			<div class="inner-container">
				<!-- <h2>{{ __('site.Contact_us_1') }} <br> {{ __('site.with') }} <span>{{ __('site.our consultan') }}</span></h2> -->
				<div class="row clearfix">
					
					<!-- Info Column -->
					<div class="info-column col-lg-7 col-md-12 col-sm-12">
						<div class="inner-column">
							<h4 style="font-weight:600">{{ __('site.CONTACT_US_DESC') }}</h4>
							<div class="sec-title-two centered">
								<img src="/template/Finano/Finano-Placeholder/images/system_logo.png" alt="" style="width:400px;margin-top:50px;"/>
							</div>
						</div>
					</div>
					
					<!-- Form Column -->
					<div class="form-column col-lg-5 col-md-12 col-sm-12">
						<div class="inner-column">
							
							<!--Contact Form-->
							<div class="contact-form">
							@if ( Config::get('app.locale') == 'en')
								<div class="sec-title-two centered">
									<img src="/template/Finano/Finano-Placeholder/images/eng_tele.png" alt="" style="width:250px;"/><br/>
									<a href="https://t.me/winatosupport" class="theme-btn btn-style-three">{{ __('site.Contact us') }}</a>
								</div>
							@else
								<div class="sec-title-two centered">
									<img src="/template/Finano/Finano-Placeholder/images/telegram.jpeg" alt="" />
								</div>
								
							@endif
							</div>
							
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>

@stop