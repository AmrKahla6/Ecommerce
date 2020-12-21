@extends('site.layout.app')
@section('title') {{__('site.home')}}  @endsection
@section('content')
<?php 
    $contact_info = \App\Contactinfo::first();
    $location=trans('contact.location');
    $mobile=trans('contact.Mobile');
    $email=trans('contact.Email');
    $title=trans('contact.Contact Us');
?>

        <!-- End Offset Wrapper -->
        <!-- Start Bradcaump area -->
        @include('site.components.bradcaump', ['title' => $title , 'image' => route('image_show', \App\Coverpages::first()->cover_contact)]) 
        <!-- End Bradcaump area -->
        <!-- Start Contact Area -->
                 
        <section class="htc__contact__area  bg__white" style="padding-top:40px;margin-bottom:60px ;padding-bottom:20px">
            <!-- Start location Area -->
            <div class="row" style="background:#e7e7e7;">
                <div class="container htc__contact__address col-md-6 col-lg-6 col-sm-12">
                    <h2 class="contact__title" style="padding-top:20px">{{trans('contact.contact info')}}</h2>
                    <div class="contact__address__inner">
                        @include('site.components.details_contact', ['details' =>$location  , 'image' => "ti-location-pin" ,'contact_details' => $contact_info->location]) 
                    </div>
                    <div class="contact__address__inner">
                        <!-- Start Single Adress -->
                        @include('site.components.details_contact', ['details' =>$mobile  , 'image' => "ti-mobile" ,'contact_details' => $contact_info->mobile]) 
                        <!-- End Single Adress -->
                        <!-- Start Single Adress -->
                        @include('site.components.details_contact', ['details' => $email , 'image' => "ti-email" ,'contact_details' => $contact_info->email]) 
                        <!-- End Single Adress -->
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="">
                    <div class="htc__contact__container" >
                        <div class="col-md-12 col-lg-12 col-sm-12 smt-30 xmt-30" style="margin-top:50px">
                            <div class="map-contacts">
                                <div class="mapouter shadow col-md"><div class="gmap_canvas"><iframe width="100%" height="361" id="gmap_canvas" src="https://maps.google.com/maps?q={{ $contact_info->lat }},{{ $contact_info->lng }}&hl=es;z=14&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>Google Maps Generator by <a href="https://www.embedgooglemap.net">embedgooglemap.net</a></div><style>.mapouter{position:relative;text-align:right;height:361px;width:1080px;}.gmap_canvas {overflow:hidden;background:none!important;height:361px;width:1080px;}</style></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start map Area -->
            <div class="container col-md-10 col-lg-10 col-sm-12 smt-30 xmt-30 contact-form-wrap" style="margin-top:60px; background:#e7e7e7">
                <div class="contact-title" style="padding-top:30px">
                    <h2 style="text-align:center" class="contact__title" >{{trans('contact.Get In Touch')}}</h2>
                </div>
                <form id="my_form"  method="POST" action="{{ route('save_contact') }}">
                @csrf
                    <div class="single-contact-form">
                        <div class="contact-box name">
                            <input type="text" name="name" placeholder="{{trans('contact.Your Nme')}}">
                            <input  type="email" name="email" placeholder="{{trans('contact.Mail')}}">
                        </div>
                    </div>
                    <div class="single-contact-form">
                        <div class="contact-box subject">
                            <input type="text" name="phone" placeholder="{{trans('contact.phone')}}">
                        </div>
                    </div>
                    <div class="single-contact-form">
                        <div class="contact-box message">
                            <textarea name="message"  placeholder="{{trans('contact.Massage')}}"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom:30px">
                            <div class="htc__loadmore__btn">
                                <a href="javascript:{}" onclick="document.getElementById('my_form').submit();"> {{trans('contact.Send')}}</button> </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </section>

        
        <!-- End Contact Area -->
        <!-- Start Footer Area -->
        @endsection