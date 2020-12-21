<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" /> 
  <title>Calssimax</title>
  
  <!-- PLUGINS CSS STYLE -->
  <!-- <link href="{{ asset('user/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet"> -->
  <!-- Bootstrap -->
  <link href="{{ asset('user/plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset('user/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- Owl Carousel -->
  <link href="{{ asset('user/plugins/slick-carousel/slick/slick.css') }}" rel="stylesheet">
  <link href="{{ asset('user/plugins/slick-carousel/slick/slick-theme.css') }}" rel="stylesheet">
  <!-- Fancy Box -->
  <link href="{{ asset('user/plugins/fancybox/jquery.fancybox.pack.css') }}" rel="stylesheet">
  <link href="{{ asset('user/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
  <link href="{{ asset('user/plugins/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css') }}" rel="stylesheet">
  <!-- CUSTOM CSS -->
  <link href="{{ asset('user/css/style.css') }}" rel="stylesheet">

  <!-- FAVICON -->
  <link href="{{ asset('user/img/favicon.png') }}" rel="shortcut icon">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body class="body-wrapper">

<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar navbar-expand-lg  navigation">
					<a class="navbar-brand" href="index.html">
						<!-- <img src="images/logo.png" alt=""> -->
					</a>
				</nav>
			</div>
		</div>
	</div>
</section>
  @if(session()->has('success'))
		<div id="error" class="alert alert-dismissable alert-success">
			<strong>
				{!! session()->get('success') !!}
			</strong>
		</div>
	@endif
	@if (session()->has('error'))
		<div id="error" class="alert alert-dismissable alert-danger">
			<strong>
				{!! session()->get('error') !!}
			</strong>
		</div>
	@endif
	@if (count($errors->all()))
		<div  id="error" class="alert alert-dismissable alert-danger">
			@foreach ($errors->all() as $error)
				<li><strong>{!! $error !!}</strong></li>
			@endforeach
		</div>
	@endif
<section class="dashboard section" style="padding-top:0px">
	<!-- Container Start -->
	<div class="container">
		<!-- Row Start -->
		<div class="row">
			<div class="col-md-10 offset-md-1 col-lg-4 offset-lg-0">
				<div class="sidebar">
					<!-- User Widget -->
					<div class="widget user-dashboard-profile">
						<!-- User Image -->
						<div class="profile-thumb">
							<img src="{{ route('image_show',$user->image) }}" alt="" style="width:120px; height:120px;border:1px solid #fff ; border-radius:50%">
						</div>
						<!-- User Name -->
						<h5 class="text-center">{{ $user->name }}</h5>
						<p>Joined 
						{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('M d , Y')}}
						</p>
						<a class="nav-link add-button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-2').submit();"><i class="fa fa-power-off"></i> log out</a>
						<form id="logout-form-2" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
						<a class="nav-link add-button" href="{{ route('indexeco') }}"><i class="fa fa-plus-circle"></i> Go website</a>
					</div>
					<!-- Dashboard Links -->
					<div class="widget user-dashboard-menu">
						<ul>
							<?php    
								$count_cart =0 ;
								foreach(auth()->user()->carts as $key => $cart){
									if(!empty( $cart->product )){
										$count_cart += 1 ;
									}
								}
								$count_favourite = 0 ;
								if(!empty(session()->get('favourite'))){
									foreach(session()->get('favourite') as $id => $details){
										if(!empty(\App\Product::find($details['id']))){
											$count_favourite += 1 ;
										}
									}
								}
							
							?>
							<li class="{{ $active =='profile_user' ? 'active' : '' }} " ><a href="{{ route('profile_user') }}"><i class="fa fa-user"></i> تعديل البروفايل</a></li>
							<li class="{{ $active =='cart' ? 'active' : '' }} " ><a href="{{ route('cart_profile_user') }}"><i class="fa fa-user"></i> My Cart<span>{{ $count_cart }}</span></a></li>
							<li class="{{ $active =='favourite' ? 'active' : '' }} " ><a href="{{ route('favourite_profile_user') }}"><i class="fa fa-bookmark-o"></i>My Favourite <span>{{ $count_favourite }}</span></a></li>
							<!-- <li><a href=""><i class="fa fa-file-archive-o"></i>Archived Ads <span>12</span></a></li> -->
							<!-- <li><a href=""><i class="fa fa-bolt"></i> Pending Approval<span>23</span></a></li> -->
							<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-2').submit();"><i class="fa fa-cog"></i> Logout</a></li>
							<form id="logout-form-2" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
							<!-- <li><a href=""><i class="fa fa-power-off"></i>Delete Account</a></li> -->
						</ul>
					</div>
				</div>
			</div>

@yield('content')

		</div>
		<!-- Row End -->
	</div>
	<!-- Container End -->
</section>




  <!-- JAVASCRIPTS -->
  <!-- <script src="{{ asset('user/plugins/jquery/jquery.min.js') }}"></script> -->
  <!-- <script src="{{ asset('user/plugins/jquery-ui/jquery-ui.min.js') }}"></script> -->
  <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
  <script src="{{ asset('user/plugins/tether/js/tether.min.js') }}"></script>
  <script src="{{ asset('user/plugins/raty/jquery.raty-fa.js') }}"></script>
  <script src="{{ asset('user/plugins/bootstrap/dist/js/popper.min.js') }}"></script>
  <script src="{{ asset('user/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('user/plugins/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js') }}"></script>
  <script src="{{ asset('user/plugins/slick-carousel/slick/slick.min.js') }}"></script>
  <script src="{{ asset('user/plugins/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
  <script src="{{ asset('user/plugins/fancybox/jquery.fancybox.pack.js') }}"></script>
  <script src="{{ asset('user/plugins/smoothscroll/SmoothScroll.min.js') }}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
  <script src="{{ asset('user/js/scripts.js') }}"></script>

  @yield('js')

</body>

</html>