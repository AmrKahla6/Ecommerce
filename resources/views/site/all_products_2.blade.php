
@extends('site.layout.app')
@section('title') {{__('site.all-products')}}  @endsection
@section('content')
       <!-- Start Bradcaump area -->
       @include('site.components.bradcaump', ['title' => "Shop Page" , 'image' =>  route('image_show', \App\Coverpages::first()->cover_shop) ])
        <!-- End Bradcaump area --> 
        @if(isset($no_data))
        <section class="htc__store__area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section__title section__title--2 text-center">
                            <h2 class="title__line">no products exist</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @else
        <!-- Start Our Product Area -->
        <section class="htc__product__area shop__page ptb--130 bg__white">
            <div class="container">
                <div class="htc__product__container">
                    <!-- Start Product MEnu -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="filter__menu__container">
                                <div class="product__menu">
									<button data-filter="*"  class="is-checked">{{trans('all_products.All')}}</button>
                                        @if(!empty($id))
                                        <button>{{ \App\Subcategory::find($id)->name }}</button>
                                        @endif
								
                                </div>
                                <div class="filter__box">
                                    <a class="filter__menu" href="#">{{trans('all_products.filter')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Filter Menu -->
                    <div class="filter__wrap">
                        <div class="filter__cart">
                            <div class="filter__cart__inner">
                                <div class="filter__menu__close__btn">
                                    <a href="#"><i class="zmdi zmdi-close"></i></a>
                                </div>
                                <div class="filter__content">
                                <form method="get" action="{{ route('all_products_2',$category->id) }}">
                                    <!-- Start Single Content -->
                                    <div class="fiter__content__inner">
                                   
                                        <div class="single__filter" style="width:100%">
                                            <h2 class="title__5">Size</h2>
                                            <div class="row">
                                                <div class="col-6">
                                                    <ul class="filter__list">
                                                        <li>
                                                            <div class="pretty p-icon p-round">
                                                                <input  name="price_sort" value="heigh_to_low" type="radio" {{ request('price_sort') == 'heigh_to_low' ? 'checked' : '' }}  name="icon_solid" />
                                                                <div class="state p-success">
                                                                    <i class="icon mdi mdi-check"></i>
                                                                    <label>price high to low</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-6">
                                                    <ul class="filter__list">
                                                       
                                                        <li>
                                                            <div class="pretty p-icon p-round">
                                                                <input  name="price_sort" value="low_to_high" type="radio" {{ request('price_sort') == 'low_to_high' ? 'checked' : '' }} name="icon_solid" />
                                                                <div class="state p-success">
                                                                    <i class="icon mdi mdi-check"></i>
                                                                    <label>price low to high</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        
                                        </div>
                                 
                                        <div class="single__filter" style="width:100%">
                                            <h2>Price</h2>
                                            <div class="row">
                                                <div class="col-6">
                                                    <ul class="filter__list">
                                                    <div  class="news__input">
                                                        <input type="number" value="{{ request('from')   ? request('from') : '' }}" name="from"  id="from" placeholder="price from" >
                                                    </div>
                                                    </ul>
                                                </div>
                                                <div class="col-6">
                                                    <ul class="filter__list">
                                                    <div class="news__input">
                                                        <input type="number" value="{{ request('to')   ? request('to') : '' }}" name="to" id="to" placeholder="price to" >
                                                    </div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                       <?php 
                                            $colors =[];
                                            $sizes  =[];
                                            foreach(\App\Productcolors::all() as $color){
                                                if(!in_array($color->color,$colors)){
                                                    $colors[]=$color->color;
                                                }
                                            }
                                            foreach(\App\Productsize::all() as $size){
                                                if(!in_array($size->size ,$sizes)){
                                                    $sizes[]=$size->size;
                                                }
                                            }
                                       ?>
                                        <div class="single__filter" style="width:100%">
                                            <h2 class="title__5">Size</h2>

                                          

                                            <div class="row">
                                                <div class="col-4 ">
                                                    <ul class="filter__list">
                                                        @foreach($sizes as $k => $size)
                                                        @if($k % 3 == 0)
                                                        <li >
                                                            <div class="pretty p-icon p-smooth">
                                                                <input {{ request('sizes') ? ( in_array($size ,request('sizes')) ? 'checked' : '') : '' }} name="sizes[]" value="{{ $size }}" class="styled" id="remind-me" type="checkbox">
                                                                <div class="state p-success">
                                                                    <i class="icon typcn typcn-tick"></i>
                                                                    <label>{{ $size }}</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="col-4">
                                                    <ul class="filter__list">
                                                        @foreach($sizes as $key => $size)
                                                        @if($key % 3 == 1)
                                                        <li >
                                                            <div class="pretty p-icon p-smooth">
                                                                <input {{ request('sizes') ? ( in_array($size ,request('sizes')) ? 'checked' : '') : '' }} name="sizes[]" value="{{ $size }}" class="styled" id="remind-me" type="checkbox">
                                                                <div class="state p-success">
                                                                    <i class="icon typcn typcn-tick"></i>
                                                                    <label>{{ $size }}</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="col-4">
                                                    <ul class="filter__list">
                                                        @foreach($sizes as $ke => $size)
                                                        @if($ke % 3 == 2)
                                                        <li >
                                                            <div class="pretty p-icon p-smooth">
                                                                <input {{ request('sizes') ? ( in_array($size ,request('sizes')) ? 'checked' : '') : '' }} name="sizes[]" value="{{ $size }}" class="styled" id="remind-me" type="checkbox">
                                                                <div class="state p-success">
                                                                    <i class="icon typcn typcn-tick"></i>
                                                                    <label>{{ $size }}</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single__filter" style="width:100%">
                                            <h2 class="title__5">Color</h2>
                                            <div class="row">
                                            <div class="col-4">
                                                    <ul class="filter__list">
                                                        @foreach($colors as $k => $color)
                                                        @if($k % 3 == 0)
                                                        <li >
                                                            <div class="pretty p-icon p-smooth">
                                                                <input name="colors[]" {{ request('colors') ? ( in_array($color ,request('colors')) ? 'checked' : '') : '' }} value="{{ $color }}" class="styled" id="remind-me" type="checkbox">
                                                                <div class="state p-success">
                                                                    <i class="icon typcn typcn-tick"></i>
                                                                    <label> <a href="#"><i class="zmdi zmdi-circle" class="searchterm" data-color="{{ $color }}" style="color: {{$color}}"></i></a></label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="col-4">
                                                    <ul class="filter__list">
                                                        @foreach($colors as $ke => $color)
                                                        @if($ke % 3 == 1)
                                                        <li >
                                                            <div class="pretty p-icon p-smooth">
                                                                <input name="colors[]" {{ request('colors') ? ( in_array($color ,request('colors')) ? 'checked' : '') : '' }} value="{{ $color }}" class="styled" id="remind-me" type="checkbox">
                                                                <div class="state p-success">
                                                                    <i class="icon typcn typcn-tick"></i>
                                                                    <label> <a href="#"><i class="zmdi zmdi-circle" class="searchterm" data-color="{{ $color }}" style="color: {{$color}}"></i></a></label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="col-4">
                                                    <ul class="filter__list">
                                                        @foreach($colors as $key => $color)
                                                        @if($key % 3 == 2)
                                                        <li >
                                                            <div class="pretty p-icon p-smooth">
                                                                <input name="colors[]" {{ request('colors') ? ( in_array($color ,request('colors')) ? 'checked' : '') : '' }} value="{{ $color }}" class="styled" id="remind-me" type="checkbox">
                                                                <div class="state p-success">
                                                                    <i class="icon typcn typcn-tick"></i>
                                                                    <label> <a href="#"><i class="zmdi zmdi-circle" class="searchterm" data-color="{{ $color }}" style="color: {{$color}}"></i></a></label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                       
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="store__btn" >
                                    <button  type="submit" style="width:40%;margin-right:20px"> <a style="width:100%" >search </a> </button>
                                    <button style="width:40%"> <a href="{{ route('all_products_2',$category->id) }}" style="width:100%" >Reset </a> </button>
                                    </div>
                                    <div class="store__btn" >
                                   
                                    </div>
                                    <!-- End Single Content -->
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Filter Menu -->
                    <!-- End Product MEnu -->
                    <div class="row product__list">
                    <?php $all_ids_products=[];?>
                        @if(session('favourite'))
                            @foreach(session('favourite') as $id => $details)
                            <?php $all_ids_products[]=  $details['id'] ?>
                            @endforeach
                        @endif
						<!-- Start Single Product -->
						@foreach($products as $product)
                        <div class="col-md-4 single__pro col-lg-3 cat--{{ $product->subcategory->id }} col-sm-12">
                            <div class="product foo">
                                <div class="product__inner">
                                    <div class="pro__thumb">
                                        <a href="{{ route('product_details', $product->id) }}">
                                            <img src="{{ route('image_show',$product->image) }}" alt="product images">
                                        </a>
                                    </div>
                                    <div class="product__hover__info">
                                        <ul class="product__action" style="padding: 0;">
                                            <li><a data-toggle="modal" data-target="#productModal"  data-id="{{ $product->id }}" title="Quick View" class="quick-view modal-view detail-link" href="#"><span class="ti-plus"></span></a></li>
                                            <li>
                                                <a title="Add TO Cart" data-id="{{ $product->id }}" class="add_to_cart">
                                                    <span id="cart_{{ $product->id }}" class="ti-shopping-cart"></span>
                                                    <i class="loading_icon_cart_{{ $product->id }} fa fa-spinner fa-spin hide"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="add__to__wishlist add__to__wishlist_2">
                                        <a data-toggle="tooltip"  title="Add To Wishlist" class="add-to-cart">
                                            <span id="fav_{{ $product->id }}" data-id="{{ $product->id }}" class="ti-heart {{ in_array($product->id, $all_ids_products) ?'change_color' : '' }}" ></span>
                                            <i class="loading_icon_fav_{{ $product->id }} fa fa-spinner fa-spin hide"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product__details">
                                    <h2><a href="{{ route('product_details', $product->id) }}">{{ $product->name }}</a></h2>
                                    <ul class="product__price">
									@if($product->sale)
										<li class="old__price">{{ $product->price }}</li>
                                        <li class="new__price">{{ ( (100-$product->sale) / 100) * $product->price }}</li>
									@else
									<li class="new__price">{{ $product->price }}</li>
									@endif
                                    </ul>
                                </div>
                            </div>
						</div>
						@endforeach
              
                        <!-- End Single Product -->
                    </div>
                    <!-- Start Load More BTn -->
                    <div class="row mt--60">
                        <!-- <div class="col-md-12">
                            <div class="htc__loadmore__btn">
                                <a href="#">load more</a>
                            </div>
                        </div> -->
                    </div>
                    <!-- End Load More BTn -->
                </div>
            </div>
        </section>
        @endif
        <!-- End Our Product Area -->
@endsection
@section('js')

@endsection
