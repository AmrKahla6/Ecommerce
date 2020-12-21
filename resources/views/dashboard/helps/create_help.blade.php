

@extends('dashboard.layouts.app')
@section('title')
   {{__('create')}} {{ $type }}
@endsection
@section('content')

<form role="form" class="form-horizontal" method="POST" action="{{ route('save_help') }}" >
    @csrf
    <div class="form-body">
        @component('input_trans', ['type' => 'text', 'label' => 'question', 'required' => true])
            question
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'answer', 'required' => true])
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
@section('css')

@endsection
@section('js')

@endsection


