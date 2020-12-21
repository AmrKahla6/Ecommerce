@php
    $active     = \App\Status::where('slug', 'active')->firstOrFail();
    $country_id = \App\Country::where('country_code', request()->route()->parameter('country'))->firstOrFail()->id;
    $ads        = \App\Ad::where('status_id', $active->id)
                    ->whereDate('expire_at', '>=', date('Y-m-d'))
                    ->where('banner', 1)
                    ->where('country_id', $country_id)
                    ->latest()
                    ->get();
    $offers     = \App\Offer::where('status_id', $active->id)
                    ->whereDate('expire_at', '>=', date('Y-m-d'))
                    ->where('banner', 1)
                    ->where('country_id', $country_id)
                    ->latest()
                    ->get();
    $companies  = \App\Company::where('status_id', $active->id)
                    ->whereDate('expire_at', '>=', date('Y-m-d'))
                    ->where('banner', 1)
                    ->where('country_id', $country_id)
                    ->latest()
                    ->get();
    $banners = [];
    foreach ($ads as $ad) {
        array_push($banners, $ad);
    }
    foreach ($offers as $offer) {
        array_push($banners, $offer);
    }
    foreach ($companies as $company) {
        array_push($banners, $company);
    }
@endphp
@if(count($banners) > 0)
<div class="banner-carousel ">
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($banners as $banner)
            <div class="carousel-item @if($loop->first) active @endif">
                <img src="{{ route('image_show', $banner->banner_image) }}" class="d-block w-100" alt="{{ $banner->description }}" width="300px">
            </div>
            @endforeach

        </div>
    </div>
</div>
@endif