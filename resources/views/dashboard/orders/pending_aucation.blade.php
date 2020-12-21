@extends('dashboard.layouts.app')
@section('title')
   {{__('pending order aucations')}} 
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
                                <th> {{ __('company') }} </th>
                                <th> {{ __('price') }} </th>
                                <th> {{ __('method pay')}} </th>
                                <th> {{ __('Actions')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aucations as $aucation)
                            <?php
                                $buyer=\App\User::find($aucation->buyer_id);
                                $company=\App\User::find($aucation->user_id);

                                $prices =[];
                                $status_active=\App\Status::where('slug','active')->firstOrFail();
                                if(count($aucation->commentsaucations()->where('status_id',$status_active->id)->get() )){
                                    foreach($aucation->commentsaucations()->where('status_id',$status_active->id)->get() as $comment){
                                        $prices[]=$comment->price;
                                    }
                                    $max_price          = max($prices);
                                }
                            ?>
                                <tr>
                                    <td> {{ $aucation->id }} </td> 
                                    <td> {{ $aucation->title }} </td> 
                                    <td> {{ $buyer->name_of_owner }} </td> 
                                    <td> {{ $company->name_of_company }} </td> 
                                  
                                    <td> {{ $max_price }} </td>
                                    <td> {{ $aucation->method_pay }} </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-xs btn-success" type="button" data-toggle="dropdown" aria-expanded="false">{{ __('change status')}}
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-left" blog="menu">
                                                <li style="margin-bottom:5px">
                                                    <form id="block_form" method="POST" action="{{ route('change_status_aucation',$aucation->id) }}">
                                                        @csrf
                                                        <a><button type="submit" class="btn btn-danger">{{ __('Delivered') }}</button>  </a>               
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
