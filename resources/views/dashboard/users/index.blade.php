@extends('dashboard.layouts.app')
@section('title', __('Viewing').' '.ucfirst(__('offer')))

@section('content')
    <div class="row">
            <div class="box">
                <div class="box-header">
                    @permission('create_user')
                    <a href="{{ route('users.create') }}"  class="btn btn-primary"> {{ __('Add New')}}
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
                                <th> {{ __('email') }}  </th>
                                <th> {{ __('Role') }}  </th>
                                <th> {{ __('status ') }} </th>
                                <th> {{ __('Actions')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td> {{ $user->id }} </td>
                                <td> {{ $user->name_of_owner }} </td>
                                <td> {{ $user->email }} </td>
                                <td> @foreach($user->roles()->get() as $role){{ $role->display_name }} @if(!$loop->last) , @endif @endforeach</td>
                                <td> {{ $user->status->name }} </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-success" type="button" data-toggle="dropdown" aria-expanded="false">{{ __('Actions')}}
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-left" user="menu">
                                            @permission('view_user')
                                            <li>
                                                <a href="{{ route('users.show', $user->id) }}">
                                                    <i class="fa fa-eye"></i> {{ __('View') }} </a>
                                            </li>
                                            @endpermission
                                            @permission('edit_user')
                                            <li>
                                                <a href="{{ route('users.edit', $user->id) }}">
                                                    <i class="fa fa-pencil-square-o"></i> {{ __('Edit') }} </a>
                                            </li>
                                            @endpermission
                                            @permission('delete_user')
                                            <li>
                                                <a class="delete_btn" data-id="{{ $user->id }}" data-toggle="modal" data-target="#delete_modal">
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
        <div id="delete_modal" class="modal fade" user="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header alert alert-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ __('Are you sure you want to delete ?') }}</h4>
                </div>
                <div class="modal-footer">
                    <form id="delete_form" method="POST" action="{{ route('users.destroy',0) }}">
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
 
    @if(count($users))
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
