@extends('dashboard.layouts.app')
@section('title')
{{__('Edit Product')}}
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('products.update', $product->id) }}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @php
        $translation_en = $product->translateOrDefault("en");
        $translation_ar = $product->translateOrDefault("ar");
    @endphp
    <div class="form-body">
 
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label" >{{ __('name:ar')}}<span class="required">*</span> </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="name[ar]"  dir="rtl"   @if( isset($translation_ar->name)) value='{!! $translation_ar->name !!}' @endif>
                <div class="form-control-focus"> </div>
            </div>
        </div>
  
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label" >{{ __('name:en')}}<span class="required">*</span> </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="name[en]"   @if( isset($translation_en->name)) value='{!! $translation_en->name !!}' @endif>
                <div class="form-control-focus"> </div>
            </div>
        </div>

        @component('input_trans', ['type' => 'textarea', 'class' => 'ckeditor',  'label' => 'description', 'required' => false, 'model' => $product])
            description
        @endcomponent
   
    
        @component('input_image', ['width' => 200, 'height' => 200, 'label' => 'Image','multiple' => 'true', 'src' => route('image_show', $product->image)])
            image
        @endcomponent
        @if($product->video)
        <div class="panel panel-default">
            <div class="panel-heading">{{ __('video') }}</div>
            <video class="video-fluid" width="100%" height="400px" controls>
                <source src="{{ route('file_show', $product->video) }}" />
            </video>
        </div>
        @endif

 
      
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label">{{ __('category') }} <span class="required">*</span></label>
            <div class="col-md-10">
                <select class="js-example-basic-single js-states form-control" id="category" name="category">
                    @foreach(\App\Category::all() as $category)
                    <option value="{{ $category->id }}" {{ old('category') == $category->id || $p_category->id == $category->id  ? 'selected' : '' }} >{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label">{{ __('subcategory') }} <span class="required">*</span></label>
            <div class="col-md-10">
                <select class="js-example-basic-single js-states form-control" id="subcategory" name="subcategory">
                    @foreach($p_subcategories as  $subcategory)
                    <option value="{{ $subcategory->id }}" {{ old('subcategory') == $subcategory->id || $product->subcategory_id== $subcategory->id  ? 'selected' : '' }} >{{ $subcategory->name }}</option>
                    @endforeach
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>
  

          
        @component('input', ['type' => 'number', 'label' => 'quantity', 'required' => true, 'value' => $product->number])
            number
        @endcomponent
 
   
        <label class="col-md-2 control-label" >{{ __('images') }} <span class="required">*</span> </label>
        @foreach($product->productimages as $image)
            <div class="image-block" style="display: inline-block; margin-left:10px">
                <img style="width:80px;height:80px" src="{{ route('image_show', $image->image)}}" class="user-image" alt="User Image">
                <br/><div class="btn btn-danger delete-image" data-name="{{$image->image}}" style="bottom:15px">x</div>
                <br><br>
            </div>
        @endforeach
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label" >{{ __('images') }}<span class="required">*</span> </label>
            <div class="col-md-10">
                <input type="file" class="form-control"   name="productimage[]" multiple>
                <div class="form-control-focus"> </div>
            </div>
        </div>
 
        @component('input', ['type' => 'number', 'label' => 'price', 'required' => true, 'value' => $product->price])
            price
        @endcomponent
        @component('input', ['type' => 'number', 'label' => 'sale', 'required' => true, 'value' => $product->sale])
            sale
        @endcomponent
  
        <label class="col-md-2 control-label" > {{ __('colors') }}<span class="required">*</span> </label> 
        <td><button type="button"  id="addcolor" class="btn btn-success">{{ __('Add color') }}</button></td> 
        <table class="table"   id="dynamicTablecolor">  
        <?php $colors=count($product->productoffers); ?> 
        @foreach($product->productcolors as $color)
            <tr>
            <td><input type='color' value="{{ $color->color }}" name='addmorecolor[][]' class='form-control' /></td>
            <td><button type='button' class='btn btn-danger remove-tr'>{{ __('Remove') }}</button></td>
            </tr> 
        @endforeach
        </table>

        <label class="col-md-2 control-label" >{{ __('sizes') }} <span class="required">*</span> </label> 
        <td><button type="button"  id="addsize" class="btn btn-success">{{ __('Add size') }}</button></td> 
        <table class="table"   id="dynamicTablesize">  
        <?php $sizes=count($product->productoffers); ?> 
        @foreach($product->productsizes as $size)
            <tr>
            <td><input value="{{ $size->size }}" type='text' name='addmoresize["+z+"][]' placeholder='size...' class='form-control' /><td>
            <td><button type='button' class='btn btn-danger remove-tr'>{{ __('Remove') }}</button></td>
            </tr>
        @endforeach
        </table>

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

    <!-- <script type="text/javascript">
        var isfree        = document.getElementById('is_free');
        if (isfree.value == 'no') { 
            document.getElementById("number").value = 0;
        }
        $("#is_free").change(function() {
            document.getElementById("number").value = 0;
        });
    </script> -->
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


<script type="text/javascript">
    var j = {{ $colors }};
    $("#addcolor").click(function(){
        j++;
        $("#dynamicTablecolor").append("<tr><td><input type='color' name='addmorecolor["+j+"][]' placeholder='color...' class='form-control' /></td><td><button type='button' class='btn btn-danger remove-tr'>Remove</button></td></tr>");
    });
    $(document).on('click', '.remove-tr', function(){  
        $(this).parents('tr').remove();
    });  
</script>

<script type="text/javascript">
    var z = {{ $sizes }};
    $("#addsize").click(function(){
        z++;
        $("#dynamicTablesize").append("<tr><td><input type='text' name='addmoresize["+z+"][]' placeholder='size...' class='form-control' /><td><button type='button' class='btn btn-danger remove-tr'>Remove</button></td></tr>");
    });
    $(document).on('click', '.remove-tr', function(){  
        $(this).parents('tr').remove();
    });  
</script>
   <script>
        $(document).on("click",".delete-image",function(e){
            e.preventDefault();
            let image = $(this).data('name');
            $(this).parents(".image-block").html("<input type='hidden' name='removed_image[]' value=" + image + ">");
        });
    </script>
<script>
  
    $('#category').change(function () {
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
        var id          = $('#category').val();
        var action      = "{{route('subsubcategories.subcategories')}}";
        $.ajax({
            url:  action,
            type: 'POST',
            dataType: 'JSON',
            data: {_token: CSRF_TOKEN, id: id},
            success: function(data, status){
                $('#subcategory').empty();
                var i = 0;
                for(i; i < data.length; i++) {
                    $('#subcategory').append(`<option value="${data[i].id}">${data[i].name}</option>`);
                }
                var id = $('#subcategory').val();
                var action = "{{route('subsubsubcategories.subsubcategories')}}";
                $.ajax({
                url:  action,
                type: 'POST',
                dataType: 'JSON',
                data: {_token: CSRF_TOKEN, id: id},
                success: function(data, status){
                    $('#subsubcategory').empty();
                    var i = 0;
                    for(i; i < data.length; i++) {
                        $('#subsubcategory').append(`<option value="${data[i].id}">${data[i].name}</option>`);
                    }
                }
            });
            }
        });
    });
    $('#subcategory').change(function () {
            var id          = $('#subcategory').val();
            var action      = "{{route('subsubsubcategories.subsubcategories')}}";
            var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:  action,
                type: 'POST',
                dataType: 'JSON',
                data: {_token: CSRF_TOKEN, id: id},
                success: function(data, status){
                    console.log(data);
                    $('#subsubcategory').empty();
                    var i = 0;
                    for(i; i < data.length; i++) {
                        $('#subsubcategory').append(`<option value="${data[i].id}">${data[i].name}</option>`);
                    }
                }
            });
        });
</script>
@endsection