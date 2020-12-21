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
                            @foreach ($user->products()->where('status','pending')->get() as $product)
                            <?php
                                $company=\App\User::find($product->user_id);
                            ?>
                                <tr>
                                    <td> {{ $product->id }} </td> 
                                    <td> {{ $product->name }} </td> 
                                    <td> {{ $product->pivot->color }} </td>
                                    <td> {{ $product->pivot->size }} </td>
                                    <td> {{ $product->pivot->quantity }} </td>
                                    <td> {{ $product->pivot->position }} </td>
                                    <td> {{ $company->name_of_company }} </td>
                                    <td> {{ $product->pivot->price_of_product }} </td>
                                    <td> {{ $product->pivot->total_of_price_product }} </td>
                                    <td> {{ $product->pivot->method_pay }} </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-xs btn-success" type="button" data-toggle="dropdown" aria-expanded="false">{{ __('change status')}}
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-left" blog="menu">
                                    
                                                <li style="margin-bottom:5px">
                                                    <form id="block_form" method="POST" action="{{ route('had_paid',$product->id) }}">
                                                        @csrf
                                                        <input name="color"  type="hidden" value="{{ $product->pivot->color }}">
                                                        <input name="size"  type="hidden" value="{{ $product->pivot->size }}">
                                                        <input name="quantity"  type="hidden" value="{{ $product->pivot->quantity }}">
                                                        <input name="price_of_product"  type="hidden" value="{{ $product->pivot->price_of_product }}">
                                                        <input name="total_of_price_product"  type="hidden" value="{{ $product->pivot->total_of_price_product }}">
                                                        <input name="method_pay"  type="hidden" value="{{ $product->pivot->method_pay }}">
                                                        <input name="position"  type="hidden" value="{{ $product->pivot->position }}">
                                                        <input name="product"  type="hidden" value="{{$product->id}}">
                                                        <input name="user"  type="hidden" value="{{$user->id}}">
                                                        <a><button type="submit" class="btn btn-danger">{{ __('had paid') }}</button>  </a>               
                                                    </form>
                                                </li>
                                                <li style="margin-bottom:5px">
                                                    <form id="block_form" method="POST" action="{{ route('not_paid_with_deduct',$product->id) }}">
                                                        @csrf
                                                        <input name="color"  type="hidden" value="{{ $product->pivot->color }}">
                                                        <input name="size"  type="hidden" value="{{ $product->pivot->size }}">
                                                        <input name="quantity"  type="hidden" value="{{ $product->pivot->quantity }}">
                                                        <input name="price_of_product"  type="hidden" value="{{ $product->pivot->price_of_product }}">
                                                        <input name="total_of_price_product"  type="hidden" value="{{ $product->pivot->total_of_price_product }}">
                                                        <input name="method_pay"  type="hidden" value="{{ $product->pivot->method_pay }}">
                                                        <input name="position"  type="hidden" value="{{ $product->pivot->position }}">
                                                        <input name="product"  type="hidden" value="{{$product->id}}">
                                                        <input name="user"  type="hidden" value="{{$user->id}}">
                                                        <a><button type="submit" class="btn btn-danger">{{ __('Not paid with deducted') }}</button>  </a>               
                                                    </form>
                                                </li>
                                            
                                                <li>
                                                    <form id="block_form" method="POST" action="{{ route('not_paid_no_deduct',$product->id) }}">
                                                        @csrf
                                                        <input name="color"  type="hidden" value="{{ $product->pivot->color }}">
                                                        <input name="size"  type="hidden" value="{{ $product->pivot->size }}">
                                                        <input name="quantity"  type="hidden" value="{{ $product->pivot->quantity }}">
                                                        <input name="price_of_product"  type="hidden" value="{{ $product->pivot->price_of_product }}">
                                                        <input name="total_of_price_product"  type="hidden" value="{{ $product->pivot->total_of_price_product }}">
                                                        <input name="method_pay"  type="hidden" value="{{ $product->pivot->method_pay }}">
                                                        <input name="position"  type="hidden" value="{{ $product->pivot->position }}">
                                                        <input name="product"  type="hidden" value="{{$product->id}}">
                                                        <input name="user"  type="hidden" value="{{$user->id}}">
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
