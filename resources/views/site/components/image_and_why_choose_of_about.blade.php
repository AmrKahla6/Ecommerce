    <div class="choose__us">
    @if(App::getLocale() == 'en')
        <div class="choose__icon">
            <span class="{{$image}}"></span>
        </div>
        <div class="choose__details">
            <h4>{{$title}}</h4>
            <p>{{$desc}} </p>
        </div>
    @else
        <div class="choose__details">
            <h4>{{$title}}</h4>
            <p>{{$desc}} </p>
        </div>
        <div class="choose__icon">
            <span class="{{$image}}"></span>
        </div>
    @endif
       
    </div>
