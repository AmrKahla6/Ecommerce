@extends('dashboard.layouts.app')
@section('title')
   {{__('Edit general setting')}} 
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('save_general_setting') }}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-body">

        @component('input_trans', ['type' => 'text', 'label' => 'terms & condition', 'required' => false, 'model' => $general_setting])
            terms_condition
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'title politic register user', 'required' => false, 'model' => $general_setting])
            title_politic_register_user
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'desc of politic register user', 'required' => false, 'model' => $general_setting])
            desc_of_politic_register_user
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'title politic register company', 'required' => false, 'model' => $general_setting])
            title_politic_register_company
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'desc of politic register company', 'required' => false, 'model' => $general_setting])
            desc_of_politic_register_company
        @endcomponent





        @component('input_trans', ['type' => 'text', 'label' => 'title of div 6 of home section 2', 'required' => false, 'model' => $general_setting])
            title_of_div_6_of_home_section_2
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'desc of div 6 of home section 2', 'required' => false, 'model' => $general_setting])
            desc_of_div_6_of_home_section_2
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'button of div 6 of home section 2', 'required' => false, 'model' => $general_setting])
            button_of_div_6_of_home_section_2
        @endcomponent

        @component('input_trans', ['type' => 'text', 'label' => 'desc_in_above_navbar', 'required' => false, 'model' => $general_setting])
            desc_in_above_navbar
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'get_touch', 'required' => false, 'model' => $general_setting])
            get_touch
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'desc_get_touch', 'required' => false, 'model' => $general_setting])
            desc_get_touch
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'copy_right', 'required' => false, 'model' => $general_setting])
            copy_right
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'title_of_shipping', 'required' => false, 'model' => $general_setting])
            title_of_shipping
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'title_of_fqa', 'required' => false, 'model' => $general_setting])
            title_of_fqa
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'title_of_returns', 'required' => false, 'model' => $general_setting])
            title_of_returns
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'title_of_track_order', 'required' => false, 'model' => $general_setting])
            title_of_track_order
        @endcomponent
      

        @component('input_image', ['width' => 120, 'height' => 27, 'label' => 'logo', 'src' => route('image_show', $general_setting->logo)])
            logo
        @endcomponent
        @component('input', ['type' => 'url', 'label' => 'link_of_track_order', 'required' => true, 'value' => $general_setting->link_of_track_order])
            link_of_track_order
        @endcomponent
        @component('input', ['type' => 'email', 'label' => 'email_above_navbar', 'required' => true, 'value' => $general_setting->email_above_navbar])
            email_above_navbar
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
    $("#logo").change(function() {
        readURL(this, "#logo_image");
    });
});
</script>

@endsection