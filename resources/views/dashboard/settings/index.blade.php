@extends('dashboard.layouts.app')
@section('title', __('Viewing').' '.ucfirst(__('offer')))

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">title</div>
        <div class="panel-body">{{ $setting->title }}</div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">description</div>
        <div class="panel-body">{{ $setting->description }}</div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">order</div>
        <div class="panel-body">{{ $setting->order }}</div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Image</div>
        <div class="panel-body"><img src="{{ route('image_show', $setting->image) }}" /></div>
    </div>
@endsection
@section('css')

@endsection
@section('js')

@endsection
