@extends('site.user.app')
@section('title') {{__('site.all-products')}}  @endsection
@section('content')

	<div class="col-md-10 offset-md-1 col-lg-8 offset-lg-0">
		<!-- Edit Personal Info -->
		<div class="widget personal-info">
			<h3 class="widget-header user">Edit Personal Information</h3>
			<form action="{{ route('change_details') }}" method="post" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<!-- First Name -->
				<div class="form-group">
					<label for="first-name"> Name</label>
					<input name="name" value="{{ old('name') ? old('name') : $user->name }}" type="text" class="form-control" id="first-name">
				</div>
				<!-- Last Name -->
				<div class="form-group">
					<label for="current-email"> Email</label>
					<input name="email" value="{{ old('email') ? old('email') : $user->email }}" type="email" class="form-control" id="current-email">
				</div>
				<div class="form-group">
					<label for="phone"> Phone</label>
					<input name="phone" value="{{ old('phone') ? old('phone') : $user->phone }}" type="text" class="form-control" id="phone">
				</div>
				<div class="form-group">
					<label for="phone"> address</label>
					<textarea id="address" name="address" rows="6"  placeholder="address..." class="form-control">
					{{ old('address') ? old('address') : $user->address }}
					</textarea>
				</div>
				<!-- File chooser -->
				<div class="form-group choose-file">
					<!-- <i class="fa fa-user text-center"></i> -->
					<label for="image"> <img id="image_image"  style="width:80px; height:80px;border:1px solid #fff ; border-radius:50%" src="{{ route('image_show',$user->image) }}" alt="product images"> </label>
					<input id="image" name="image" type="file" class="form-control-file d-inline js-example-basic-single">
					</div>
				<!-- Comunity Name -->
			
				<!-- Checkbox -->
				<!-- <div class="form-check">
					<label class="form-check-label" for="hide-profile">
					<input class="form-check-input" type="checkbox" value="" id="hide-profile">
					Hide Profile from Public/Comunity
					</label>
				</div> -->
				<!-- Zip Code -->
				<!-- <div class="form-group">
					<label for="zip-code">Zip Code</label>
					<input type="text" class="form-control" id="zip-code">
				</div> -->
				<!-- Submit button -->
				<button type="submit" class="btn btn-transparent">Save My Changes</button>
			</form>
		</div>
		<!-- Change Password -->
		<div class="widget change-password">
			<h3 class="widget-header user">Edit Password</h3>
			<form action="{{ route('changePassword') }}" method="post">
				@csrf
				<!-- Current Password -->
				<div class="form-group">
					<label for="current-password">Current Password</label>
					<input name="current_password" type="password" class="form-control" id="current-password">
				</div>
				<!-- New Password -->
				<div class="form-group">
					<label for="new-password">New Password</label>
					<input name="password" type="password" class="form-control" id="new-password">
				</div>
				<!-- Confirm New Password -->
				<div class="form-group">
					<label for="confirm-password">Confirm New Password</label>
					<input name="password_confirmation" type="password" class="form-control" id="confirm-password">
				</div>
				<!-- Submit Button -->
				<button type="submit" class="btn btn-transparent">Change Password</button>
			</form>
		</div>
		<!-- Change Email Address -->
	
	</div>
	
@endsection
@section('js')
<script>
    $('#input-file').select2();
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
      console.log("image")
        readURL(this, "#image_image");
    });

</script>
@endsection