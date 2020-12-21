@extends('site.layout.app')
@section('title') {{__('site.home')}}  @endsection
@section('content')
  <!-- Start Slider Area -->
  <div class="slider__container slider--one">
            <div class="slider__activation__wrap owl-carousel owl-theme">
                @foreach($home_section_1s as $home_section_1)
                <!-- Start Single Slide -->
                <div class="slide slider__full--screen" style="background: rgba(0, 0, 0, 0)
                    url({{ route('image_show',$home_section_1->image) }}) no-repeat scroll center center / cover ;">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="slider__inner">
                                    <h1> <span class="text--theme" >{{$home_section_1->title}}</span></h1>
                                    <div class="slider__btn">
                                        <a style="font-size: 20px;">{{$home_section_1->description}}</a>
                                    </div>
                                    <div class="slider__btn">
                                        <a style="line-height:100px" class="htc__btn" href="{{ route('all_products_2',$home_section_1->subcategory_id) }}">{{$home_section_1->button}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Slide -->
                @endforeach

            </div>
        </div>
        <!-- Start Slider Area -->
        <section class="htc__team__area htc__team__page bg__white ptb--50" >
            <div class="container">
                <div class="row team__wrap clearfix">

                    @foreach($home_section_2s as $home_section_2)
                    <!-- Start Single Team -->
                    <div class="col-md-6 col-lg-4 col-sm-12">
                        <div class="team foo">
                            <div class="team__thumb">
                                <a>
                                    <img src="{{ route('image_show',$home_section_2->image) }}" alt="team images">
                                </a>
                            </div>
                            <div class="team__bg__color"></div>
                            <div class="team__hover__info">
                                <div class="team__hover__action">
                                    <h2><a href="{{ route('all_products_2',$home_section_2->subcategory_id) }}">{{$home_section_2->title}}</a></h2>
                                    <p style="color:#ff4136 ">{{$home_section_2->description}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Team -->
                    @endforeach




                    <!-- End Single Team -->
                </div>
            </div>
        </section>
        <!-- Start Our Product Area -->
        <section class="htc__product__area ptb--40 bg__white" style="background:#e7e7e7">
            <div class="container">
                <div class="htc__product__container">
                    <!-- Start Product MEnu -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="product__menu">
                                <!-- <button data-filter="*"  class="is-checked">All</button> -->
                                <button data-filter=".cat--new">{{trans('header.new arrival')}} </button>
                                <button data-filter=".cat--sale">{{trans('header.on sale')}} </button>
                            </div>
                        </div>
                    </div>
                    <!-- End Product MEnu -->
                    <div class="row product__list">
                        <!-- Start Single Product -->
                        <?php $all_ids_products=[];?>
                        @if(session('favourite'))
                            @foreach(session('favourite') as $id => $details)
                            <?php $all_ids_products[]=  $details['id'] ?>
                            @endforeach
                        @endif
                        @foreach(\App\Product::where('sale', '!=', null)->orWhere('created_at', '>=', \Carbon\Carbon::today()->subDays(7) )->inRandomOrder()->limit(8)->get() as $product)
                        <div class="col-md-3 single__pro col-lg-3 col-md-4
                            @if($product->sale != null) cat--sale @endif
                            @if($product->created_at >= \Carbon\Carbon::today()->subDays(7) ) cat--new @endif

                             col-sm-12">
                            <div class="product foo">
                                <div class="product__inner">
                                    <div class="pro__thumb">
                                    @if($product->sale) <div class="new">sale {{ $product->sale }}% </div> @endif
                                        <a>
                                            <img src="{{ route('image_show',$product->image) }}" alt="product images">
                                        </a>
                                    </div>
                                    <div class="product__hover__info">
                                        <ul class="product__action" style="padding: 0;">
                                            <li><a id="pro_id{{ $product->id }}" data-toggle="modal"  data-id="{{ $product->id }}" data-target="#productModal" title="Quick View" class="quick-view modal-view detail-link" href="#"><span  class="ti-plus"></span></a></li>
                                            <li>
                                                <a title="Add TO Cart" data-id="{{ $product->id }}" class="add_to_cart" ><span id="cart_{{ $product->id }}" class="ti-shopping-cart"></span>
                                                    <i class="loading_icon_cart_{{ $product->id }} fa fa-spinner fa-spin hide"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="add__to__wishlist add__to__wishlist_2">
                                        <a data-toggle="tooltip"  title="Add To Wishlist" class="add-to-cart"><span id="fav_{{ $product->id }}" data-id="{{ $product->id }}" class="ti-heart {{ in_array($product->id, $all_ids_products) ?'change_color' : '' }}" ></span>
                                            <i class="loading_icon_fav_{{ $product->id }} fa fa-spinner fa-spin hide"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product__details">
                                    <h2><a href="{{ route('product_details', $product->id) }}">{{ $product->name }}</a></h2>
                                    <ul class="product__price">
                                    @if($product->sale)
										<li class="old__price">{{ $product->price }}</li>
                                        <li class="new__price">{{ ( (100-$product->sale) / 100) * $product->price }} EGP</li>
									@else
									<li class="new__price">{{ $product->price }} EGP</li>
									@endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

             <!-- Start Our blogs Area -->
        @if(count($blogs))
        <section class="htc__team__area htc__team__page bg__white ptb--50">
            <div class="container">
            <div class="col-md-12">
                <div style="margin-bottom:60px;text-align:center;">
                    <button style="
                    background: transparent none repeat scroll 0 0;
                    border: 0 none;
                    color: #666666;
                    font-size: 21px;
                    font-weight: 500;
                    line-height: 22px;
                    padding: 0 20px;
                    text-transform: uppercase;
                    -webkit-transition: all 0.4s ease 0s;
                    transition: all 0.4s ease 0s;">{{trans('header.Latest Posts')}}  </button>
                </div>
            </div>
                <div class="row team__wrap clearfix">
                    @foreach($blogs as $blog)
                    <!-- Start Single Team -->
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="team foo">
                            <div class="team__thumb">
                                <a>
                                    <img style=" height:300px" src="{{ route('image_show', $blog->image) }}" alt="team images">
                                </a>
                            </div>
                            <div class="team__bg__color"></div>
                            <div class="team__hover__info">
                                <div class="team__hover__action">
                                    <h2><a href="{{route('blog',$blog->id)}}">@if( strlen(strip_tags($blog->title)) > 70 ) {!! substr(strip_tags($blog->title), 0, 70) !!}.... @else {!! strip_tags($blog->title) !!} @endif</a></h2>
                                    <p style="color:#ff4136 ">@if( strlen(strip_tags($blog->description)) > 160 ) {!! substr(strip_tags($blog->description), 0, 160) !!}.... @else {!! strip_tags($blog->description) !!} @endif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Team -->
                    @endforeach
                    <!-- End Single Team -->
                </div>
            </div>
        </section>
        @endif

        <div class="htc__testimonial__area ptb--120" style="background: rgba(0, 0, 0, 0) url({{ asset('h_1_4.jpg') }}) no-repeat scroll center center / cover ;" data--black__overlay="6">
            <div class="container">

                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="slider__activation__wrap testimonial__wrap owl-carousel owl-theme clearfix">
                            @foreach($testimations as $testimation)
                            <!-- Start Single Testimonial -->
                            <div class="testimonial">
                                <div class="testimonial__thumb">
                                    <img style="width:100px; height:100px" src="{{ route('image_show',$testimation->user->image) }}" alt="testimonial images">
                                </div>
                                <div class="testimonial__details">
                                <div class="test__info">
                                        <span><a href="#">{{ $testimation->user->name }}</a></span>
                                    </div>
                                    <p>{{ $testimation->description }}</p>
                                </div>
                            </div>
                            <!-- End Single Testimonial -->
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Our Product Area -->

@endsection
