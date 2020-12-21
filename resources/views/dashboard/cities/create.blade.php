@extends('dashboard.layouts.app')
@section('title')
   {{__('create city')}} 
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('cities.store') }}" >
    @csrf
    <div class="form-body">
        @component('input_trans', ['type' => 'text', 'label' => 'Name', 'required' => true])
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
