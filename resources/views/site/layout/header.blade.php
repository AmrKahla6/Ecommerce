<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>e-commerce</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('front/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <meta property="og:image:width" content="200">
	<meta property="og:image:height" content="200">

    <meta property="og:url" content="@hasSection('og_url') @yield('og_url') @endif" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="@hasSection('og_title')@yield('og_title') @endif" />
	<meta property="og:description" content="@hasSection('og_description') @yield('og_description') @endif" />
	<meta property="og:image" content="@hasSection('og_image') @yield('og_image') @endif" />
	<meta property="fb:app_id" content="494371674832728" />

    <meta name="twitter:card" content="@hasSection('og_description') @yield('og_description') @endif" />
	<meta name="twitter:site" content="@abdelha09717367" />
    <meta name="twitter:creator" content="@abdelha09717367" />
    <meta name="twitter:title" content="abdelha09717367" />
    <meta name="twitter:description" content="lmlmlmlmljmojojojojojojojojjojojoabdelha09717367" />
    
    <link
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
      rel="stylesheet"
      type="text/css"
    />

	<!-- Bootstrap Fremwork Main Css -->
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}">
    <!-- All Plugins css -->
    <link rel="stylesheet" href="{{ asset('front/css/plugins.css') }}">
    <!-- Theme shortcodes/elements style -->

    <!-- Theme main style -->
    @if(App::getLocale() == 'en')
    <link rel="stylesheet" href="{{ asset('front/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/shortcode/shortcodes.css') }}">
    <!-- Responsive css -->
    <link rel="stylesheet" href="{{ asset('front/css/responsive.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('front/style_ar.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/shortcode/shortcodes_ar.css') }}">
    <!-- Responsive css -->
    <link rel="stylesheet" href="{{ asset('front/css/responsive_ar.css') }}">
    @endif

    <!-- User style -->
    <link rel="stylesheet" href="{{ asset('front/css/custom.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">


    <!-- Modernizr JS -->
    <script src="{{ asset('front/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Body main wrapper start -->
    <div class="wrappe fixed__foote"style="margin-bottom:10px">
        <!-- Start Header Style -->
        <header id="header" class="htc-header header--3 bg__white">
            <!-- Start Mainmenu Area -->
            <div id="sticky-header-with-topbar" class="mainmenu__area sticky__header">
                <div class="container">
                    <div class="row">
                        @if(App::getLocale() == 'ar')
                        <div class="col-sm-3 col-md-4 col-lg-1 col-2">
                            <div class="logo">
                                <a href="{{ route('indexeco') }}">
                                    <img id="image_width" src="{{ asset('logo.jpg') }}" alt="logo">
                                </a>
                            </div>
                        </div>
                        @else
                        <div class="col-md-7 col-lg-3 col-10">
                            <ul class="menu-extra">
                            @foreach(LaravelLocalization::getSupportedLocales(true) as $localeCode => $properties)
                                    @if($localeCode != App::getLocale())
                                    <li class=" d-md-block"><span><a  rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="cool-link ">
                                        <img style="width:35px; height:17px" src="@if(App::getLocale() == 'en') {{ asset('front/images/language/ar.jpg') }} @else {{ asset('front/images/language/en.png') }} @endif" alt="lang">
                                     </a> </span><span style="color:#ff4136;font-size:12px;position: absolute;top:-55px"></span></li>
									@endif
                                @endforeach
                                <li class="cart__menu"><span class="ti-shopping-cart"></span><span id="count_of_cart" style="color:#ff4136;font-size:12px;position: absolute;top:-15px"></span></li>
                                <li class="toggle__menu d-none d-md-block"><span class="ti-heart"></span><span id="count_of_cart" style="color:#ff4136;font-size:12px;position: absolute;top:-55px"></span></li>
                                <li class="search search__open d-sm-block"><span class="ti-search"></span></li>
                            </ul>
                        </div>
                        @endif
                        <!-- Start MAinmenu Ares -->
                        <div class="col-md-1 col-lg-8 d-none d-md-block">
                            <nav class="mainmenu__nav  d-none d-lg-block">
                                <ul class="main__menu">
                                @if(App::getLocale() == 'en')
                                    <li class="drop"><a href="{{ route('indexeco') }}">{{trans('header.Home')}}</a>
                                    </li>
                                    <li><a href="{{route('about_index') }}">{{trans('header.About')}}</a></li>
                                    <li class="drop"><a href="{{route('blogs') }}">{{trans('header.Blog')}}</a>
                                    </li>
                                    <!-- <li class="drop"><a href="{{ route('all_product') }}"></a>
                                    </li> -->
                                    <li class="drop"><a href="#">{{trans('header.Shop')}}</a>
                                        <ul class="dropdown">
                                        @foreach(\App\Category::all() as $category)
                                            <li><a href="{{ route('all_products',$category->id) }}">{{$category->name}}</a></li>
                                        @endforeach
                                        </ul>
                                    </li>
                                    <li><a href="{{route('contact') }}">{{trans('header.contact')}}</a></li>
                                    @if(!Auth()->check())
                                    <li><a href="{{(route('login') )}}">{{trans('header.Login')}}</a></li>
                                    @endif
                                    @if(Auth()->check())
                                    <li class="drop"><a href="#">{{trans('header.account')}}</a>
                                        <ul class="dropdown">
                                            <li><a href="{{ route('profile_user') }}">{{trans('header.my profile')}}</a></li>
                                            <li><a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{trans('header.logout')}}</a></li>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </ul>
                                    </li>
                                    @endif
                                    @if(Auth()->check())
                                        @if(Auth::user()->can(['index_*', 'view_*', 'edit_*', 'create_*', 'delete_*']))
                                        <li>
                                            <a href="{{ route('dashboard') }}">{{trans('header.Dashboard')}}</a>
                                        </li>
                                        @endif
                                    @endif
                                @else
                                    @if(Auth()->check())
                                        @if(Auth::user()->can(['index_*', 'view_*', 'edit_*', 'create_*', 'delete_*']))
                                        <li>
                                            <a href="{{ route('dashboard') }}">{{trans('header.Dashboard')}}</a>
                                        </li>
                                        @endif
                                    @endif
                                    @if(!Auth()->check())
                                    <li><a href="{{(route('login') )}}">{{trans('header.Login')}}</a></li>
                                    @endif
                                    @if(Auth()->check())
                                    <li class="drop"><a href="#">{{trans('header.account')}}</a>
                                        <ul class="dropdown">
                                            <li><a href="{{ route('profile_user') }}">{{trans('header.my profile')}}</a></li>
                                            <li><a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{trans('header.logout')}}</a></li>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </ul>
                                    </li>
                                    @endif
                                    <li><a href="{{route('contact') }}">{{trans('header.contact')}}</a></li>
                                    <li class="drop"><a href="#">{{trans('header.Shop')}}</a>
                                        <ul class="dropdown">
                                        @foreach(\App\Category::all() as $category)
                                            <li><a href="{{ route('all_products',$category->id) }}">{{$category->name}}</a></li>
                                        @endforeach
                                        </ul>
                                    </li>
                                    <li class="drop"><a href="{{route('blogs') }}">{{trans('header.Blog')}}</a>
                                    </li>
                                    <li><a href="{{route('about_index') }}">{{trans('header.About')}}</a></li>
                                    <li class="drop"><a href="{{ route('indexeco') }}">{{trans('header.Home')}}</a>
                                    </li>
                                @endif
                                </ul>
                            </nav>

                            <div class="mobile-menu clearfix d-block d-lg-none">
                                <nav id="mobile_dropdown">
                                    <ul>
                                        <li><a href="{{ route('indexeco') }}">{{trans('header.Home')}}</a></li>
                                        <li><a href="{{route('about_index') }}">{{trans('header.About')}}</a></li>
                                        <li><a href="{{route('blogs') }}">{{trans('header.Blog')}}</a>

                                        </li>
                                        <li><a href="#">{{trans('header.Shop')}}</a>
                                            <ul>
                                                @foreach(\App\Category::all() as $category)
                                                <li><a href="{{ route('all_products',$category->id) }}">{{$category->name}}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li><a href="{{route('contact') }}">{{trans('header.contact')}}</a></li>
                                        @if(!Auth()->check())
                                        <li><a href="{{(route('login') )}}">{{trans('header.Login')}}</a></li>
                                        @endif
                                        @if(Auth()->check())
                                        <li><a href="#">{{trans('header.account')}}</a>
                                            <ul>
                                                <li><a href="{{ route('profile_user') }}">{{trans('header.my profile')}}</a></li>
                                                <li><a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >{{trans('header.logout')}}</a></li>
                                            	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </ul>
                                        </li>
                                        @endif
                                        @if(Auth()->check())
                                            @if(Auth::user()->can(['index_*', 'view_*', 'edit_*', 'create_*', 'delete_*']))
                                            <li>
                                                <a href="{{ route('dashboard') }}">{{trans('header.Dashboard')}}</a>
                                            </li>
                                            @endif
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <!-- End MAinmenu Ares -->
                        @if(App::getLocale() == 'ar')
                        <div class="col-md-7 col-lg-3 col-10">
                            <ul class="menu-extra">
                                <li class="search search__open d-sm-block"><span class="ti-search"></span></li>
                                <li class="toggle__menu d-none d-md-block"><span class="ti-heart"></span><span id="count_of_cart" style="color:#ff4136;font-size:12px;position: absolute;top:-55px"></span></li>
                                <li class="cart__menu"><span class="ti-shopping-cart"></span><span id="count_of_cart" style="color:#ff4136;font-size:12px;position: absolute;top:-15px"></span></li>
                                @foreach(LaravelLocalization::getSupportedLocales(true) as $localeCode => $properties)
                                    @if($localeCode != App::getLocale())
                                    <li class=" d-md-block"><span><a  rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="cool-link ">
                                        <img style="width:35px; height:17px" src="@if(App::getLocale() == 'en') {{ asset('front/images/language/ar.jpg') }} @else {{ asset('front/images/language/en.png') }} @endif" alt="lang">
                                     </a> </span><span style="color:#ff4136;font-size:12px;position: absolute;top:-55px"></span></li>
									@endif
								@endforeach
                            </ul>
                        </div>
                        @else
                        <div class="col-md-4 col-lg-1 col-2">
                            <div class="logo">
                                <a href="{{ route('indexeco') }}">
                                    <img src="{{ asset('logo.jpg') }}" alt="logo">
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="mobile-menu-area"></div>
                </div>
            </div>
            <!-- End Mainmenu Area -->
        </header>
        <!-- End Header Style -->

        <div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Start Search Popap -->
            <div class="search__area">
                <div class="container" >
                    <div class="row" >
                        <div class="col-md-12" >
                            <div class="search__inner">
                                <form action="{{ route('all_products') }}" method="get">
                                    <input value="{{ request('search') ? request('search') : '' }}"  placeholder="{{trans('header.Search here')}} " type="text" name="search">
                                    <button type="submit"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Search Popap -->

            <!-- heart popup -->
            <?php
                session('favourite') ? $favourite=true : $favourite=false ;
                $count_favourite = 0 ;
                if(!empty(session()->get('favourite'))){
                    foreach(session()->get('favourite') as $id => $details){
                        if(!empty(\App\Product::find($details['id']))){
                            $count_favourite += 1 ;
                        }
                    }
                }
            ?>
            <div id="none_data_favourite" style= "display:{{ $count_favourite == 0 ? '' : 'none' }}" class="offsetmenu">
                <div class="offsetmenu__inner">
                    <div  class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="section__title section__title--2 text-center" style="padding-top:80px;">
                                    <img style="width:160px;width:160px;border:0px solid #000;border-radius: 50%;" src="{{ asset('empty_2.jpg') }}" alt="product img" /></a>
                                </div>
                                <div class="section__title section__title--2 text-center">
                                    <h4 class="title__line" style="color:#c5c5c5;padding-top:20px">{{trans('cart.oops')}}</h4>
                                </div>
                                <div class="section__title section__title--2 text-center">
                                <h4 class="title__line" style="padding-top:20px">{{trans('cart.Empty Favourite')}}</h4>
                                </div>
                                <div class="row mt--60">
                                    <div class="col-md-12">
                                        <div class="htc__loadmore__btn">
                                            <a href="{{ route('indexeco') }}" style="font-size: 20px;">{{trans('cart.Go Home')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>

            <div style= "display:{{ $count_favourite == 0 ? 'none' : '' }}"  id="data_favourite" class="offsetmenu">
                <div class="offsetmenu__inner">
                    <div  class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                  <div style="margin-top:50px" > </div>
                    <div id="shp__cart__wrap" class="shp__cart__wrap">
                    @if(session('favourite'))
                        @foreach(session('favourite') as $id => $details)
                        @if(!empty(\App\Product::find($details['id'])))
                        <div id="favourite_{{ $details['id'] }}" class="shp__single__product">
                            <div class="shp__pro__thumb">
                                <a href="#">
                                    <img src="{{ $details['photo'] }}" alt="product images">
                                </a>
                            </div>
                            <div class="shp__pro__details">
                                <h2><a href="product-details.html">{{ $details['name'] }}</a></h2>
                                <span class="shp__price">${{ $details['price'] }}</span>
                            </div>
                            <div data-id="{{ $details['id'] }}" class="remove__btn remove__btn_favourite">
                                <a href="#" title="Remove this item"><i class="zmdi zmdi-close"></i></a>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    @endif
                    </div>
                    <ul class="shopping__btn">
                        <li class="shp__checkout"><a href="{{ route('favourite') }}">{{trans('header.View Favourite')}}</a></li>
                    </ul>


                </div>
            </div>
            <!-- End Offset MEnu -->
            <?php
            if(auth()->check()){
                $count_cart =0 ;
                foreach(auth()->user()->carts as $key => $cart){
                    if(!empty( $cart->product )){
                        $count_cart += 1 ;
                    }
                }
            }else{
                $count_cart = 0 ;
                if(!empty(session()->get('cart'))){
                    foreach(session()->get('cart') as $id => $details){
                        if(!empty(\App\Product::find($details['id']))){
                            $count_cart += 1 ;
                        }
                    }
                }
            }
            ?>
            <div style= "display:{{ $count_cart == 0 ? '' : 'none' }}"  id="none_data_cart" class="shopping__cart">
                <div class="shopping__cart__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="shp__cart__wrap">
                        <div class="offsetmenu__inner">
                            <div  class="offsetmenu__close__btn">
                                <a href="#"><i class="zmdi zmdi-close"></i></a>
                            </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section__title section__title--2 text-center">
                                            <img src="{{ asset('empty.png') }}" alt="product img" />
                                        </div>
                                        <div class="section__title section__title--2 text-center">
                                            <h4 class="title__line" style="color:#c5c5c5;padding-top:20px">{{trans('cart.oops')}}</h4>
                                        </div>
                                        <div class="section__title section__title--2 text-center">
                                        <h4 class="title__line" style="padding-top:20px">{{trans('cart.Empty Cart')}}</h4>
                                        </div>
                                        <div class="row mt--60">
                                            <div class="col-md-12">
                                                <div class="htc__loadmore__btn">
                                                    <a href="#" style="font-size: 20px;">{{trans('cart.Go Home')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Cart Panel -->
            <div style= "display:{{ $count_cart == 0 ? 'none' : '' }}"  id="data_cart" class="shopping__cart">
                <div class="shopping__cart__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="shp__cart__wrap_2">
                    <?php $total_price_cart = 0; ?>
                    @if(auth()->check())
                        @if(count(App\Cart::where('user_id',auth()->user()->id)->get() ))
                            @foreach(App\Cart::where('user_id',auth()->user()->id)->get() as $cart)
                            @if(!empty($cart->product))
                                <?php
                                    $total_price_cart += $cart->total_of_price_product;
                                    $product = $cart->product;
                                ?>
                                <div class="shp__single__product">
                                    <div class="shp__pro__thumb">
                                        <a href="#">
                                        <img src="{{ route('image_show',\App\Product::find($cart->product_id)->image) }}" alt="product images">
                                        </a>
                                    </div>
                                    <div class="shp__pro__details">
                                        <h2><a href="">{{ \App\Product::find($cart->product_id)->name }}</a></h2>
                                        <span id="quantity_{{ $cart->product_id }}" class="quantity">{{ $cart->quantity_of_product }}</span>
                                        <span id="price_{{ $cart->product_id }}" class="shp__price">{{ $cart->total_of_price_product }}</span>
                                    </div>
                                    <div class="remove__btn">
                                        <a href="#" title="Remove this item"><i class="zmdi zmdi-close"></i></a>
                                    </div>
                                </div>
                            @endif
                            @endforeach
                        @endif
                    @else
                        @if(session('cart'))

                            @foreach(session('cart') as $id => $details)
                                <div class="shp__single__product">
                                    <div class="shp__pro__thumb">
                                        <a href="#">
                                            <img src="{{ $details['photo'] }}" alt="product images">
                                        </a>
                                    </div>
                                    <div class="shp__pro__details">
                                        <h2><a href="product-details.html">{{ $details['name'] }}</a></h2>
                                        <span id="quantity_{{ $details['id'] }}" class="quantity">{{ $details['quantity_of_product'] }}</span>
                                        <span id="price_{{ $details['id'] }}" class="shp__price">{{ $details['total_of_price_product'] }}</span>
                                        <?php $total_price_cart += $details['total_of_price_product']; ?>
                                    </div>
                                    <div data-id="{{ $details['id'] }}" class="remove__btn">
                                        <a href="#" title="Remove this item"><i class="zmdi zmdi-close"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif
                    </div>
                    <ul style="margin-bottom:30px">
                    <span >subtotal:</span>
                    <span id="total__price" >{{ $total_price_cart }}</span>

                    </ul>
                    <ul class="shopping__btn">
                        <li><a href="{{ route('cart') }}">{{trans('header.View Cart')}}</a></li>
                        <li class="shp__checkout"><a href="checkout.html">{{trans('header.Checkout')}}</a></li>
                    </ul>
                </div>
            </div>
            <!-- End Cart Panel -->
        </div>
        <!-- End Offset Wrapper -->
