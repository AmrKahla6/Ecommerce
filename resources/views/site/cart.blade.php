@extends('site.layout.app')
@section('title') {{__('site.home')}}  @endsection
@section('content')
    <?php 
        $title=trans('cart.Cart'); 
            $total_price = 0 ; 
        if(auth()->check()){
            $count_cart =0 ;
            foreach($carts as $key => $cart){
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
	<!-- Title Page -->
     <!-- Start Bradcaump area -->
     @include('site.components.bradcaump', ['title' => $title , 'image' =>  route('image_show', \App\Coverpages::first()->cover_blog_deatails) ])
 
        @if($count_cart == 0)
        <section class="htc__store__area ptb--120 bg__white" style="background:#e7e7e7;" >
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section__title section__title--2 text-center">
                            <img src="{{ asset('empty.png') }}" alt="product img" /></a>
                        </div>
                  
                        <div class="section__title section__title--2 text-center">
                            <h2 class="title__line" style="color:#c5c5c5;padding-top:20px">{{trans('cart.Empty Cart')}}</h2>
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
        <!-- cart-main-area start -->
        <div class="cart-main-area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <form id="update_form" role="form" method="POST" action="{{ route('update_cart_2') }}">
                            @csrf               
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">{{trans('cart.Image')}}</th>
                                            <th class="product-name">{{trans('cart.Product')}}</th>
                                            <th class="product-price">{{trans('cart.Price')}}</th>
                                            <th class="product-quantity">{{trans('cart.Quantity')}}</th>
                                            <th class="product-subtotal">{{trans('cart.Total')}}</th>
                                            <th class="product-remove">{{trans('cart.Remove')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($carts))
                                        @foreach($carts as $key => $cart)
                                        @if(!empty( $cart->product ))
                                        <?php
                                            $product = \App\Product::find($cart->product_id);
                                            if($product->sale != null){
                                                $price = ( (100-$product->sale) / 100) * $product->price ;
                                            }else{
                                                $price = $product->price;
                                            }
                                            $total_price += $price * $cart->quantity_of_product ;
                                        ?>
                                        <tr>
                                        <input name="products[]" type="hidden" value="{{ $product->id }}" >
                                            <td class="product-thumbnail"><a href="#"><img style="width:100px; height:100px"  src="{{ route('image_show',\App\Product::where('id',$cart->product_id)->firstOrFail()->image) }}" alt="product img" /></a></td>
                                            <td class="product-name"><a href="#">{{$product->name}}</a></td>
                                            <td class="product-price"><span class="amount">{{ $price  }}</span></td>
                                            <td class="product-quantity"><input name="quantities[]" type="number" value="{{ $cart->quantity_of_product }}" /></td>
                                            <td class="product-subtotal">{{ $price * $cart->quantity_of_product }}</td>
                                          
                                            <td class="product-remove delete_form_id"><a  href="{{route('delete_cart_2', ['product' => $product->id ])}}">X</a></td>
                                          
                                        </tr>
                                        @endif
                                        @endforeach
                                        @elseif(isset($session_cart))
                                        @foreach($session_cart as $id => $details)
                                        @if(!empty(\App\Product::find($details['id'])))
                                        <input name="products[]" type="hidden" value="{{ $details['id'] }}" >
                                        <?php
                                            $product = \App\Product::find($details['id']);
                                            if($product->sale != null){
                                                $price = ( (100-$product->sale) / 100) * $product->price ;
                                            }else{
                                                $price = $product->price;
                                            }
                                            $total_price += $price * $details['quantity_of_product'] ;
                                        ?>
                                        <tr>
                                            <td class="product-thumbnail"><a href="#"><img style="width:100px; height:100px" src="{{ $details['photo'] }}" alt="product img" /></a></td>
                                            <td class="product-name"><a href="#">{{ $details['name'] }}</a></td>
                                            <td class="product-price"><span class="amount">{{ $price  }}</span></td>
                                            <td class="product-quantity"><input name="quantities[]" type="number" value="{{ $details['quantity_of_product'] }}" /></td>
                                            <td class="product-subtotal">{{ $details['quantity_of_product'] * $price }}</td>
                                            <td class="product-remove"><a href="{{route('delete_cart_2', ['product' => $product->id ])}}">X</a></td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <div class="buttons-cart">
                                        <input type="submit" value="{{trans('cart.Update Cart')}}" />
                                        <a href="{{route('checkout' , ['total' =>$total_price ])}}">{{trans('cart.Proceed to Checkout')}}</a>
                                    </div>
                                
                                </div>
                                <div class="col-md-4 col-sm-12 ">
                                    <div class="cart_totals">
                                  
                                        <table>
                                            <tbody>
                                         
                                                <tr class="order-total">
                                                    @if(App::getLocale() == 'ar')
                                                    <td> <strong><span class="amount">{{ $total_price }}</span></strong> </td>
                                                    <th>{{trans('cart.Total Price')}}</th>
                                                    @else
                                                    <th>{{trans('cart.Total Price')}}</th>
                                                    <td> <strong><span class="amount">{{ $total_price }}</span></strong> </td>
                                                    @endif
                                                </tr>                                           
                                            </tbody>
                                        </table>
                                 
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
        @endif
@endsection


