
@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('ID') }}</div>
    <div class="panel-body">{{ $subcategory->id }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Name') }}</div>
    <div class="panel-body">{{ $subcategory->name }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('description') }}</div>
    <div class="panel-body">{{ $subcategory->description }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Order') }}</div>
    <div class="panel-body">{{ $subcategory->order }}</div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">{{ __('Category') }}</div>
    <div class="panel-body">{{ $subcategory->category->name }}</div>
</div>

@endsection
@section('css')

@endsection
@section('js')

@endsection