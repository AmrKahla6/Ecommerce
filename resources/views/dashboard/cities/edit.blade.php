@extends('dashboard.layouts.app')
@section('title')
   {{__(Edit')}} {{ city->name }}
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('cities.update',$city->id) }}" >
    @csrf
    @method('PUT')
    <div class="form-body">
        @component('input_trans', ['type' => 'text', 'label' => 'title', 'required' => false, 'model' => $city])
            name
        @endcomponent
    </div>
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