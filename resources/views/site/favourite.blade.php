@extends('site.layout.app')
@section('title') {{__('site.home')}}  @endsection
@section('content')
        <?php 
            $title=trans('cart.Wishlist'); 
            $count_favourite = 0 ;
            if(!empty(session()->get('favourite'))){
                foreach(session()->get('favourite') as $id => $details){
                    if(!empty(\App\Product::find($details['id']))){
                        $count_favourite += 1 ;
                    }
                }
            }
        ?> 
    <!-- Start Bradcaump area -->
    @include('site.components.bradcaump', ['title' => $title , 'image' =>  route('image_show', \App\Coverpages::first()->cover_favourite) ])

   
        @if($count_favourite == 0)
        <section class="htc__store__area ptb--120 bg__white" style="background:#e7e7e7;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section__title section__title--2 text-center">
                            <img style="width:160px;width:160px;border:0px solid #000;border-radius: 50%;" src="{{ asset('empty_2.jpg') }}" alt="product img" /></a>
                        </div>
                    
                        <div class="section__title section__title--2 text-center">
                            <h2 class="title__line" style="color:#c5c5c5;padding-top:20px">{{trans('cart.Empty Favourite')}}</h2>
                        </div>
                        <div class="section__title section__title--2 text-center">
                            <h3 class="title__line" style="padding-top:30px">{{trans('cart.Go Home And Shopping from Our Categories')}}</h3>
                        </div>
                        <div class="row mt--60">
                            <div class="col-md-12">
                                <div class="htc__loadmore__btn">
                                    <a href="#">{{trans('cart.Go Home')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @else

        <!-- End Bradcaump area -->
        <!-- wishlist-area start -->
        <div class="wishlist-area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="wishlist-content">
                            <form action="#">
                                <div class="wishlist-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-remove"><span class="nobr">{{trans('cart.Remove')}}</span></th>
                                                <th class="product-thumbnail">{{trans('cart.Image')}}</th>
                                                <th class="product-name"><span class="nobr">{{trans('cart.Product')}}</span></th>
                                                <th class="product-price"><span class="nobr">{{trans('cart.Price')}}</span></th>
                                                <th class="product-add-to-cart"><span class="nobr">{{trans('cart.Add To Cart')}}</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($session_favourite))
                                        @foreach($session_favourite as $id => $details)
                                        @if(!empty(\App\Product::find($details['id'])))
                                            <?php
                                                $product = \App\Product::find($details['id']);
                                                if($product->sale != null){
                                                    $price = ( (100-$product->sale) / 100) * $product->price ;
                                                }else{
                                                    $price = $product->price;
                                                }
                                            ?>
                                            <tr>
                                                <td class="product-remove"><a href="{{route('remove_from_favourite_2', ['product' => $product->id ])}}">×</a></td>
                                                <td class="product-thumbnail"><a href="#"><img src="{{ $details['photo'] }}" alt="" /></a></td>
                                                <td class="product-name"><a href="#">{{ $details['name'] }}</a></td>
                                                <td class="product-price"><span class="amount">{{ $price  }}</span></td>
                                                <td class="product-add-to-cart"><a href="{{route('add_to_cart_from_favourite', ['product' => $product->id ])}}">{{trans('cart.Add To Cart')}}</a></td>
                                            </tr>
                                        @endif
                                        @endforeach
                                        @endif
                                   
                                        </tbody>
                                  
                                    </table>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- wishlist-area end -->

@endsection