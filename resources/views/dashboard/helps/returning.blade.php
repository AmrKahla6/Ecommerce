@extends('dashboard.layouts.app')
@section('title')
   {{__('returning')}} 
@endsection
@section('content')
    <div class="row">
            <div class="box">
                <div class="box-header">
                    <form id="delete_form" method="POST" action="{{ route('create_helps') }}">
                        @csrf
                        <input type="hidden" value="returning" name="type">
                        <button type="submit" class="btn btn-primary">{{ __('Add New')}}</button>                
                    </form>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered" id="example1">  
                        <thead>
                            <tr>
                                <th> {{ __('ID') }} </th>
                                <th> {{ __('question') }} </th>
                                <th> {{ __('Actions')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($returning as $value)
                            <tr>
                                <td> {{ $value->id }} </td>
                                <td> {{ $value->question }} </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-success" type="button" data-toggle="dropdown" aria-expanded="false">{{ __('Actions')}}
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-left" subcategory="menu">
                                            <li>
                                                <form id="delete_form" method="POST" action="{{ route('delete_helps',$value->id) }}">
                                                    @csrf
                                                    <input type="hidden" value="returning" name="type">
                                                    <button type="submit" class="btn btn-danger">{{ __('delete')}}</button>                
                                                </form>
                                            </li>
                                            <li>
                                                <form id="delete_form" method="POST" action="{{ route('edit_helps',$value->id) }}">
                                                    @csrf
                                                    <input type="hidden" value="returning" name="type">
                                                    <button type="submit" class="btn btn-success">{{ __('edit')}}</button>                
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr> 
                            @empty
                            <tr><td colspan="4" class="alert alert-danger">{{ __('No data') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="delete_modal" class="modal fade" subcategory="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header alert alert-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ __('Are you sure you want to delete ?') }}</h4>
                </div>
                <div class="modal-footer">
                    <form id="delete_form" method="POST" action="{{ route('currencies.destroy',0) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Yes, delete it!') }}</button>                
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
        var action = $('#delete_form').attr('action');
        var new_action = action.substr(0, action.lastIndexOf('/') + 1) + id;
        $('#delete_form').attr('action', new_action);
    });
 

});
    @if(count($returning))
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
