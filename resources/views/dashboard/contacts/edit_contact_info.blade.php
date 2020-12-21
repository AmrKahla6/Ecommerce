@extends('dashboard.layouts.app')
@section('title')
{{__('Contact Info')}} 
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('save_contact_info', $contact_info->id) }}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-body">
        @component('input_image', ['width' => 1920, 'height' => 239, 'label' => 'cover', 'src' => route('image_show', $contact_info->cover)])
            cover
        @endcomponent
        @component('input_trans', ['type' => 'text', 'label' => 'location', 'required' => false, 'model' => $contact_info])
            location
        @endcomponent
        @component('input', ['type' => 'email', 'label' => 'email', 'required' => false, 'value' => $contact_info->email])
            email
        @endcomponent

        @component('input', ['type' => 'text', 'label' => 'mobile', 'required' => false, 'value' => $contact_info->mobile])
            mobile
        @endcomponent
        <div class="form-group form-md-line-input">
        <label for="search" class="col-md-2 control-label">{{ __('Search') }}</label>
        <div class="col-md-10">                    
            <input id="search"  placeholder="{{ __('Search') }}" class="form-control">
            <div class="form-control-focus"> </div>
        </div>
    </div>
    <input type="text" style="display: none" name="lat" id="lat" value="{{ $contact_info->lat }}">
    <input type="text" style="display: none" name="lng" id="lng" value="{{ $contact_info->lng }}">                                
    <div class="form-group">
        <div id="map-canvas" class="form-control"></div>                
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
<style>
    #map-canvas{
        height: 600px;
   
    }
</style>
@endsection
@section('js')
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyA9UBKQHciVMSJZEoM640mtwKkTXavjrD4&libraries=places"></script>
<script>
var map = new google.maps.Map(document.getElementById('map-canvas'), {
    center:{
        lat: {{ $contact_info->lat }},
        lng: {{ $contact_info->lng }}
    },
    zoom: 15
});
var marker = new google.maps.Marker({
    position:{
        lat: {{ $contact_info->lat }},
        lng: {{ $contact_info->lng }}
    },
    map: map,
    draggable: true
});
google.maps.event.addListener(marker, 'dragend', function (){
    var lat = marker.getPosition().lat();
    var lng = marker.getPosition().lng(); 
    $("#lat").val(lat);
    $("#lng").val(lng);
});
var address  = new google.maps.places.SearchBox(document.getElementById('address'));
var searchBox  = new google.maps.places.SearchBox(document.getElementById('search'));
google.maps.event.addListener(searchBox , 'places_changed' , function(){
    var places = searchBox.getPlaces();
    var bounds = new google.maps.LatLngBounds();
     var i, place;
     for (i = 0; place = places[i]; i++) {
        bounds.extend(place.geometry.location)         
        marker.setPosition(place.geometry.location)         
     }
     map.fitBounds(bounds);
     map.setZoom(15);
     
});
google.maps.event.addListener(marker , 'position_changed' , function(){
    var lat = marker.getPosition().lat();
    var lng = marker.getPosition().lng(); 
    $("#lat").val(lat);
    $("#lng").val(lng);
});
</script>
<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
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
