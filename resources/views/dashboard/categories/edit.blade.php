@extends('dashboard.layouts.app')
@section('title')
   {{__('Edit')}} {{ $category->name }}
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('categories.update', $category->id) }}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-body">
        @component('input_trans', ['type' => 'text', 'label' => 'Name', 'required' => false, 'model' => $category])
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
