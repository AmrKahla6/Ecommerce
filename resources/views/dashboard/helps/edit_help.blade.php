@extends('dashboard.layouts.app')
@section('title')
   {{__('ُEdit')}} {{ $type }}
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('save_edit_helps', $value->id) }}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-body">
        @component('input_trans', ['type' => 'text', 'label' => 'question', 'required' => false, 'model' => $value])
            question
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'answer', 'required' => false, 'model' => $value])
            answer
        @endcomponent
        <input type="hidden" value="{{ $type }}" name="kind_of_type">
     
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
@section('js')

@endsection