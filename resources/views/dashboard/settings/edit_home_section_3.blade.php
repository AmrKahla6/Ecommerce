@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{route('save_edit_home_section_3')}}"  >
    @csrf
    @method('PUT')
    <div class="form-body">
      
        @component('input_trans', ['type' => 'text', 'label' => 'title', 'required' => false, 'model' => $homesection3])
            title
        @endcomponent
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label">{{ __('type') }} <span class="required">*</span></label>
            <div class="col-md-10">
                <select class="js-example-basic-single js-states form-control" id="type" name="type">
                    <option value="sale" {{ old('type') == 'sale' || $homesection3->type == 'sale' ? 'selected' : '' }} >sale</option>
                    <option value="new_arrival" {{ old('type') == 'new_arrival' || $homesection3->type == 'new_arrival' ? 'selected' : '' }} >new arrival</option>
                    <option value="offer" {{ old('type') == 'offer' || $homesection3->type == 'offer' ? 'selected' : '' }} >offer</option>                    
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>
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
