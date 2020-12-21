<div class="col-md-12 col-lg-6 col-sm-12" style="left:0px">
    <div class="htc__choose__wrap bg__cat--4">
        <h2 class="choose__title">{{$about->why_choose}}</h2>
        <div class="choose__container">
            <div class="single__chooose">
                @if($about->why_choose_title_1 != null && $about->why_choose_desc_1 != null && $about->why_choose_image_1 != null)
                    @include('site.components.image_and_why_choose_of_about', ['image' => $about->why_choose_image_1 ,'title' => $about->why_choose_title_1 ,'desc' => $about->why_choose_desc_1]) 
                @endif
                @if($about->why_choose_title_2 != null && $about->why_choose_desc_2 != null && $about->why_choose_image_2 != null)
                    @include('site.components.image_and_why_choose_of_about', ['image' => $about->why_choose_image_2 ,'title' => $about->why_choose_title_2 ,'desc' => $about->why_choose_desc_2]) 
                @endif
            </div>
            <div class="single__chooose">
                @if($about->why_choose_title_3 != null && $about->why_choose_desc_3 != null && $about->why_choose_image_3 != null)
                    @include('site.components.image_and_why_choose_of_about', ['image' => $about->why_choose_image_3 ,'title' => $about->why_choose_title_3 ,'desc' => $about->why_choose_desc_3]) 
                @endif
                @if($about->why_choose_title_4 != null && $about->why_choose_desc_4 != null && $about->why_choose_image_4 != null)
                    @include('site.components.image_and_why_choose_of_about', ['image' => $about->why_choose_image_4 ,'title' => $about->why_choose_title_4 ,'desc' => $about->why_choose_desc_4]) 
                @endif
            </div>
        </div>
    </div>
</div>