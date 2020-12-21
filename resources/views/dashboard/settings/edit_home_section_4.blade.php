@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{route('save_edit_home_section_4')}}"  >
    @csrf
    @method('PUT')
    <div class="form-body">
        @if(isset($homesection4))
            @component('input', ['type' => 'number', 'label' => 'write id of product', 'required' => false, 'value' => $homesection4->product_id])
                product_id
            @endcomponent
            @component('input', ['type' => 'number', 'label' => 'write id of aucation', 'required' => false, 'value' => $homesection4->aucation_id])
                aucation_id
            @endcomponent
            @component('input', ['type' => 'number', 'label' => 'write id of aggregation', 'required' => false, 'value' => $homesection4->aggregation_id])
                aggregation_id
            @endcomponent
        @else
            @component('input', ['type' => 'number', 'label' => 'write id of product', 'required' => false])
                product_id
            @endcomponent
            @component('input', ['type' => 'number', 'label' => 'write id of aucation', 'required' => false])
                aucation_id
            @endcomponent
            @component('input', ['type' => 'number', 'label' => 'write id of aggregation', 'required' => false])
                aggregation_id
            @endcomponent
        @endif
  
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
