@include('site.layout.header')
    @if(session()->has('success'))
		<div id="error" class="alert alert-dismissable alert-success">
			<strong>
				{!! session()->get('success') !!}
			</strong>
		</div>
	@endif
	@if (session()->has('error'))
		<div id="error" class="alert alert-dismissable alert-danger">
			<strong>
				{!! session()->get('error') !!}
			</strong>
		</div>
	@endif
	@if (count($errors->all()))
		<div  id="error" class="alert alert-dismissable alert-danger">
			@foreach ($errors->all() as $error)
				<li><strong>{!! $error !!}</strong></li>
			@endforeach
		</div>
	@endif
@yield('content')
@yield('foo')
@include('site.layout.footer')