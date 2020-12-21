
@extends('dashboard.layouts.app')
@section('title')
   {{__('View')}} {{ $blog->title }}
@endsection

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ __('ID') }}</div>
    <div class="panel-body">{{ $blog->id }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('title') }}</div>
    <div class="panel-body">{{ $blog->title }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('description') }}</div>
    <div class="panel-body">{!! $blog->description !!}</div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">{{ __('Image') }}</div>
    <div class="panel-body"><img src="{{ route('image_show', $blog->image) }}" /></div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('status') }}</div>
    <div class="panel-body">{{ $blog->status->name }}</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">{{ __('Order') }}</div>
    <div class="panel-body">{{ $blog->order }}</div>
</div>

@endsection
@section('css')

@endsection
@section('js')

@endsection