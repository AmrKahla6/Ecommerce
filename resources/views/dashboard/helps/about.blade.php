@extends('dashboard.layouts.app')
@section('title')
   {{__('about')}} 
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('save_about') }}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-body">
        @component('input_trans', ['type' => 'text', 'label' => 'title', 'required' => false, 'model' => $about])
            title
        @endcomponent
        @component('input_trans', ['type' => 'textarea', 'class' => 'ckeditor',  'label' => 'description', 'required' => false, 'model' => $about])
            description
        @endcomponent
        @component('input_trans', ['type' => 'textarea',  'label' => 'why choose us', 'required' => false, 'model' => $about])
            why_choose
        @endcomponent
      

        @component('input_trans', ['type' => 'text', 'label' => 'why choose title 1', 'required' => false, 'model' => $about])
            why_choose_title_1
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'why choose desc 1', 'required' => false, 'model' => $about])
            why_choose_desc_1
        @endcomponent
        @component('input', ['type' => 'text', 'label' => 'image', 'required' => false, 'value' => $about->why_choose_image_1])
            why_choose_image_1
        @endcomponent

        @component('input_trans', ['type' => 'text', 'label' => 'why choose title 2', 'required' => false, 'model' => $about])
            why_choose_title_2
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'why choose desc 2', 'required' => false, 'model' => $about])
            why_choose_desc_2
        @endcomponent
        @component('input', ['type' => 'text', 'label' => 'image', 'required' => false, 'value' => $about->why_choose_image_2])
            why_choose_image_2
        @endcomponent

        @component('input_trans', ['type' => 'text', 'label' => 'why choose title 3', 'required' => false, 'model' => $about])
            why_choose_title_3
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'why choose desc 3', 'required' => false, 'model' => $about])
            why_choose_desc_3
        @endcomponent
        @component('input', ['type' => 'text', 'label' => 'image', 'required' => false, 'value' =>$about->why_choose_image_3])
            why_choose_image_3
        @endcomponent

        @component('input_trans', ['type' => 'text', 'label' => 'why choose title 4', 'required' => false, 'model' => $about])
            why_choose_title_4
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'why choose desc 4', 'required' => false, 'model' => $about])
            why_choose_desc_4
        @endcomponent
        @component('input', ['type' => 'text', 'label' => 'image', 'required' => false, 'value' =>$about->why_choose_image_4])
            why_choose_image_4
        @endcomponent


        @component('input_image', ['width' => 1920, 'height' => 239, 'label' => 'cover', 'src' => route('image_show', $about->cover)])
            cover
        @endcomponent
        @component('input_image', ['width' => 720, 'height' => 866, 'label' => 'image', 'src' => route('image_show', $about->image)])
            image
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
    $("#cover").change(function() {
        readURL(this, "#cover_image");
    });
});
</script>

@endsection