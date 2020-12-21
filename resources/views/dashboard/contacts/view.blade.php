@extends('dashboard.layouts.app')
@section('title')
{{__('Contacts')}} 
@endsection
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('email') }}</div>
    <div class="panel-body">{{ $contact->email }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('phone') }}</div>
    <div class="panel-body">{{ $contact->phone }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('name') }}</div>
    <div class="panel-body">{{ $contact->name }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Message') }}</div>
    <div class="panel-body">{{ $contact->message }}</div>
</div>
@endsection
@section('css')

@endsection
@section('js')

@endsection