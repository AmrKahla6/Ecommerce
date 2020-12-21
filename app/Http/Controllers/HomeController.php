<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Setting;
use App\Homesection1;
use App\Homesection2;
use App\Product;
use App\Testimation;

use App\Blog;
use App\Status;
use Hash;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
  
    public function product()
    {
        $products=Product::all();
        return view('site.product',compact('products'));
    }
    public function blog()
    {
        return view('site.blog');
    }
    public function indexeco(Request $request)
    {
        $status          = Status::where('slug','active')->firstOrFail()->id;
        $blogs           = Blog::where('status_id',$status)->latest()->inRandomOrder()->limit(3)->get();
        $home_section_1s = Homesection1::all();
        $home_section_2s = Homesection2::all();
        $testimations    = Testimation::all();
       
        return view('site.indexecommerce',compact('blogs','home_section_1s','home_section_2s' , 'testimations'));
    }

    public function image_show($filename = null)
    {
        return Image::make(storage_path('app/public/' . $filename))->response();
    }
    public function image_show_thumb($filename = null)
    {
        return Image::make(storage_path('app/public/th/' . $filename))->response();
    }

    public function file_show($filename = null)
    {
        return response()->file(storage_path('app/public/' . $filename));
    }
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
 
    public function dashboard()
    {
        // return auth()->user()->email;;
        $setting=Setting::first();
        // return auth()->user()->hasPermission('setting-index');
        // return auth()->user()->with('roles.permissions')->first();
        return view('dashboard.layouts.app',compact('setting'));
    }
 
}
