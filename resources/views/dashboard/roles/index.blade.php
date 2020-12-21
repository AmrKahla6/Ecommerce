@extends('dashboard.layouts.app')
@section('title')
   create role
@endsection
@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">
                    @permission('index_user') 
                    <a href="{{ route('roles.create') }}"  class="btn btn-primary"> {{ __('Add New')}}
                        <i class="fa fa-plus"></i>
                    </a>
                    @endpermission 
            
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered" id="example1">  
                    <thead>
                        <tr>
                            <th> {{ __('ID') }} </th>
                            <th> {{ __('Name') }} </th>
                            <th> {{ __('Display Name') }}  </th>
                            <th> {{ __('Actions')}} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                        <tr>
                            <td> {{ $role->id }} </td>
                            <td> {{ $role->name }} </td>
                            <td> {{ $role->display_name }} </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-xs btn-success" type="button" data-toggle="dropdown" aria-expanded="false">{{ __('Actions')}}
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-left" role="menu">
                                        @permission('view_role')
                                        <li>
                                            <a href="{{ route('roles.show', $role->id) }}">
                                                <i class="fa fa-eye"></i> {{ __('View') }} </a>
                                        </li>
                                        @endpermission
                                        @permission('edit_role')
                                        <li>
                                            <a href="{{ route('roles.edit', $role->id) }}">
                                                <i class="fa fa-pencil-square-o"></i> {{ __('Edit') }} </a>
                                        </li>
                                        @endpermission
                                        @permission('delete_role')
                                        <li>
                                            <a class="delete_btn" data-id="{{ $role->id }}" data-toggle="modal" data-target="#delete_modal">
                                                <i class="fa fa-trash"></i> {{ __('Delete') }} </a>
                                        </li>
                                        @endpermission
                                   
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
    <div id="delete_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header alert alert-danger">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ __('Are you sure you want to delete ?') }}</h4>
            </div>
            <div class="modal-footer">
                <form id="delete_form" method="POST" action="{{ route('roles.destroy',0) }}">
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
@section('js')
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

