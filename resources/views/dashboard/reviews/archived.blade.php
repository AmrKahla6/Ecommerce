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
                                <th> {{ __('product') }} </th>
                                <th> {{ __('user') }} </th>
                                <th> {{ __('review') }} </th>
                                <th> {{ __('points') }} </th>
                                <th> {{ __('status')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                           
                                @foreach($reviews as $review)
                                <?php 
                                    $user=\App\User::find($review->user_id);
                                    $product=\App\Product::find($review->product_id);
                                ?>
                                        <tr>
                                            <td> {{ $review->id }} </td>
                                            <td> {{ $product->name }} </td>
                                            <td> {{ $user->name_of_owner }} </td>
                                            <td> {{ $review->review }} </td>
                                            <td> {{ $review->number_of_points }} </td>
                                            <td> {{ $review->status }} </td>
                                       
                                        </tr> 
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="suspend_modal" class="modal fade" blog="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header alert alert-danger">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ __('Are you sure you want to this comment suspend  ?') }}</h4>
                    </div>
                    <div class="modal-footer">
                        <form id="suspend_form" method="POST" action="{{ route('change_status_0f_review',0) }}">
                            @csrf
                            <input name="status" type="hidden" value="pending">

                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Yes, pending it!') }}</button>                
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div id="active_modal" class="modal fade" blog="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header alert alert-succeess">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ __('Are you sure you want to this comment active ?') }}</h4>
                    </div>
                    <div class="modal-footer">
                        <form id="active_form" method="POST" action="{{ route('change_status_0f_review',0) }}">
                            @csrf
                            <input  name="status"  type="hidden" value="active">
                            <input style="margin-bottom:20px;width:70%" class="form-control" name="number_of_points"  type="number" placeholder="number of points..." >
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-success">{{ __('Yes, active it!') }}</button>                
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div id="block_modal" class="modal fade" blog="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header alert alert-danger">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ __('Are you sure you want to this comment block ?') }}</h4>
                    </div>
                    <div class="modal-footer">
                        <form id="block_form" method="POST" action="{{ route('change_status_0f_review',0) }}">
                            @csrf
                            <input name="status"  type="hidden" value="block">
                          
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Yes, block it!') }}</button>                
                        </form>
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
        var action = $('#suspend_form').attr('action');
        var new_action = action.substr(0, action.lastIndexOf('/') + 1) + id;
        $('#suspend_form').attr('action', new_action);
    });

    $('.delete_btn').click(function (){
        var id = $(this).attr('data-id');
        var action = $('#active_form').attr('action');
        var new_action = action.substr(0, action.lastIndexOf('/') + 1) + id;
        $('#active_form').attr('action', new_action);
    });

    $('.delete_btn').click(function (){
        var id = $(this).attr('data-id');
        var action = $('#block_form').attr('action');
        var new_action = action.substr(0, action.lastIndexOf('/') + 1) + id;
        $('#block_form').attr('action', new_action);
    });


});
@if(count($reviews))
        $("#example1").DataTable(
            @if(App::getLocale() == 'ar')
            {
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
                }
            }
            @endif
        );
    @endif
</script>
@endsection
