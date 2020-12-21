@extends('dashboard.layouts.app')
@section('title')
{{__('Create Product')}} 
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-body">
        @component('input_trans', ['type' => 'text', 'label' => 'Name', 'required' => true])
            name
        @endcomponent
        @component('input_trans', ['type' => 'textarea', 'label' => 'description', 'required' => true, 'class' => 'ckeditor'])
            description
        @endcomponent
        @component('input_image', ['width' => 600, 'height' => 400, 'label' => 'Image','multiple' => 'true'])
            image
        @endcomponent

        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label">{{ __('category') }} <span class="required">*</span></label>
            <div class="col-md-10">
                <select class="js-example-basic-single js-states form-control" id="category" name="category">
                    @foreach(\App\Category::all() as $category)
                    <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }} >{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label">{{ __('subcategory') }} <span class="required">*</span></label>
            <div class="col-md-10">
                <select class="js-example-basic-single js-states form-control" id="subcategory" name="subcategory">
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>

     
        @component('input', ['type' => 'number', 'label' => 'price', 'required' => true])
            price
        @endcomponent
        @component('input', ['type' => 'number', 'label' => 'sale', 'required' => true])
            sale
        @endcomponent
        @component('input', ['type' => 'number', 'label' => 'quantity', 'required' => true])
            number
        @endcomponent
    
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label" >images<span class="required">*</span> </label>
            <div class="col-md-10">
                <input type="file" class="form-control"   name="productimage[]" multiple>
                <div class="form-control-focus"> </div>
            </div>
        </div>
  

   

        <label class="col-md-2 control-label" >colors <span class="required">*</span> </label> 
        <td><button type="button"  id="addcolor" class="btn btn-success">Add color</button></td> 
        <table class="table"   id="dynamicTablecolor">  
            <tr></tr> 
        </table>

        <label class="col-md-2 control-label" >sizes <span class="required">*</span> </label> 
        <td><button type="button"  id="addsize" class="btn btn-success">Add size</button></td> 
        <table class="table"   id="dynamicTablesize">  
            <tr></tr>
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
    var i = 0;
    $("#addoffer").click(function(){
        i++;
        $("#dynamicTableoffer").append("<tr><td><input type='number' name='addmoreoffer["+i+"][]' placeholder='Quantity from...' class='form-control' /></td><td><input type='number' name='addmoreoffer["+i+"][]' placeholder='Quantity to...' class='form-control' /></td><td><input type='number' name='addmoreoffer["+i+"][]' placeholder='Enter your Price' class='form-control' /></td><td><button type='button' class='btn btn-danger remove-tr'>Remove</button></td></tr>");
    });
    $(document).on('click', '.remove-tr', function(){  
        $(this).parents('tr').remove();
    });  
</script>

<script type="text/javascript">
    var j = 0;
    $("#addcolor").click(function(){
        j++;
        $("#dynamicTablecolor").append("<tr><td><input type='color' name='addmorecolor["+j+"][]' placeholder='color...' class='form-control' /></td><td><input type='hidden' name='addmorecolor["+j+"][]'  class='form-control' /></td><td></td><td><button type='button' class='btn btn-danger remove-tr'>Remove</button></td></tr>");
    });
    $(document).on('click', '.remove-tr', function(){  
        $(this).parents('tr').remove();
    });  
</script>

<script type="text/javascript">
    var z = 0;
    $("#addsize").click(function(){
        z++;
        $("#dynamicTablesize").append("<tr><td><input type='text' name='addmoresize["+z+"][]' placeholder='size...' class='form-control' /><td><button type='button' class='btn btn-danger remove-tr'>Remove</button></td></tr>");
    });
    $(document).on('click', '.remove-tr', function(){  
        $(this).parents('tr').remove();
    });  
</script>
<script>
    var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
    var id          = $('#category').val();
    var action      =  "{{route('subsubcategories.subcategories')}}";
    $.ajax({
        url:  action,
        type: 'POST',
        dataType: 'JSON',
        data: {_token: CSRF_TOKEN, id: id},
        success: function(data, status){
            console.log(data);
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
                    console.log('kkk');
                    $('#subsubcategory').empty();
                    var i = 0;
                    for(i; i < data.length; i++) {
                        $('#subsubcategory').append(`<option value="${data[i].id}">${data[i].name}</option>`);
                    }
                }
            });
        }
    });
    $('#category').change(function () {
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