
<?php
   use Illuminate\Support\Facades\Auth;
   use App\User;

   $user=Auth::user();
      use App\Setting;

      $setting=Setting::first();

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ App::getLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
    <!--<![endif]-->
    @include('dashboard.layouts.head')

    <body class="hold-transition skin-blue fixed sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <!-- logo for regular state and mobile devices -->

                    <span class="logo-mini">title</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">title</span>

                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">

                        <ul class="nav navbar-nav">
                            <!-- Website -->
                            <li class="dropdown" >
                                <a href="{{ route('indexeco') }}" target="_blank" class="dropdown-toggle">{{ __("Go to website") }}</a>
                            </li>
                            <!-- Notifications: style can be found in dropdown.less -->
                            
                            <!-- Languages -->
                            <li class="dropdown" >
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    @foreach(LaravelLocalization::getSupportedLocales(true) as $localeCode => $properties)
                                        @if($localeCode == App::getLocale())
                                            {{ $properties['native'] }}
                                        @endif
                                    @endforeach
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach(LaravelLocalization::getSupportedLocales(true) as $localeCode => $properties)
                                        @if($localeCode != App::getLocale())
                                        <li>
                                            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                {{ $properties['native'] }}
                                            </a>
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                            
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu" >
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="{{ route('image_show', Auth::user()->image)}}" class="user-image" alt="User Image">
                                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="{{ route('image_show', Auth::user()->image)}}" class="img-circle" alt="User Image">

                                        <p>
                                            {{ Auth::user()->name }}
                                            <small>{{ __("Member since") }} {{ date('Y-m-d H:i', strtotime(Auth::user()->created_at)) }}</small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">{{ __('Logout') }}</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            @if (count($errors->all()))
                <div  id="error" class="alert alert-dismissable alert-danger">
                    <button  type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span  onclick="event.preventDefault();
                                                document.getElementById('error').remove();" aria-hidden="true">&times;</span>
                    </button>
                    @foreach ($errors->all() as $error)
                        <li><strong>{!! $error !!}</strong></li>
                    @endforeach
                </div>
            @endif
            @if (session()->has('success'))
                <div id="error" class="alert alert-dismissable alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span onclick="event.preventDefault();
                                                document.getElementById('error').remove();" aria-hidden="true">&times;</span>
                    </button>
                    <strong>
                        {!! session()->get('success') !!}
                    </strong>
                </div>
            @endif
             <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar:  -->
                <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                    <img src="{{ route('image_show', Auth::user()->image)}}" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ __('online') }}</a>
                    </div>
                </div>

                <!-- sidebar menpu: -->
             
                <ul class="sidebar-menu">
                    <li class="treeview">
                        <a href="#"><i class="fa fa-wrench"></i> <span> {{__('settings')}}</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('edit_home_section_1')
                            <li><a href="{{ route('home_section_1') }}">{{__('home section 1')}}</a></li>
                            @endpermission
                            @permission('home_section_2')
                            <li><a href="{{ route('home_section_2') }}">{{__('home section 2')}}</a></li>
                            @endpermission
                   
                            @permission('dash_edit_general_setting')
                            <li><a href="{{ route('edit_general_setting') }}">{{__('edit_general_setting')}}</a></li>
                            @endpermission
                            @permission('dash_about')
                            <li><a href="{{ route('about') }}">{{__('About Us')}}</a></li>
                            @endpermission
                          
                          
                            <li><a href="{{ route('edit_contact_info') }}">{{__('edit contact info')}}</a></li>
                            <li><a href="{{ route('edit_coverPages') }}">{{__('edit Cover pages')}}</a></li>
                        </ul>
                    </li>
        
                    <li class="treeview">
                        <a href="#"><i class="fa fa-facebook"></i> <span> {{__('social')}}</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('index_social')
                            <li><a href="{{ route('social_settings.index') }}">{{__('all_social')}}</a></li>   
                            @endpermission         
                            @permission('create_social')               
                            <li><a href="{{ route('social_settings.create') }}">{{__('create_social')}}</a></li>
                            @endpermission
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-archive"></i> <span> {{__('categories')}}</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        
                        <ul class="treeview-menu">
                            @permission('index_category')
                            <li><a href="{{ route('categories.index') }}">{{__('categories')}}</a></li>  
                            @endpermission  
                            @permission('create_category')                       
                            <li><a href="{{ route('categories.create') }}">{{__('create_category')}}</a></li>
                            @endpermission
                        </ul>
                    </li>
        
                    <li class="treeview">
                        <a href="#"><i class="fa fa-product-hunt"></i> <span> {{__('products')}}</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('index_product') 
                            <li><a href="{{ route('products.index') }}">{{__('products')}}</a></li> 
                            @endpermission   
                            @permission('create_product')                          
                            <li><a href="{{ route('products.create') }}">{{__('create_product')}}</a></li>
                            @endpermission  
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-product-hunt"></i> <span> {{__('orders')}}</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('dash_all_sold_products')
                            <li><a href="{{ route('all_sold_products') }}">{{__('orders')}}</a></li> 
                            @endpermission                          
                            <!-- <li><a href="{{ route('products.create') }}">{{__('archive')}}</a></li> -->
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-product-hunt"></i> <span> {{__('reviews')}}</span>
                            <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                            </span>  
                        </a>
                        <ul class="treeview-menu">
                            @permission('dash_all_pending_review')
                            <li><a href="{{ route('all_pending_review') }}">{{__('pending_review')}}</a></li>  
                            @endpermission 
                            @permission('dash_all_archived_review')                         
                            <li><a href="{{ route('all_archived_review') }}">{{__('archived_review')}}</a></li>
                            @endpermission 
                        </ul>
                    </li>
                   
                    <li class="treeview">
                        <a href="#"><i class="fa fa-pencil"></i> <span> blogs</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('index_blog')
                            <li><a href="{{ route('blogs.index') }}">blogs</a></li>
                            @endpermission 
                            @permission('create_blog')                          
                            <li><a href="{{ route('blogs.create') }}">{{__('create_blog')}}</a></li>
                            @endpermission
                            @permission('dash_all_suspend_comments')
                            <li><a href="{{ route('all_suspend_comment') }}">{{__('Suspend_Comments')}}</a></li>
                            @endpermission
                   
                        </ul>
                    </li>
     
                    <li class="treeview">
                        <a href="#"><i class="fa fa-desktop"></i> <span> {{__('Contacts')}}</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('index_contact')
                            <li><a href="{{ route('contacts.index') }}">{{__('Contacts')}}</a></li> 
                            @endpermission                          
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-desktop"></i> <span> {{__('subscripe')}}</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('index_subscripe')
                            <li><a href="{{ route('subscripes.index') }}">{{__('subscripe')}}</a></li>
                            @endpermission                            
                        </ul>
                    </li>
            
                    <li class="treeview">
                        <a href="#"><i class="fa fa-address-card"></i> <span> {{__('roles')}}</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @permission('index_role') 
                            <li><a href="{{ route('roles.index') }}">{{__('roles')}}</a></li>
                            @endpermission  
                            @permission('create_role')                          
                            <li><a href="{{ route('roles.create') }}">{{__('create_role')}}</a></li>
                            @endpermission
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-user"></i> <span> {{__('users')}}</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                    
                        <ul class="treeview-menu">
                            @permission('index_user') 
                            <li><a href="{{ route('users.index') }}">{{__('users')}}</a></li> 
                            @endpermission 
                            @permission('index_user')                          
                            <li><a href="{{ route('users.create') }}">{{__('create_user')}}</a></li>
                            @endpermission
                           
                        </ul>
                    </li>
                </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>@yield('title')</h1>
                    @yield('breadcrumbs')
                </section>
                <!-- Main content -->
                <section class="content">
                    @yield('content')
                </section>
                <!-- /.content -->
            </div>
            <footer class="main-footer">
                
                <strong>description</strong>

            </footer>
        </div>
        @include('dashboard.layouts.footer')
    </body>
</html>
