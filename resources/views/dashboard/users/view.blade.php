
@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Status') }}</div>
    <div class="panel-body">{{ $user->status->name }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Name') }}</div>
    <div class="panel-body">{{ $user->name_of_owner }}</div>
</div>
@if($user->city)
<div class="panel panel-default">
    <div class="panel-heading">{{ __('city') }}</div>
    <div class="panel-body">{{ $user->city->name }}</div>
</div>
@endif
<div class="panel panel-default">
    <div class="panel-heading">{{ __('address') }}</div>
    <div class="panel-body">{{ $user->address }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('email') }}</div>
    <div class="panel-body">{{ $user->email }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('phone') }}</div>
    <div class="panel-body">{{ $user->phone }}</div>
</div>
@if($user->image)
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Image') }}</div>
    <div class="panel-body">
        <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
            <img src="{{ route('image_show', $user->image) }}" />
        </div>
    </div>
</div>
@endif
<div class="panel panel-default">
    <div class="panel-heading">{{ ucfirst(__('roles')) }}</div>
    <div class="panel-body">
        <div class="row">
        @forelse ($user->roles()->get() as $role)
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">{{ $role->display_name }}</div>
        @empty
            <div class="alert alert-danger">{{ __('No roles') }}</div>
        @endforelse
        </div>
    </div>
</div>

@endsection
@section('css')

@endsection
@section('js')

@endsection