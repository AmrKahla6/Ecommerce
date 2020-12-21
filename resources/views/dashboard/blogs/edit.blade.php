@extends('dashboard.layouts.app')
@section('title')
   {{__('edit')}} {{ $blog->title }}
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('blogs.update', $blog->id) }}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-body">
        @component('input_trans', ['type' => 'text', 'label' => 'title', 'required' => false, 'model' => $blog])
            title
        @endcomponent

        @component('input_trans', ['type' => 'textarea', 'class' => 'ckeditor',  'label' => 'description', 'required' => false, 'model' => $blog])
            description
        @endcomponent
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label">{{ __('status') }} <span class="required">*</span></label>
            <div class="col-md-10">
                <select class="js-example-basic-single js-states form-control" id="blog" name="status">
                    @foreach($statuses as $status)
                    <option value="{{ $status->id }}" >{{ $status->name }}</option>
                    @endforeach
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>

        @component('input_image', ['width' => 200, 'height' => 200, 'label' => 'Image', 'src' => route('image_show', $blog->image)])
            image
        @endcomponent
        @component('input', ['type' => 'number', 'label' => 'Order', 'required' => true, 'value' => $blog->order])
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