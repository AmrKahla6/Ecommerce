@extends('dashboard.layouts.app')
@section('title')
   {{__('create category')}} 
@endsection
@section('content')

<form role="form" class="form-horizontal" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
    @csrf
  
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $prop)
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label" >{{ __('Name')}}:{{ $locale }} <span class="required">*</span> </label>
            <div class="col-md-10">
                <input type="text" class="form-control"  rows="3"  name="name[{{ $locale }}]">
                <div class="form-control-focus"> </div>
            </div>
        </div>
    @endforeach
  
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-2 col-md-10">
                <button type="rest" class="btn btn-default">{{ __('Cancel')}}</button>
                <button type="submit" class="btn btn-primary">{{ __('Submit')}}</button>
            </div>
        </div>
    </div>
</form>

@endsection
