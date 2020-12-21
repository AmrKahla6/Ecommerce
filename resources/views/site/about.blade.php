@extends('site.layout.app')
@section('title') {{__('site.home')}}  @endsection
@section('content')
<?php
    $about=\App\About::find(1);
    $title=trans('about.About Us');
?>


	<!-- Start Bradcaump area -->

        <!-- End Bradcaump area -->
        <!-- Start Our Store Area -->
        @include('site.components.bradcaump', ['title' => $title , 'image' => route('image_show', $about->cover)])
        <section class="htc__store__area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section__title section__title--2 text-center">
                            <h2 class="title__line">{{$about->title}}</h2>
                            <p>{!! $about->description !!}</p>
                        </div>
                        <div class="store__btn">
                            <a href="{{route('contact') }}">{{trans('about.contact us')}}</a>
                            {{-- <a href="{{route('contact2') }}">{{trans('about.contact us')}}</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Our Store Area -->
        <!-- Start Choose Us Area -->
        <section class="htc__choose__us__ares bg__white">
            <div class="container-fluid">
                <div class="row">
                @if(App::getLocale() == 'en')
                @include('site.components.why_choose_of_about')
                <div class="col-md-12 col-lg-6 col-sm-12">
                    <div class=" bg--3" data--black__overlay="5">
                        <img style="width:960px;height:450px" src="{{ route('image_show', $about->image) }}" alt="blog images">
                    </div>
                </div>

                @else

                <div class="col-md-12 col-lg-6 col-sm-12">
                    <div class=" bg--3" data--black__overlay="5">
                        <img style="width:960px;height:450px" src="{{ route('image_show', $about->image) }}" alt="blog images">
                    </div>
                </div>
                @include('site.components.why_choose_of_about')
                @endif



                </div>
            </div>
        </section>
	@endsection
