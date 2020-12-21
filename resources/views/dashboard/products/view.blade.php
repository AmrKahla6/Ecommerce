
@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">{{ __('Name') }}</div>
    <div class="panel-body">{{ $product->name }}</div>
</div>


<div class="panel panel-default">
    <div class="panel-heading">{{ __('description') }}</div>
    <div class="panel-body">{!! $product->description !!}</div>
</div>

@if($product->category)
<div class="panel panel-default">
    <div class="panel-heading">{{ __('category') }}</div>
    <div class="panel-body">{{ $product->category->name }}</div>
</div>
@endif

@if($product->sale)
<div class="panel panel-default">
    <div class="panel-heading">{{ __('sale') }}</div>
    <div class="panel-body">{{ $product->sale }}%</div>
</div>
@endif


<div class="panel panel-default">
    <div class="panel-heading">{{ __('images') }}</div>
    <div class="panel-body">
    @foreach($product->productimages as $image)
    <img style="width:80px;height:80px" src="{{ route('image_show', $image->image)}}" class="user-image" alt="User Image">
        @endforeach
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">{{ __('sizes') }}</div>
    <div class="panel-body">
    @foreach($product->productsizes as $key => $size)
        <tr>
        <td> <input type='text' value="{{ $size->size }}" disabled /></td>  
        </tr>
        @endforeach
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('color') }}</div>
    <div class="panel-body">
    @foreach($product->productcolors as $key => $color)
        <tr>
        <td><label></label> <input type='color' value="{{ $color->color }}" disabled /></td>  
        </tr>
        @endforeach
    </div>
</div>


@endsection
@section('css')

@endsection
@section('js')

@endsection