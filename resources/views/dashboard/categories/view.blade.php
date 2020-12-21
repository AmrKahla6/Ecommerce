
@extends('dashboard.layouts.app')
@section('title')
   {{__('View')}} {{ $category->name }}
@endsection

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('ID') }}</div>
    <div class="panel-body">{{ $category->id }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Name') }}</div>
    <div class="panel-body">{{ $category->name }}</div>
</div>



@endsection
@section('css')

@endsection
@section('js')

@endsection