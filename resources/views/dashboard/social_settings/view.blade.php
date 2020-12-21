@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('URL') }}</div>
    <div class="panel-body">{{ $social->url }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Icon') }}</div>
    <div class="panel-body"><i class="fa fa-{{ $social->icon }}" aria-hidden="true"></i></div>
</div>
@endsection
@section('css')

@endsection
@section('js')

@endsection