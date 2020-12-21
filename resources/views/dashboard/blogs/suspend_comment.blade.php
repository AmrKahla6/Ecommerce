@extends('dashboard.layouts.app')
@section('title')
   {{__('suspend commentd')}} 
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
                                <th> {{ __('user') }} </th>
                                <th> {{ __('comment') }} </th>
                                <th> {{ __('status') }} </th>
                                <th> {{ __('change status')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($blogs as $blog)
                                @foreach($blog->commentblogs as $comment)
                                    @if($comment->status_id==$status)
                                        <tr>
                                            <td> {{ $blog->id }} </td>
                                            <td>   <a href="{{ route('blogs.show', $blog->id) }}">
                                            {{ $blog->title }} </a> </td>
                                            <td> {{$comment->user_id != null ? $comment->user->name : $comment->email }} </td>
                                            <td> {{ $comment->comment }} </td>
                                            <td> {{ __('pending') }} </td>
                                            <td>
                                                @permission('dash_change_status_0f_comment')
                                                <div class="btn-group">
                                                    <button class="btn btn-xs btn-success" type="button" data-toggle="dropdown" aria-expanded="false">{{ __('change status')}}
                                                        <i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu pull-left" blog="menu">
                                            
                                                        <li>
                                                            <a class="delete_btn" data-id="{{ $comment->id }}" data-toggle="modal" data-target="#active_modal">
                                                                <i class="fa fa-trash"></i> {{ __('active') }} </a>
                                                        </li>
                                                        <!-- <li>
                                                            <a class="delete_btn" data-id="{{ $comment->id }}" data-toggle="modal" data-target="#suspend_modal">
                                                                <i class="fa fa-trash"></i> {{ __('pending') }} </a>
                                                        </li> -->
                                                    
                                                        <li>
                                                            <a class="delete_btn" data-id="{{ $comment->id }}" data-toggle="modal" data-target="#block_modal">
                                                                <i class="fa fa-trash"></i> {{ __('block') }} </a>
                                                        </li>
                                                
                                                    </ul>
                                                </div>
                                                @endpermission
                                            </td>
                                        </tr> 
                                    @endif
                                @endforeach
                            @empty
                            <tr><td colspan="4" class="alert alert-danger">{{ __('No data') }}</td></tr>
                            @endforelse
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
                        <form id="suspend_form" method="POST" action="{{ route('change_status_0f_comment',0) }}">
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
                    <div class="modal-header alert alert-danger">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ __('Are you sure you want to this comment active ?') }}</h4>
                    </div>
                    <div class="modal-footer">
                        <form id="active_form" method="POST" action="{{ route('change_status_0f_comment',0) }}">
                            @csrf
                            <input name="status"  type="hidden" value="active">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Yes, active it!') }}</button>                
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
                        <form id="block_form" method="POST" action="{{ route('change_status_0f_comment',0) }}">
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
</script>
@endsection
