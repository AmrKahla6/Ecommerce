@extends('dashboard.layouts.app')
@section('title')
   {{__('create blog')}} 
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-body">
        @component('input_trans', ['type' => 'text', 'label' => 'title', 'required' => true])
            title
        @endcomponent

        @component('input_trans', ['type' => 'textarea', 'label' => 'description', 'required' => true, 'class' => 'ckeditor'])
            description
        @endcomponent
        @component('input_image', ['width' => 550, 'height' => 280, 'label' => 'Image'])
            image
        @endcomponent
      
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label">{{ __('status') }} <span class="required">*</span></label>
            <div class="col-md-10">
                <select class="js-example-basic-single js-states form-control" id="status" name="status">
                    @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ old('status') == $status->id ? 'selected' : '' }} >{{ $status->name }}</option>
                    @endforeach
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>
   
        @component('input', ['type' => 'number', 'label' => 'Order', 'required' => true])
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
@section('css')

@endsection
@section('js')
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
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