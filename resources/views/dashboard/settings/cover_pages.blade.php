@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{route('save_coverPages')}}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-body">
        @component('input_image', ['width' => 1400, 'height' => 300, 'label' => 'cover favourite', 'src' => route('image_show', $cover_pages->cover_favourite)])
            cover_favourite 
        @endcomponent
        @component('input_image', ['width' => 1400, 'height' => 300, 'label' => 'cover Testimations', 'src' => route('image_show', $cover_pages->cover_footer)])
            cover_testimations
        @endcomponent
        @component('input_image', ['width' => 1400, 'height' => 300, 'label' => 'cover blog', 'src' => route('image_show', $cover_pages->cover_blog)])
            cover_blog
        @endcomponent
        @component('input_image', ['width' => 1400, 'height' => 300, 'label' => 'cover blog deatails', 'src' => route('image_show', $cover_pages->cover_blog_deatails)])
            cover_blog_deatails
        @endcomponent
        @component('input_image', ['width' => 1400, 'height' => 300, 'label' => 'cover checkout', 'src' => route('image_show', $cover_pages->cover_checkout)])
            cover_checkout
        @endcomponent
        @component('input_image', ['width' => 1400, 'height' => 300, 'label' => 'cover cart', 'src' => route('image_show', $cover_pages->cover_cart)])
            cover_cart
        @endcomponent
        @component('input_image', ['width' => 1400, 'height' => 300, 'label' => 'cover contact', 'src' => route('image_show', $cover_pages->cover_contact)])
            cover_contact
        @endcomponent
        @component('input_image', ['width' => 1400, 'height' => 300, 'label' => 'cover login', 'src' => route('image_show', $cover_pages->cover_login)])
            cover_login
        @endcomponent
        @component('input_image', ['width' => 1400, 'height' => 300, 'label' => 'cover shop', 'src' => route('image_show', $cover_pages->cover_shop)])
            cover_shop
        @endcomponent
        @component('input_image', ['width' => 1400, 'height' => 300, 'label' => 'cover product details', 'src' => route('image_show', $cover_pages->cover_product_details)])
            cover_product_details
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
    $("#cover_product_details").change(function() {
        readURL(this, "#cover_product_details_image");
    });
    $("#cover_testimations").change(function() {
        readURL(this, "#cover_testimations_image");
    });
    $("#cover_favourite").change(function() {
        readURL(this, "#cover_favourite_image");
    });
    $("#cover_blog").change(function() {
        readURL(this, "#cover_blog_image");
    });
    $("#cover_blog_deatails").change(function() {
        readURL(this, "#cover_blog_deatails_image");
    });
    $("#cover_cart").change(function() {
        readURL(this, "#cover_cart_image");
    });
    $("#cover_checkout").change(function() {
        readURL(this, "#cover_checkout_image");
    });
    $("#cover_contact").change(function() {
        readURL(this, "#cover_contact_image");
    });
    $("#cover_shop").change(function() {
        readURL(this, "#cover_shop_image");
    });
    $("#cover_login").change(function() {
        readURL(this, "#cover_login_image");
    });
});
</script>

@endsection