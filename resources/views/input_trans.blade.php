@php
$first = 0;
@endphp
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)                          
@php
$first++;
if($first == 1)
    $lang = $localeCode;
@endphp
@endforeach
<div class="form-group @if($errors->has($slot.'.'.$lang)) has-error @endif">
    <label class="col-md-2 control-label">{{ __("$label") }}
        @if($required)
        <span class="required">*</span>
        @endif
    </label>
    @php
    $first = 0;
    @endphp
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)                          
    <div class="@if($first > 0) col-md-offset-2 @endif col-md-10">
        @php
        $first++;
        if(isset($model))
            $translation = $model->translateOrDefault("$localeCode");
        $dir = 'ltr';                                        
        if($localeCode == 'ar')
            $dir = 'rtl';
        @endphp
        @if($type != 'textarea')
        <input type="{{ $type }}" class="form-control @isset($class) {{ $class }} @endisset" name="{{ $slot }}[{{$localeCode}}]" dir="{{ $dir }}" @if(isset($model)) value="{{ $translation->$slot }}"  @else value='{{ old("$slot.$localeCode") }}' @endif>
        @else
        <textarea rows="7" class="form-control @isset($class) {{ $class }} @endisset" name="{{ $slot }}[{{$localeCode}}]" dir="{{ $dir }}"> @if(isset($model)) {!! $translation->$slot !!}  @else {!! old("$slot.$localeCode") !!} @endif</textarea>
        @endif
        <span class="help-block">{{ $properties['native'] }}</span>  
    </div>    
    <div class="clearfix"> </div> <br />                                                                                  
    @endforeach 
</div>