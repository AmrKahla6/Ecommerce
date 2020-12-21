@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('social_settings.update', $social->id) }}">
    @csrf
    @method('PUT')
    <div class="form-body">
        <div class="form-group form-md-line-input @if($errors->has('icon')) has-error @endif">
            <label class="col-md-2 control-label">{{ __('Icon') }}</label>
            <div class="col-md-10">
                <select class="js-example-basic-single js-states form-control" id="icon" name="icon">
                    <option value='facebook-f'>&#xf09a; facebook</option>
                    <option value='twitter'>&#xf099; twitter</option>
                    <option value='instagram'>&#xf16d; instagram</option>
                    <option value='youtube'>&#xf167; youtube</option>
                    <option value='google-plus'>&#xf0d5; google-plus</option>
                    <option value='vimeo'>&#xf27d; vimeo</option>
                    <option value='skype'>&#xf17e; skype</option>
                    <option value='linkedin'>&#xf0e1; fa-linkedin</option>
                    <option value='tumblr'>&#xf173; fa-tumblr</option> 
                </select>
            </div>
        </div>
        @component('input', ['type' => 'url', 'label' => 'URL', 'required' => true, 'value' => $social->url])
            url
        @endcomponent
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-2 col-md-10">
                <button type="rest" class="btn btn-default">{{ __('Cancel')}}</button>
                <button type="submit" class="btn btn-primary">{{ __('Submit')}}</button>
            </div>
        </div>
    </div>
</form>
@endsection
@section('css')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<style>
	select{
		font-family: fontAwesome
	}
</style>
@endsection
@section('js')
<script>
$(document).ready(function (){
    var icon = "{{ old('icon') ? old('icon') : $social->icon }}";
    if(icon){
        $("option[value=" + icon + "]").attr("selected", "")
    }
});
</script>
@endsection