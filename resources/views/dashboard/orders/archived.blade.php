@extends('dashboard.layouts.app')
@section('title', __('Viewing').' '.ucfirst(__('offer')))

@section('content')
    <div class="row">
            <div class="box">
              
                <div class="box-body">
                    <table class="table table-striped table-bordered" id="example1">  
                        <thead>
                            <tr>
                                <th> {{ __('ID') }} </th>
                                <th> {{ __('Name') }} </th>
                                <th> {{ __('color') }} </th>
                                <th> {{ __('size')}} </th>
                                <th> {{ __('quantity') }} </th>
                                <th> {{ __('position')}} </th>
                                <th> {{ __('company') }} </th>
                                <th> {{ __('price') }} </th>
                                <th> {{ __('total price') }} </th>
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
                                            <ul class="dropdown-menu pull-left" blog="menu">
                                    
                                                <li style="margin-bottom:5px">
                                                    <form id="block_form" method="POST" action="{{ route('had_paid',$product->id) }}">
                                                        @csrf
                                                        <input name="order"  type="hidden" value="{{ $order->id }}">
                                                        <a><button type="submit" class="btn btn-danger">{{ __('had paid') }}</button>  </a>               
                                                    </form>
                                                </li>
                                                <li style="margin-bottom:5px">
                                                    <form id="block_form" method="POST" action="{{ route('not_paid_with_deduct',$product->id) }}">
                                                        @csrf
                                                        <input name="order"  type="hidden" value="{{ $order->id }}">
                                                        <a><button type="submit" class="btn btn-danger">{{ __('Not paid with deducted') }}</button>  </a>               
                                                    </form>
                                                </li>
                                            
                                                <li>
                                                    <form id="block_form" method="POST" action="{{ route('not_paid_no_deduct',$product->id) }}">
                                                        @csrf
                                                        <input name="order"  type="hidden" value="{{ $order->id }}">
                                                        <a><button type="submit" class="btn btn-danger">{{ __('Not paid with no deducted') }}</button>  </a>               
                                                    </form>
                                                </li>
                                        
                                            </ul>
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
