@extends('site.layout.app')
@section('title') {{__('site.home')}}  @endsection
@section('content')
<?php $title =trans('product_details.Product Details'); ?>

      <!-- Start Bradcaump area -->
      @include('site.components.bradcaump', ['title' => $title , 'image' =>  route('image_show', \App\Coverpages::first()->cover_product_details) ])
        <!-- End Bradcaump area -->
        <!-- Start Product Details -->
        <?php $all_ids_products=[];?>
        @if(session('favourite'))
            @foreach(session('favourite') as $id => $details)
            <?php $all_ids_products[]=  $details['id'] ?>
            @endforeach
        @endif
        <section class="htc__product__details pt--120 pb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-sm-12">
                        <div class="product__details__container">
                            <!-- Start Small images -->
                            <ul class="nav product__small__images" role="tablist">
                                <li role="presentation" class="pot-small-img active">
                                    <a href="#img-tab" role="tab" data-toggle="tab">
                                        <img style="width:90px;height:60px" src="{{ route('image_show',$product->image) }}" alt="small-image">
                                    </a>
								</li>
								@foreach($product->productimages as $key => $image)
                                <li role="presentation" class="pot-small-img">
                                    <a href="#img-tab-{{ $key  }}" role="tab" data-toggle="tab">
                                        <img style="width:90px;height:60px" src="{{ route('image_show',$image->image) }}" alt="small-image">
                                    </a>
								</li>
								@endforeach
                            </ul>
                            <!-- End Small images -->
                            <div class="product__big__images">
                                <div class="portfolio-full-image tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="img-tab">
                                        <img style="width:500px;height:500px" src="{{ route('image_show',$product->image) }}" alt="full-image">
									</div>
									@foreach($product->productimages as $k => $image)
                                    <div  role="tabpanel" class="tab-pane" id="img-tab-{{ $k  }}">
                                        <img style="width:4400px;height:500px" src="{{ route('image_show',$image->image) }}" alt="full-image">
									</div>
									@endforeach
                           
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-sm-12 smt-30 xmt-30">
                        <div class="htc__product__details__inner add__to__wishlist_2">
                            <div class="pro__detl__title">
                                <h2>{{ $product->name }}</h2>
                            </div>
                        
                       
                            <ul class="pro__dtl__prize">
								@if($product->sale)
									<li class="old__price">{{ $product->price }}</li>
									<li class="new__price">{{ ( (100-$product->sale) / 100) * $product->price }}</li>
								@else
								<li class="new__price">{{ $product->price }}</li>
								@endif
                             
							</ul>
							@if(count($product->productcolors ))
                            <div class="pro__dtl__color">
                                <h2 class="title__5">{{trans('product_details.Colour')}} </h2>
                                <ul class="pro__choose__color">
									@foreach($product->productcolors as $k => $color)
									   <li ><a href="#"><i style="color:{{ $color->color }}" class="zmdi zmdi-circle"></i></a></li>
									@endforeach
                                </ul>
							</div>
							@endif
							@if(count($product->productsizes ))
                            <div class="pro__dtl__size">
                                <h2 class="title__5">{{trans('product_details.Size')}}</h2>
                                <ul class="pro__choose__size">
									@foreach($product->productsizes as $k => $size)
									<li><a href="#">{{ $size->size }}</a></li>
									@endforeach
                                </ul>
							</div>
							@endif
                            <div class="product-action-wrap">
                                <div class="prodict-statas"><span>{{trans('product_details.Quantity')}}</span></div>
                                <div class="product-quantity">
                                    <form id='myform'>
                                        <div class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" type="number" id="quantity" name="quantity" value="1"  @if(App::getLocale() == 'ar') style="text-align: left;" @endif>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <ul class="pro__dtl__btn" style="padding: 0px;">
                                <li class="buy__now__btn"><a href="#" data-id="{{ $product->id }}" class="add_to_cart_2">{{trans('product_details.Add To Cart')}}</a></li>
                                <li><a><span class="ti-heart {{ in_array($product->id, $all_ids_products) ?'change_color' : '' }}" id="fav_{{ $product->id }}" data-id="{{ $product->id }}" style="color:{{ in_array($product->id, $all_ids_products) ?'red' : '' }}" ></span></a></li>
                            </ul>                        
                        </div>
                        <div class="pro__social__share">
                                <h2>Share</h2>
                                <ul class="pro__soaial__link">
                                    <li>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('product_details', $product->id) }}" target="_blank">
                                            <img src="{{ asset('front/images/share/facebook%20(3).png') }}" alt="" width="32px" height="32px">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/intent/tweet?url={{ route('product_details', $product->id) }}" target="_blank">
                                            <img src="{{ asset('front/images/share/twitter%20(2).png') }}" alt="" width="32px" height="32px">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://wa.me/?text={{ route('product_details', $product->id) }}" target="_blank">
                                            <img src="{{ asset('front/images/share/whatsapp.png') }}" alt="" width="32px" height="32px">
                                        </a>
                                    </li>
                                    <li>
                                        <a  href="https://www.linkedin.com/shareArticle?url={{ route('product_details', $product->id) }}" target="_blank">
                                            <img src="{{ asset('front/images/share/linkedin%20(1).png') }}" alt="" width="32px" height="32px">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product Details -->
        <!-- Start Product tab -->
        <section class="htc__product__details__tab bg__white pb--120">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <ul class="nav product__deatils__tab mb--60" role="tablist">
                            <li role="presentation" class="active">
                                <a class="active" href="#description" role="tab" data-toggle="tab">{{trans('product_details.Description')}}</a>
                            </li>
                      
                            <li role="presentation">
                                <a href="#reviews" role="tab" data-toggle="tab">{{trans('product_details.Reviews')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="product__details__tab__content">
                            <!-- Start Single Content -->
                            <div role="tabpanel" id="description" class="product__tab__content active">
                                <div class="product__description__wrap">
                                    <div class="product__desc">
                                        <h2 class="title__6">Details</h2>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis noexercit ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id.</p>
                                    </div>
                                    <div class="pro__feature">
                                        <h2 class="title__6">Features</h2>
                                        <ul class="feature__list">
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>Duis aute irure dolor in reprehenderit in voluptate velit esse</a></li>
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>Irure dolor in reprehenderit in voluptate velit esse</a></li>
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>Sed do eiusmod tempor incididunt ut labore et </a></li>
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>Nisi ut aliquip ex ea commodo consequat.</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Content -->
                            <!-- Start Single Content -->
                            <div role="tabpanel" id="sheet" class="product__tab__content">
                                <div class="pro__feature">
                                        <h2 class="title__6">Data sheet</h2>
                                        <ul class="feature__list">
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>Duis aute irure dolor in reprehenderit in voluptate velit esse</a></li>
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>Irure dolor in reprehenderit in voluptate velit esse</a></li>
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>Irure dolor in reprehenderit in voluptate velit esse</a></li>
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>Sed do eiusmod tempor incididunt ut labore et </a></li>
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>Sed do eiusmod tempor incididunt ut labore et </a></li>
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>Nisi ut aliquip ex ea commodo consequat.</a></li>
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>Nisi ut aliquip ex ea commodo consequat.</a></li>
                                        </ul>
                                    </div>
                            </div>
                            <!-- End Single Content -->
                            <!-- Start Single Content -->
                            <div role="tabpanel" id="reviews" class="product__tab__content">
                                <div class="review__address__inner">
                                    <!-- Start Single Review -->
                                    <div class="pro__review">
                                        <div class="review__thumb">
                                            <img src="{{ route('image_show',\App\User::first()->image) }}" alt="review images">
                                        </div>
                                        <div class="review__details">
                                            <div class="review__info">
                                                <h4><a href="#">Gerald Barnes</a></h4>
                                            </div>
                                            <div class="review__date">
                                                <span>27 Jun, 2016 at 2:30pm</span>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
                                        </div>
                                    </div>
                                    <!-- End Single Review -->
                                    <div class="pro__review" style="padding-top:30px">
                                        <div class="review__thumb">
                                            <img src="{{ route('image_show',\App\User::first()->image) }}" alt="review images">
                                        </div>
                                        <div class="review__details">
                                            <div class="review__info">
                                                <h4><a href="#">Gerald Barnes</a></h4>
                                            </div>
                                            <div class="review__date">
                                                <span>27 Jun, 2016 at 2:30pm</span>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
                                        </div>
                                    </div>
                                    <!-- End Single Review -->
                                </div>
                                <!-- Start RAting Area -->
                                <div class="rating__wrap" style="padding-top:50px">
                                    <h2 class="rating-title">Write  A review</h2>
                                  
                                 
                                </div>
                                <!-- End RAting Area -->
                                <div class="review__box">
                                    <form id="review-form">
                                        <div class="single-review-form">
                                            <div class="review-box name">
                                                <input type="text" placeholder="Type your name">
                                                <input type="email" placeholder="Type your email">
                                            </div>
                                        </div>
                                        <div class="single-review-form">
                                            <div class="review-box message">
                                                <textarea placeholder="Write your review"></textarea>
                                            </div>
                                        </div>
                                        <div class="review-btn">
                                            <a class="fv-btn" href="#">submit review</a>
                                        </div>
                                    </form>                                
                                </div>
                            </div>
                            <!-- End Single Content -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection
@section('js')

<script>
        $(".add_to_cart_2").click(function(){
            event.preventDefault()
            console.log($("#quantity").val())
            let CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            let product     = $(this).attr("data-id");
            let quantity    = $("#quantity").val();
            let action      =  "{{route('add_to_cart2')}}";

            $.ajax({
                url:  action,
                type: 'POST',
                dataType: 'JSON',
                data: {_token: CSRF_TOKEN, product: product, quantity: quantity},
                success: function(data, status){
                    console.log(data[5])
                    $("#none_data_cart").hide();
                    $("#data_cart").show();
                    if(data[1] == 0){
                        $("#quantity_"+data[0]).text(data[5]);
                        document.getElementById('price_'+data[0]).innerHTML =data[4];
                        let ttt = parseFloat($("#total__price").text());
                        document.getElementById("total__price").innerHTML =ttt + data[6];
                    }
                    if(data[1] == 1){
                        if(parseFloat($("#total__price").text()) != null){
                            let ttt = parseFloat($("#total__price").text());
                            document.getElementById("total__price").innerHTML =ttt + data[6];
                        }else{
                            document.getElementById("total__price").innerHTML =data[6];
                        }
                        console.log($('#data_cart .shp__cart__wrap_2'))
                        $('#data_cart .shp__cart__wrap_2').append(`
                            <div class="shp__single__product">
                                <div class="shp__pro__thumb">
                                <a href="#">
                                    <img src="${data[3]}" alt="product images">
                                </a>
                            </div>
                            <div class="shp__pro__details shp__pro__details_cart">
                                    <h2><a href="product-details.html">${data[2]}</a></h2>
                                    <span id="quantity_${data[0]}" class="quantity">${data[5]}</span>
                                    <span id="price_${data[0]}" class="shp__price">${data[4]}</span>
                                </div>
                                <div class="remove__btn">
                                    <a href="#" title="Remove this item"><i class="zmdi zmdi-close"></i></a>
                                </div>
                            </div>
                        `);

                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'added to cart successfully',
                        showConfirmButton: false,
                        timer: 2500
                    })
                }
            });
        });
    </script>
    @endsection

@section('og_url', route('product_details', $product->id))
@section('og_title', $product->name)
@section('og_description', $product->description)
@section('og_image', route('image_show', $product->image))