@extends('site.layout.app')
@section('title') {{__('site.home')}}  @endsection
@section('content')
<!-- Start Bradcaump area -->
<?php $title=trans('blogs.Blog'); ?>
@include('site.components.bradcaump', ['title' => $title , 'image' => route('image_show', \App\Coverpages::first()->cover_blog) ])
    
    	<!-- content page -->
		<div class="htc__blog__area bg__white ptb--120">
            <div class="container">
                <div class="row blog__wrap blog--page clearfix">
					<!-- Start Single Blog -->
					@if(isset($blogs_active))
					@foreach($blogs_active as $blog)
                    <div class="col-md-6 col-lg-4 col-sm-12">
                        <div class="blog foo">
                            <div class="blog__inner">
                                <div class="blog__thumb">
                                    <a href="{{route('blog',$blog->id)}}">
                                        <img style="width:370px;height:347px" src="{{ route('image_show', $blog->image) }}" alt="blog images">
                                    </a>
                                    <div class="blog__post__time">
                                        <div class="post__time--inner">
                                            <span class="date">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog->created_at)->format('d')}}</span>
                                            <span class="month">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog->created_at)->format('M')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="blog__hover__info">
                                    <div class="blog__hover__action">
                                        <ul class="bl__meta">
                                     
                                            <li>{{ $blog->title }}</li>
                                        </ul>
                                        <p class="blog__des"><a href="{{route('blog',$blog->id)}}">@if( strlen(strip_tags($blog->description)) > 150 ) {!! substr(strip_tags($blog->description), 0, 150) !!}.... @else {!! strip_tags($blog->description) !!} @endif</a></p>
                                        <div class="blog__btn">
                                            <a class="read__more__btn" href="{{route('blog',$blog->id)}}">{{trans('blogs.Read More')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					@endforeach
						@endif
                    <!-- End Single Blog -->
                </div>
                <!-- Start Load More BTn -->
                <div class="row mt--60">
                    <div class="col-md-12">
                        <div class="htc__loadmore__btn">
                            <a href="#">load more</a>
                        </div>
                    </div>
                </div>
                <!-- End Load More BTn -->
            </div>
        </div>

@endsection