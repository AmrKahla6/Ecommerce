@extends('site.layout.app')
@section('title') {{__('site.home')}}  @endsection
@section('content')
<?php $title=trans('blog.Blog Details'); ?>
    <!-- Start Bradcaump area -->
    @include('site.components.bradcaump', ['title' => $title , 'image' => route('image_show', \App\Coverpages::first()->cover_blog_deatails) ])
        <!-- End Bradcaump area -->
        <!-- Start Our Blog Area -->
        <section class="blog-details-wrap ptb--120 bg__white">
            <div class="container">
                <div class="row">
                @if(App::getLocale() == 'en')
                    @include('site.components.blog_details')
                    @include('site.components.blog_latest_post')
                @else
                    @include('site.components.blog_latest_post')
                    @include('site.components.blog_details')
                @endif
               
                  
                </div>
            </div>
        </section>
        <!-- End Our Blog Area --> 
@endsection