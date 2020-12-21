<div class="col-md-12 col-lg-8">
    <div class="blog-details-left-sidebar">
        <div class="blog-details-top" >
            <!--Start Blog Thumb -->
            <div class="blog-details-thumb-wrap">
                <div class="blog-details-thumb">
                    <img src="{{ route('image_show', $blog->image) }}" alt="blog images">
                </div>
                <div class="upcoming-date">
                {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog->created_at)->format('d')}}<span class="upc-mth">
                {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog->created_at)->format('M, Y')}}</span>
                </div>
            </div>
            <!--End Blog Thumb -->
            <h2>{{$blog->title}}</h2>
            <div class="blog-admin-and-comment" >
           
                <p class="separator">|</p>
                <p>{{ count($blog->commentblogs->where('status_id', \App\Status::where('slug', 'active')->firstOrFail()->id)) }} {{trans('blog.COMMENTS')}}</p>
            </div>
            <!-- Start Blog Pra -->
            <div class="blog-details-pra" >
                <p >{!! $blog->description !!}</p>
            </div>
            <!-- End Blog Pra -->
        
            <!-- End Blog Tags -->
            <!-- Start Blog Comment Area -->
            <div class="our-blog-comment mt--20">
                <div class="blog-comment-inner" >
                    <h2 class="section-title-2" @if(App::getLocale() == 'ar') style="float:right; clear:both"  @endif>{{trans('blog.COMMENTS')}} ({{ count($blog->commentblogs->where('status_id', \App\Status::where('slug', 'active')->firstOrFail()->id)) }})</h2>
                    <!-- Start Single Comment -->
                    @foreach($blog->commentblogs->where('status_id', \App\Status::where('slug', 'active')->firstOrFail()->id) as $comment)
                    <div class="single-blog-comment">
                    @if(App::getLocale() == 'en')
                        <div class="blog-comment-thumb">
                            <img src="{{$comment->user_id != null ? route('image_show', $comment->user->image ) : route('image_show', \App\Blog::first()->image)}} " alt="comment images">
                        </div>
                        <div class="blog-comment-details">
                            <div class="comment-title-date">
                                <h2><a href="#">{{$comment->user_id != null ? $comment->user->name : $comment->name}} </a></h2>
                                <div class="reply">
                                    <p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('d M, Y')}}</p>
                                </div>
                            </div>
                            <p>{{$comment->comment }}</p>
                        </div>
                        @else
                        <div class="blog-comment-details">
                            <div class="comment-title-date" >
                                <div class="reply">
                                    <p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('d M, Y')}}</p>
                                </div>
                                <h2 ><a href="#">{{$comment->user_id != null ? $comment->user->name : $comment->name}} </a></h2>
                               
                            </div>
                            <p style="text-align:right;margin-right:10px">{{$comment->comment }}</p>
                        </div>
                        <div class="blog-comment-thumb">
                            <img src="{{$comment->user_id != null ? route('image_show', $comment->user->image ) : route('image_show', \App\Blog::first()->image)}} " alt="comment images">
                        </div>
                        @endif
                    </div>
                    @endforeach
            
            
                    <!-- End Single Comment -->
                </div>
            </div>
            <!-- End Blog Comment Area -->
            <!-- Start Reply Form -->
            <div class="our-reply-form-area mt--20" @if(App::getLocale() == 'ar') style="clear:both"  @endif>
            <form id="my_form" method="POST" action="{{ route('comment_blog') }}">
                @csrf 
                <input type="hidden" value="{{ $blog->id }}" name="blog">
                <h2 class="section-title-2" @if(App::getLocale() == 'ar') style="float:right;margin-bottom: 40px; clear:both"  @endif >{{trans('blog.LEAVE A REPLY')}}</h2>
                <div class="reply-form-inner mt--40" @if(App::getLocale() == 'ar') style=" clear:both; text-align:right"  @endif>
                    @if( !auth()->check() )
                    <div class="reply-form-box">
                        <div class="reply-form-box-inner" >
                            <div class="rfb-single-input">
                                <input value="{{old('name')}}" type="text" name="name" placeholder="{{trans('blog.Name')}}">
                            </div>
                            <div class="rfb-single-input">
                                <input  value="{{old('email')}}"  name="email"  type="email" placeholder="{{trans('blog.Email')}}">
                            </div>
                        </div>
                    </div>
                    <div class="reply-form-box">
                        <textarea name="comment" placeholder="{{trans('blog.Message')}}"> {{ old('comment') ? old('comment') : '' }} </textarea>
                    </div>
                    @else
                    <input type="hidden" value="{{ auth()->user()->email }}" name="email">
                    <input type="hidden" value="{{ auth()->user()->name_of_owner }}" name="name">
                    <div class="reply-form-box">
                        <textarea name="comment" placeholder="Message">{{ old('comment') ? old('comment') : '' }}</textarea>
                    </div>
                    @endif
                    <div class="blog__details__btn">
                        <a class="htc__btn btn--gray" href="javascript:{}" onclick="document.getElementById('my_form').submit();">{{trans('blog.submit')}}</a>
                        
                    </div>
                </div>
            </form>
            </div>
            <!-- End Reply Form -->
        </div>
    </div>
</div>