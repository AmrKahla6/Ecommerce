@extends('dashboard.layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Email') }}</div>
    <div class="panel-body">{{ $subscripe->email }}</div>
</div>

@endsection
@section('css')

@endsection
@section('js')

@endsection