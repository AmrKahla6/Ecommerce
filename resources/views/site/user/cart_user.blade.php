@extends('site.user.app')
@section('title') {{__('site.all-products')}}  @endsection
@section('content')
<?php 
	$total_price = 0 ; 
	$count_cart =0 ;
	foreach(auth()->user()->carts as $key => $cart){
		if(!empty( $cart->product )){
			$count_cart += 1 ;
		}
	}
?> 
    @if($count_cart == 0)
        <section class="htc__store__area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section__title section__title--2 text-center">
                            <h2 class="title__line">no data in the cart</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	@else

	<div class="col-md-10 offset-md-1 col-lg-8 offset-lg-0">
	<form id="update_form" role="form" method="POST" action="{{ route('update_cart_2') }}">
    @csrf  
		<!-- Recently Favorited -->
		<div class="widget dashboard-container my-adslist">
			<h3 class="widget-header">My cart</h3>
			<table class="table table-responsive product-dashboard-table">
				<thead>
					<tr>
						<th>Image</th>
						<th>Product</th>
						<th class="text-center">Quantity</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach($carts as $key => $cart)
					@if(!empty($cart->product))
					<?php
						$product = $cart->product;
						if($product->sale != null){
							$price = ( (100-$product->sale) / 100) * $product->price ;
						}else{
							$price = $product->price;
						}
						$total_price += $price * $cart->quantity_of_product ;
					?>
				   <input name="products[]" type="hidden" value="{{ $product->id }}" >
					<tr>
						<td class="product-thumb">
							<img width="80px" height="auto" src="{{ route('image_show',\App\Product::where('id',$cart->product_id)->firstOrFail()->image) }}" alt="image description"></td>
						<td class="product-details">
							<h3 class="title">{{$product->name}}</h3>
							<span class="add-id"><strong>Price:</strong> {{ $price  }}</span>
						</td>
						<td class="product-category"><span class="categories"><input style="
						    background: #e5e5e5 none repeat scroll 0 0;
							border: medium none;
							border-radius: 3px;
							color: #6f6f6f;
							font-size: 15px;
							font-weight: normal;
							height: 40px;
							padding: 0 5px 0 10px;
							width: 60px;" name="quantities[]" type="number" value="{{ $cart->quantity_of_product }}" /></span></td>
						<td class="action" data-title="Action">
							<div class="">
								<ul class="list-inline justify-content-center">
									<li class="list-inline-item">
										<a data-toggle="tooltip" data-placement="top" title="Tooltip on top" class="view" href="{{ route('product_details', $product->id) }}">
											<i class="fa fa-eye"></i>
										</a>		
									</li>
									<li class="list-inline-item">
										<a class="delete" href="{{route('delete_cart_2', ['product' => $product->id ])}}">
											<i class="fa fa-trash"></i>
										</a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
					@endif
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="widget price text-center">
			<h4>total Price</h4>
			<p>{{ $total_price }} EGP</p>
		</div>
		<button type="submit" class="btn btn-transparent">Update Cart</button>
		<a href="#" class="btn btn-transparent">Proceed To Checkout</a>
		<!-- <button class="btn btn-transparent">Proceed To Checkout</button> -->
	</form>

	</div>
	@endif


@endsection
@section('js')

@endsection