@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection
@section('content')
    <form method="post" action="{{ route('setting.update', $setting->id) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        @foreach(LaravelLocalization::getSupportedLocales() as $locale => $prop)
        <div class="form-group">
            <label for="title">title:{{ $locale }} </label>
            <input type="text"  value="{{ $setting->title }}" name="title[{{ $locale }}]" class="form-control" id="title_{{ $locale }}" placeholder="title">
        </div>
        @endforeach
        @foreach(LaravelLocalization::getSupportedLocales() as $locale => $prop)
        <div class="form-group">
            <label for="desc">desc:{{ $locale }}</label>
            <input type="textArea"  value="{{ $setting->description }}" name="description[{{ $locale }}]" class="form-control" id="desc_{{ $locale }}" placeholder="description">
        </div>
        @endforeach
        <img src="" width="20%" height="10%" class="img-responsive"/>
        <div class="form-group">
            <label for="exampleInputFile"> logo File </label>
            <input type="file"  name="image" >
        </div>
        <div class="form-group">
            <label for="desc">order:</label>
            <input type="number"  value="{{ $setting->order }}" name="order" class="form-control" id="order" placeholder="order">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection