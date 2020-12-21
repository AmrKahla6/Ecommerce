@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection
@section('content')
<div class="row">
    <div class="box">
        <div class="box-header">
          
                <a href="{{ route('social_settings.create') }}"  class="btn btn-primary"> {{ __('Add New')}}
                    <i class="fa fa-plus"></i>
                </a>
          
        </div>
        <div class="box-body">
            <table class="table table-striped table-bordered" id="example1">  
                <thead>
                    <tr>
                        <th> {{ __('url') }} </th>
                        <th> {{ __('icon') }} </th>
                        <th> {{ __('Actions')}} </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($socials as $social)
                    <tr>
                        <td> <a href="{{ $social->url }}" target="_blank"> {{ $social->url }} </a></td>
                        <td> <i class="fa fa-{{ $social->icon }}" aria-hidden="true"></i> </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-xs btn-success" type="button" data-toggle="dropdown" aria-expanded="false">{{ __('Actions')}}
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-left" role="menu">
                              
                                    @permission('view_social')
                                    <li>
                                        <a href="{{ route('social_settings.show', $social->id) }}">
                                            <i class="fa fa-eye"></i> {{ __('View') }} </a>
                                    </li>
                                    @endpermission
                                    @permission('edit_social')
                                    <li>
                                        <a href="{{ route('social_settings.edit', $social->id) }}">
                                            <i class="fa fa-pencil-square-o"></i> {{ __('Edit') }} </a>
                                    </li>
                                    @endpermission
                                    @permission('delete_social')
                                    <li>
                                        <a class="delete_btn" data-id="{{ $social->id }}" data-toggle="modal" data-target="#delete_modal">
                                            <i class="fa fa-trash"></i> {{ __('Delete') }} </a>
                                    </li>
                                    @endpermission
                                 
                                </ul>
                            </div>
                        </td>
                    </tr> 
                    @empty
                    <tr><td colspan="7" class="alert alert-danger">{{ __('No data') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="delete_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header alert alert-danger">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ __('Are you sure you want to delete ?') }}</h4>
            </div>
            <div class="modal-footer">
                <form id="delete_form" method="POST" action="{{ route('social_settings.destroy', 0) }}">
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
    @if(count($socials) > 0)
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
});
</script>
@endsection