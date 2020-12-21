
@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Name') }}</div>
    <div class="panel-body">{{ $role->name }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Display Name') }}</div>
    <div class="panel-body">{{ $role->display_name }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Description') }}</div>
    <div class="panel-body">{{ $role->description }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ ucfirst(__('permissions')) }}</div>
    <div class="panel-body">
        <div class="row">
        @forelse ($role->permissions()->get() as $permission)
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">{{ $permission->display_name }}</div>
        @empty
            <div class="alert alert-danger">{{ __('No permissions') }}</div>
        @endforelse
        </div>
    </div>
</div>
@endsection
@section('css')

@endsection
@section('js')

@endsection