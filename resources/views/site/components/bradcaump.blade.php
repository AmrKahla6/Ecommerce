<div class="ht__bradcaump__area" style="background: #f5f5f5 url({{$image}}) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">{{ $title }}</h2>
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="{{ route('indexeco') }}">{{trans('blog.Home')}}</a>
                                  <span class="brd-separetor">{{ App::getLocale() == 'ar' ? '\\' : '/' }}</span>
                                  <span class="breadcrumb-item active">{{ $title }}</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>