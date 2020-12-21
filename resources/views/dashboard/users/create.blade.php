@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection
<!-- @section('breadcrumbs')
<ol class="breadcrumb">
    <li> <a href=""> <i class="fa fa-dashboard"></i> home</a> </li>
    <li>
        <a href="">create</a>
    </li>
    <li class="active">
       user
    </li>
</ol>
@endsection -->
@section('content')
    
    <form role="form" class="form-horizontal" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf
    <div class="form-body">
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label" >name <span class="required">*</span> </label>
            <div class="col-md-10">
                <input type="text" value="{{ (old('name_of_owner')) }}" class="form-control"  name="name_of_owner" placeholder="name"     >
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label" >address <span class="required">*</span> </label>
            <div class="col-md-10">
                <input type="text" value="{{ (old('address')) }}" class="form-control"  name="address" placeholder="address..."     >
                <div class="form-control-focus"> </div>
            </div>
        </div>

        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label" >email <span class="required">*</span> </label>
            <div class="col-md-10">
                <input type="email" value="{{ (old('email')) }}" class="form-control"  name="email" placeholder="email"     >
                <div class="form-control-focus"> </div>
            </div>
        </div>

        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label" >phone <span class="required">*</span> </label>
            <div class="col-md-10">
                <input type="text" value="{{ (old('phone')) }}" class="form-control"  name="phone" placeholder="phone"     >
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label">{{ __('city') }} <span class="required">*</span></label>
            <div class="col-md-10">
                <select class="js-example-basic-single js-states form-control" id="position" name="city">
                    @foreach(\App\City::all() as $city)
                    <option value="{{ $city->id }}" {{ old('city') == $city->id ? 'selected' : '' }} >{{ $city->name }}</option>
                    @endforeach
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>

        <div class="form-group form-md-line-input" >
            <label for="input_id" class="col-md-2 control-label">image <br>200*300</label>
            <div class="col-md-10">
                <div class="thumbnail" style="width: 200px; height: 150px;">
                    <img id="image" src="" /> 
                </div>
                <input type="file"zz class="from-control" name="image" id="input_id" />
            </div>
        </div>

     

        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label" >password <span class="required">*</span> </label>
            <div class="col-md-10">
                <input type="password" value="{{ (old('password')) }}" class="form-control"  name="password" placeholder="password"     >
                <div class="form-control-focus"> </div>
            </div>
        </div>

        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label" >Confirm Password <span class="required">*</span> </label>
            <div class="col-md-10">
                <input type="password" value="{{ (old('password_confirmation')) }}" class="form-control"  name="password_confirmation" placeholder="Confirm Password"     >
                <div class="form-control-focus"> </div>
            </div>
        </div>

        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label">{{ ucfirst(__('roles')) }}</label>
            <div class="col-md-10">
                <select class="js-example-basic-single js-states form-control roles" id="roles[]" name="roles[]" multiple="multiple">
                    @foreach(\App\Role::get() as $role)
                    <option value="{{ $role->id }}" @if(old('roles')) @if(in_array($role->id, old('roles'))) selected @endif @endif>{{ $role->display_name }}</option>
                    @endforeach
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>
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
        function showImage(src,target) {
            var fr=new FileReader();
            fr.onload = function(e) { target.src = this.result; };
            src.addEventListener("change",function() {
                fr.readAsDataURL(src.files[0]);
            });
        }

        var src = document.getElementById("input_id");
        var target = document.getElementById("image");
        showImage(src,target);

        var sr = document.getElementById("sr");
        var targe = document.getElementById("targe");
        showImage(sr,targe);
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.roles').select2();
        });
    </script>
@endsection