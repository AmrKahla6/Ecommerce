@extends('dashboard.layouts.app')
@section('title')
   {{__('pending order aggregations')}} 
@endsection
@section('content')
    <div class="row">
            <div class="box">
              
                <div class="box-body">
                    <table class="table table-striped table-bordered" id="example1">  
                        <thead>
                            <tr>
                                <th> {{ __('ID') }} </th>
                                <th> {{ __('title') }} </th>
                                <th> {{ __('Purchaser') }} </th>
                                <th> {{ __('company') }} </th>
                                <th> {{ __('price') }} </th>
                                <th> {{ __('quantity') }} </th>
                                <th> {{ __('method pay')}} </th>
                                <th> {{ __('Actions')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aggregations as $aggregation)
                            @foreach ($aggregation->aggregationgroups()->where('status_pay','pending')->get() as $agg_group)
                            <?php
                                $Purchaser=\App\User::find($agg_group->user_id);
                                $company=\App\User::find($aggregation->user_id);

                                $price_in_dollar	    =($aggregation->price * $agg_group->user_quantity) / $aggregation->currency->contain_in_dollar ;
                                $package				=\App\Package::first();
                                $currency				=\App\Currency::find($package->currency_id);
                                $point_in_dollar		=$package->price/$currency->contain_in_dollar;
                                $number_of_points		=$price_in_dollar / $point_in_dollar;
                                $currency_aggregation   =\App\Currency::find($aggregation->currency_id);
                            ?>
                                <tr>
                                    <td> {{ $aggregation->id }} </td> 
                                    <td> {{ $aggregation->title }} </td> 
                                    <td> {{ $Purchaser->name_of_owner }} </td> 
                                    <td> {{ $company->name_of_company }} </td> 
                                  
                                    <td> {{ $agg_group->user_quantity * $aggregation->price }} </td>
                                    <td> {{ $agg_group->user_quantity }} </td>
                                    <td> {{ $agg_group->method_pay }} </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-xs btn-success" type="button" data-toggle="dropdown" aria-expanded="false">{{ __('change status')}}
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-left" blog="menu">
                                                <li style="margin-bottom:5px">
                                                    <form id="block_form" method="POST" action="{{ route('change_status_aggregation_group',$agg_group->id) }}">
                                                        @csrf
                                                        <input type="hidden" name="number_of_points"  value="{{ceil($number_of_points)}}">
                                                        <a><button type="submit" class="btn btn-danger">{{ __('Delivered') }}</button>  </a>               
                                                    </form>
                                                </li>
                                                <li style="margin-bottom:5px">
                                                    <form id="block_form" method="POST" action="{{ route('change_status_aggregation_group_with_no_deduct',$agg_group->id) }}">
                                                        @csrf
                                                        <input type="hidden" name="user_quantity"  value="{{$agg_group->user_quantity }}">
                                                        <input type="hidden" name="number_of_points"  value="{{ceil($number_of_points)}}">
                                                        <a><button type="submit" class="btn btn-danger">{{ __('failed with no deduct') }}</button>  </a>               
                                                    </form>
                                                </li>
                                             
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
