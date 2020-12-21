@extends('site.user.app')
@section('title') {{__('site.all-products')}}  @endsection
@section('content')
	<?php 
		$count_favourite = 0 ;
		if(!empty(session()->get('favourite'))){
			foreach(session()->get('favourite') as $id => $details){
				if(!empty(\App\Product::find($details['id']))){
					$count_favourite += 1 ;
				}
			}
		}
	?> 
	@if($count_favourite == 0)
	<section class="htc__store__area ptb--120 bg__white">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section__title section__title--2 text-center">
						<h2 class="title__line">no data in the favourite</h2>
					</div>
				</div>
			</div>
		</div>
	</section>
	@else
	<div class="col-md-10 offset-md-1 col-lg-8 offset-lg-0">
		<!-- Recently Favorited -->
		<div class="widget dashboard-container my-adslist">
			<h3 class="widget-header">Favourite Ads</h3>
			<table class="table table-responsive product-dashboard-table">
				<thead>
					<tr>
						<th>Image</th>
						<th>Product Title</th>
						<th class="text-center">Category</th>
						<th class="text-center">Action</th>
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
						
						<td class="product-thumb">
							<img width="80px" height="auto" src="{{ $details['photo'] }}" alt="image description"></td>
						<td class="product-details">
							<h3 class="title">{{ $details['name'] }}</h3>
							<span class="add-id"><strong>price</strong> {{ $price  }} EGP</span>
						</td>
						<td class="product-category"><span class="categories"><a href="{{route('add_to_cart_from_favourite', ['product' => $product->id ])}}" class="btn btn-main-sm">Add To Cart</a></span></td>
						<td class="action" data-title="Action">
							<div class="">
								<ul class="list-inline justify-content-center">
									<li class="list-inline-item">
										<a data-toggle="tooltip" data-placement="top" title="Tooltip on top" class="view" href="{{ route('product_details', $product->id) }}">
											<i class="fa fa-eye"></i>
										</a>		
									</li>
									<li class="list-inline-item">
										<a class="delete" href="{{route('remove_from_favourite_2', ['product' => $product->id ])}}">
											<i class="fa fa-trash"></i>
										</a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
					@endif
					@endforeach
                    @endif
				</tbody>
			</table>
		</div>
	</div>
	@endif

@endsection
@section('js')

@endsection