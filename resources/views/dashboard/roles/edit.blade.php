@extends('dashboard.layouts.app')
@section('title')
    edit Setting
@endsection
@section('content')
<form role="form" class="form-horizontal" method="POST" action="{{ route('roles.update', $role->id) }}">
    @csrf
    @method('PUT')
    <div class="form-body">
    <div class="form-group form-md-line-input">
        <label class="col-md-2 control-label" >name <span class="required">*</span> </label>
        <div class="col-md-10">
            <input type="text"  value="@if(old('name')) {!! old('name') !!}  @else {{$role->name}}  @endif " class="form-control"  name="name" placeholder="name"     >
            <div class="form-control-focus"> </div>
        </div>
    </div>

    <div class="form-group form-md-line-input">
        <label class="col-md-2 control-label" >description <span class="required">*</span> </label>
        <div class="col-md-10">
            <input type="text" value="@if(old('description'))  {!! old('description') !!} @else {{$role->description}}  @endif " class="form-control"  name="description" placeholder="description"     >
            <div class="form-control-focus"> </div>
        </div>
    </div>
   
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $prop)
    @php
        $translation = $role->translateOrDefault("$locale");
    @endphp
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label" >Display Name:{{ $locale }} <span class="required">*</span> </label>
            <div class="col-md-10">
                                   
                <textarea class="form-control" value=""  rows="3"  name="display_name[{{ $locale }}]" placeholder="Display Name ">@if( old('display_name') ) {!! old("display_name.$locale") !!} @else {!! $translation->display_name !!} @endif </textarea>
                <div class="form-control-focus"> </div>
            </div>
        </div>
    @endforeach
        <div class="form-group form-md-line-input">
            <label class="col-md-2 control-label">{{ ucfirst(__('permissions')) }}</label>
            <div class="col-md-10">
                @forelse ($category_permissions as $category_permission)
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $category_permission->name }}</div>
                    <div class="panel-body">
                        <div class="md-checkbox-inline">
                            @foreach($category_permission->permissions()->get() as $permission)
                            <div class="md-checkbox">
                                <input type="checkbox" id="permission_{{ $permission->id }}" name="permissions[]" class="md-check"  value="{{ $permission->id }}" @if(old('permissions')) @if(in_array($permission->id, old('permissions'))) checked @endif @else @if(in_array($permission->id, $selected)) checked @endif  @endif>
                                <label for="permission_{{ $permission->id }}">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ $permission->display_name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-danger">{{ __('No category permissions') }}</div>                            
                @endforelse
            </div>
        </div>
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