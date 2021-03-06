@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('subcategories.update', $subcategory->id) }}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-body">
        @component('input_trans', ['type' => 'text', 'label' => 'Name', 'required' => false, 'model' => $subcategory])
            name
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'description', 'required' => false, 'model' => $subcategory])
            description
        @endcomponent
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label">{{ __('subcategory') }} <span class="required">*</span></label>
            <div class="col-md-10">
                <select class="js-example-basic-single js-states form-control" id="subcategory" name="category">
                    @foreach($categories as $category) 
                    <option value="{{ $category->id }}" {{ old('category') == $category->id || $subcategory->category_id == $category->id ? 'selected' : '' }} >{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>

        @component('input', ['type' => 'number', 'label' => 'Order', 'required' => true, 'value' => $subcategory->order])
            order
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
@section('js')
<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
        function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(id).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image").change(function() {
        readURL(this, "#image_image");
    });
});
</script>
@endsection