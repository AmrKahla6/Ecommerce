@extends('dashboard.layouts.app')
@section('title')
   {{__('pending order products')}} 
@endsection
@section('content')
    <div class="row">
            <div class="box">
              
                <div class="box-body">
                    <table class="table table-striped table-bordered" id="example1">  
                        <thead>
                            <tr>
                                <th> {{ __('ID') }} </th>
                                <th> {{ __('Name') }} </th>
                                <th> {{ __('Purchaser') }} </th>
                                <th> {{ __('color') }} </th>
                                <th> {{ __('size')}} </th>
                                <th> {{ __('quantity') }} </th>
                                <th> {{ __('position')}} </th>
                                <th> {{ __('company') }} </th>
                                <th> {{ __('price of product') }} </th>
                                <th> {{ __('total price of product') }} </th>
                                <th> {{ __('method pay')}} </th>
                                <th> {{ __('Actions')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (\App\Order::where('status','pending')->get() as $order)
                            <?php
                                $user=\App\User::find($order->user_id);
                                $product=\App\Product::find($order->product_id);
                                $company=\App\User::find($product->user_id);
                            ?>
                                <tr>
                                    <td> {{ $order->id }} </td> 
                                    <td> {{ $product->name }} </td> 
                                    <td> {{ $user->name_of_owner }} </td> 
                                    <td> {{ $order->color }} </td>
                                    <td> {{ $order->size }} </td>
                                    <td> {{ $order->quantity }} </td>
                                    <td> {{ $order->position }} </td>
                                    <td> {{ $company->name_of_company }} </td>
                                    <td> {{ $order->price_of_product }} </td>
                                    <td> {{ $order->total_of_price_product }} </td>
                                    <td> {{ $order->method_pay }} </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-xs btn-success" type="button" data-toggle="dropdown" aria-expanded="false">{{ __('change status')}}
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            @if($order->method_pay == "cash")
                                            <ul class="dropdown-menu pull-left" blog="menu">
                                    
                                                <li style="margin-bottom:5px">
                                                    <form id="block_form" method="POST" action="{{ route('had_paid',$order->id) }}">
                                                        @csrf
                                                        <input type="hidden" name="method_pay" value="{{ $order->method_pay }}" >
                                                        <a><button type="submit" class="btn btn-danger">{{ __('Delivered') }}</button>  </a>               
                                                    </form>
                                                </li>
                                                <li style="margin-bottom:5px">
                                                    <form id="block_form" method="POST" action="{{ route('not_paid_with_deduct',$order->id) }}">
                                                        @csrf
                                                        <input type="hidden" name="method_pay" value="{{ $order->method_pay }}" >
                                                        <a><button type="submit" class="btn btn-danger">{{ __('Not paid with deducted') }}</button>  </a>               
                                                    </form>
                                                </li>
                                            
                                                <li>
                                                    <form id="block_form" method="POST" action="{{ route('not_paid_no_deduct',$order->id) }}">
                                                        @csrf
                                                        <input type="hidden" name="method_pay" value="{{ $order->method_pay }}" >
                                                        <a><button type="submit" class="btn btn-danger">{{ __('Not paid with no deducted') }}</button>  </a>               
                                                    </form>
                                                </li>
                                        
                                            </ul>
                                            @elseif($order->method_pay == "points")
                                            <ul class="dropdown-menu pull-left" blog="menu">
                                    
                                                <li style="margin-bottom:5px">
                                                    <form id="block_form" method="POST" action="{{ route('had_paid',$order->id) }}">
                                                        @csrf
                                                        <input type="hidden" name="method_pay" value="{{ $order->method_pay }}" >
                                                        <a><button type="submit" class="btn btn-danger">{{ __('Delivered') }}</button>  </a>               
                                                    </form>
                                                </li>
                                                <li>
                                                    <form id="block_form" method="POST" action="{{ route('not_paid_no_deduct',$order->id) }}">
                                                        @csrf
                                                        <input type="hidden" name="method_pay" value="{{ $order->method_pay }}" >
                                                        <a><button type="submit" class="btn btn-danger">{{ __('Not paid with no deducted') }}</button>  </a>               
                                                    </form>
                                                </li>
                                            </ul>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                           
                        </tbody>
                    </table>
                  
                </div>
            </div>
        </div>

        </div>
    </div>
    @endsection
    @section('css')
<!-- DataTables -->
@if(App::getLocale() != 'ar')
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@else
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap-rtl.css') }}">
@endif
@endsection
@section('js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('.delete_btn').click(function (){
        var id = $(this).attr('data-id');
        var action = $('#delete_form').attr('action');
        var new_action = action.substr(0, action.lastIndexOf('/') + 1) + id;
        $('#delete_form').attr('action', new_action);
    });
   


});
</script>
@endsection
