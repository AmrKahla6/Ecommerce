<div class="col-md-12 col-lg-4  smt-30 xmt-40">
    <div class="blod-details-right-sidebar">
    <form role="form" method="GET" action="{{ route('search_blogs') }}">
        <div class="category-search-area">
            <input placeholder="{{trans('blog.Search')}}" type="text" name="search">
            <a onclick="$(this).closest('form').submit();" class="srch-btn" href="#"><i class="zmdi zmdi-search"></i></a>    
        </div>
    </form>
    
        <!-- Start Letaest Blog Area -->
        <div class="our-recent-post mt--60">
            <h2 class="section-title-2" @if(App::getLocale() == 'ar') style="float:right" @endif>{{trans('blog.LATEST POST')}}</h2>
            <div class="our-recent-post-wrap">
                <!-- Start Single Post -->
                @foreach($blogs_active as $blog_active)
                @if(App::getLocale() == 'en')
                <div class="single-recent-post">
                    <div class="recent-thumb">
                        <a href="{{route('blog',$blog_active->id)}}"><img src="{{ route('image_show', $blog_active->image) }}" alt="post images"></a>
                    </div>
                    <div class="recent-details">
                        <div class="recent-post-dtl">
                            <h6><a href="{{route('blog',$blog_active->id)}}">{!! $blog_active->title !!}</a></h6>
                        </div>
                        <div class="recent-post-time" style="float:right">
                            <p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog_active->created_at)->format('d M, Y')}}</p>
                            <p class="separator">|</p>
                            <p>
                            {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog_active->created_at)->format('g:i A')}}
                            </p>
                        </div>
                    </div>
                </div>
                @else
                <div class="single-recent-post" style="float:right;clear:both">
                  
                    <div class="recent-details" style="text-align:right; padding-right:20px">
                        <div class="recent-post-dtl">
                            <h6 ><a href="{{route('blog',$blog_active->id)}}">{!! $blog_active->title !!}</a></h6>
                        </div>
                        <div class="recent-post-time">
                            <p>
                            {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog_active->created_at)->format('g:i A')}}
                            </p>
                            <p class="separator">|</p>
                           
                            <p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog_active->created_at)->format('d M, Y')}}</p>
                        </div>
                    </div>
                    <div class="recent-thumb">
                        <a href="{{route('blog',$blog_active->id)}}"><img src="{{ route('image_show', $blog_active->image) }}" alt="post images"></a>
                    </div>
                </div>
                @endif
                @endforeach
                <!-- End Single Post -->
            
            
            </div>
        </div>
        <!-- End Letaest Blog Area -->

        <!-- End Tag -->
    </div>
</div>