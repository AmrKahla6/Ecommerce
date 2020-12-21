@extends('site.layout.app')
@section('title') {{__('site.log in')}}  @endsection
@section('content')

<div class="htc__login__register bg__white ptb--130" style="background: rgba(0, 0, 0, 0) url({{ route('image_show', \App\Coverpages::first()->cover_login) }}) no-repeat scroll center center / cover ;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 ml-auto mr-auto">
                <ul class="login__register__menu nav justify-contend-center" role="tablist">
                    <li role="presentation" class="login active"><a class="active" href="#login" role="tab" data-toggle="tab">{{trans('login.Login')}}</a></li>
                    <li role="presentation" class="register"><a href="#register" role="tab" data-toggle="tab">{{trans('login.Register')}}</a></li>
                </ul>
            </div>
        </div>
        <!-- Start Login Register Content -->
        <div class="row tab-content">
            <div class="col-md-6  ml-auto mr-auto">
                <div class="htc__login__register__wrap">
                    <!-- Start Single Content -->
                    <div id="login" role="tabpanel" class="single__tabs__panel tab-pane active">
                        <form id="my_form_log_form" class="login" method="post" action="{{ route('login') }}">
                            @csrf
                            <input type="text" placeholder="{{trans('login.Email')}}" name="login">
                            <input class="color_white" type="password" placeholder="{{trans('login.Password')}}" name="password">
                        </form>
                        <div class="tabs__checkbox">
                            <input type="checkbox">
                            <span> {{trans('login.Remember me')}}</span>
                            <span class="forget"><a href="#">{{trans('login.Forget Pasword<')}}</a></span>
                        </div>
                        <div id="login_user" class="htc__login__btn mt--30">
                            <a href="javascript:{}" onclick="document.getElementById('my_form_log_form').submit();">{{trans('login.Login')}}</a>
                        </div>
                         <div class="htc__social__connect">
                            <h2>Or Login With</h2>
                            <ul class="htc__soaial__list">
                                <!-- <li><a class="bg--twitter" href="https://twitter.com/devitemsllc" target="_blank"><i class="zmdi zmdi-twitter"></i></a></li> -->

                                <!-- <li><a class="bg--instagram" href="https://www.instagram.com/devitems/" target="_blank"><i class="zmdi zmdi-instagram"></i></a></li> -->

                                <li><a class="bg--facebook" href="{{url('/redirect')}}" target="_blank"><i class="zmdi zmdi-facebook"></i></a></li>

                                <li><a class="bg--googleplus" href="{{ route('glogin') }}" target="_blank"><i class="zmdi zmdi-google-plus"></i></a></li>
                            </ul>
                        </div> 
                    </div>
                    <!-- End Single Content -->
                    <!-- Start Single Content -->
                    <div id="register" role="tabpanel" class="single__tabs__panel tab-pane">
                        <form id="my_form_reg_form" class="login" method="post" action="{{ route('store_user') }}" >
                            @csrf
                            <input name="name" type="text" value="{{ old('name') }}" placeholder="{{trans('login.Name')}}">
                            <input name="email" type="email" value="{{ old('email') }}" placeholder="{{trans('login.Email')}}">
                            <input name="password" type="password" placeholder="{{trans('login.Password')}}" placeholder="Password*">
                            <input name="password_confirmation" type="password" placeholder="{{trans('login.Confirm Password')}}">
                        </form>
                        <div class="tabs__checkbox">
                            <input type="checkbox">
                            <span> {{trans('login.Remember me')}}</span>
                        </div>
                        <div id="register_user" class="htc__login__btn">
                            <a href="javascript:{}" onclick="document.getElementById('my_form_reg_form').submit();">{{trans('login.Register')}}</a>
                        </div>
                        <!-- <div class="htc__social__connect">
                            <h2>Or Login With</h2>
                            <ul class="htc__soaial__list">
                                <li><a class="bg--twitter" href="https://twitter.com/devitemsllc" target="_blank"><i class="zmdi zmdi-twitter"></i></a></li>
                                <li><a class="bg--instagram" href="https://www.instagram.com/devitems/" target="_blank"><i class="zmdi zmdi-instagram"></i></a></li>
                                <li><a class="bg--facebook" href="https://www.facebook.com/devitems/?ref=bookmarks" target="_blank"><i class="zmdi zmdi-facebook"></i></a></li>
                                <li><a class="bg--googleplus" href="https://plus.google.com/" target="_blank"><i class="zmdi zmdi-google-plus"></i></a></li>
                            </ul>
                        </div> -->
                    </div>
                    <!-- End Single Content -->
                </div>
            </div>
        </div>
        <!-- End Login Register Content -->
    </div>
</div>

@endsection
@section('foo')

@endsection