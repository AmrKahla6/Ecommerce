@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{route('save_edit_home_section_1',$homesection1->id)}}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-body">
        @component('input_trans', ['type' => 'text', 'label' => 'title', 'required' => false, 'model' => $homesection1])
            title
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'description', 'required' => false, 'model' => $homesection1])
            description
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'button', 'required' => false, 'model' => $homesection1])
            button
        @endcomponent
       
        @if($homesection1->type=="new_arrival")
        <input type="hidden" value="new_arrival" name="type">
        @component('input', ['type' => 'date', 'label' => 'duration', 'required' => false, 'value' => $homesection1->duration_of_new_arrival])
            duration_of_new_arrival
        @endcomponent
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
                    <option value="{{ $subcategory->id }}" {{ old('subcategory') == $subcategory->id || $homesection1->subcategory_id== $subcategory->id  ? 'selected' : '' }} >{{ $subcategory->name }}</option>
                    @endforeach
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>
        @component('input_image', ['width' => 1400, 'height' => 300, 'label' => 'Image', 'src' => route('image_show', $homesection1->image)])
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