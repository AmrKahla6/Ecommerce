@extends('layouts.app')

@extends('site.layouts')
@section('content')
    <div class="form-wrap">
        <form method="POST" action="{{ route('register_home') }}" enctype="multipart/form-data">
            @csrf
            <h1 class="sign">Sign Up</h1>
            <input value="{{ old('name') }}" name="name" type="text" placeholder="Name">
            <input value="{{ old('phone') }}" name="phone" type="text" placeholder="phone">
            <input value="{{ old('email') }}" name="email" type="email" placeholder="Email">
            <input value="{{ old('password') }}" name="password" type="password" placeholder="Password">
            <input value="{{ old('password_confirmation') }}" name="password_confirmation" type="password" placeholder="Confirm Password">
            <input id="register_submit" type="button" value="Sign Up">
        </form>
    </div>
@endsection
    




