@extends('dashboard.layouts.app')
@section('title')
   {{__('edit')}} 
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('translators.update', $id) }}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-body">
    @foreach($rows['en'] as $key=>$value)
        @if($key)
        <h5>{{$key}}</h5>
            @foreach(LaravelLocalization::getSupportedLocales() as $lang => $properties) 
                @if(isset($rows[$lang][$key]) && !is_array($rows[$lang][$key]))
                    @component('input', ['type' => 'text', 'label' => ucfirst($lang), 'required' => false, 'value' => $rows[$lang][$key]])
                        {{ $lang }}[{{ $key }}]
                    @endcomponent
                @endif
            @endforeach
        @endif
    @endforeach
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-2 col-md-10">
                <button type="rest" class="btn default">{{ __('Cancel')}}</button>
                <button type="submit" class="btn blue">{{ __('Submit')}}</button>
            </div>
        </div>
    </div>
</form>
@endsection
