<?php

namespace App\Http\Controllers;
use App\Trackorder;
use App\Faq;
use App\Contactinfo;
use App\Coverpages;
use App\Shipping;
use App\Generalsetting;
use App\About;
use App\Returning;
use LaravelLocalization;
use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Http\Request;
              
class HelpController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dash_track_orders')->only('track_orders');
        $this->middleware('permission:dash_faqs')->only('faqs');
        $this->middleware('permission:dash_shipping')->only('shipping');
        $this->middleware('permission:dash_returns')->only('returns');
        $this->middleware('permission:dash_delete_helps')->only('delete_helps');
        $this->middleware('permission:dash_create_helps')->only(['create_helps', 'save_help']);
        $this->middleware('permission:dash_edit_helps')->only(['edit_helps', 'save_edit_helps']);
        $this->middleware('permission:dash_about')->only(['about', 'save_about']);
        $this->middleware('permission:dash_edit_general_setting')->only(['edit_general_setting', 'save_general_setting']);
    }

    public function edit_coverPages()
    {
        $cover_pages=Coverpages::firstOrFail();
        return view('dashboard.settings.cover_pages',compact('cover_pages'));
    }


    public function save_coverPages(Request $request)
    {
        $request->validate([
            'cover_testimations'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cover_blog_deatails'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cover_blog_deatails'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cover_cart'                => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cover_checkout'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cover_contact'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cover_login'               => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cover_shop'                => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cover_product_details'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cover_favourite'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
        $cover_pages=Coverpages::firstOrFail();
        if($request->hasFile('cover_testimations')){
            $image = $request->cover_footer;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1920, 475)->save($path);
            $cover_pages->cover_testimations        =$filename;
            $cover_pages->save(); 
        }
        if($request->hasFile('cover_favourite')){
            $image = $request->cover_favourite;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1920, 320)->save($path);
            $cover_pages->cover_favourite        =$filename;
            $cover_pages->save(); 
        }
        if($request->hasFile('cover_blog')){
            $image = $request->cover_blog;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1920, 320)->save($path);
            $cover_pages->cover_blog        =$filename;
            $cover_pages->save(); 
        }
        if($request->hasFile('cover_blog_deatails')){
            $image = $request->cover_blog_deatails;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1920, 320)->save($path);
            $cover_pages->cover_blog_deatails        =$filename;
            $cover_pages->save(); 
        }
        if($request->hasFile('cover_cart')){
            $image = $request->cover_cart;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1920, 320)->save($path);
            $cover_pages->cover_cart        =$filename;
            $cover_pages->save(); 
        }
        if($request->hasFile('cover_checkout')){
            $image = $request->cover_checkout;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1920, 320)->save($path);
            $cover_pages->cover_checkout        =$filename;
            $cover_pages->save(); 
        }
        if($request->hasFile('cover_contact')){
            $image = $request->cover_contact;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1920, 320)->save($path);
            $cover_pages->cover_contact        =$filename;
            $cover_pages->save(); 
        }
        if($request->hasFile('cover_login')){
            $image = $request->cover_login;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1920, 666)->save($path);
            $cover_pages->cover_login        =$filename;
            $cover_pages->save(); 
        }
        if($request->hasFile('cover_shop')){
            $image = $request->cover_shop;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1920, 320)->save($path);
            $cover_pages->cover_shop        =$filename;
            $cover_pages->save(); 
        }
        if($request->hasFile('cover_product_details')){
            $image = $request->cover_product_details;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1920, 320)->save($path);
            $cover_pages->cover_product_details        =$filename;
            $cover_pages->save(); 
        }
        return redirect()->back()->with(['status' => 'success', 'message' => __('updated successfully')]);
    
    }

    public function edit_contact_info()
    {
        $contact_info=Contactinfo::firstOrFail();
        return view('dashboard.contacts.edit_contact_info',compact('contact_info'));
    }

    public function save_contact_info(Request $request)
    {
        // return $request;
        $this->validate_trans($request, [
            ['location', 'required|string|max:255'],
        ]);
        $request->validate([
            'cover'                => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'email'                => 'nullable|email',
            'mobile'               => 'nullable|string|max:255',
        ]);
        $contact_info=Contactinfo::firstOrFail();
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $contact_info->{"location:$localeCode"}  = $request->location["$localeCode"];
        }
        $contact_info->email  = $request->email;
        $contact_info->mobile  = $request->mobile;
   
        if($request->hasFile('cover')){
            $image = $request->cover;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1920, 320)->save($path);
            $contact_info->cover        =$filename;
        }
        $contact_info->save();
        return redirect()->back()->with(['status' => 'success', 'message' => __('updated successfully')]);
    }
    
    public function track_orders()
    {
        $track_orders=Trackorder::all();
        return view('dashboard.helps.track_orders',compact('track_orders'));
    }
    public function faqs()
    {
        $faqs=Faq::all();
        return view('dashboard.helps.faqs',compact('faqs'));
    }
    public function shipping()
    {
        $shipping=Shipping::all();
        return view('dashboard.helps.shipping',compact('shipping'));
    }
    public function returns()
    {
        $returning=Returning::all();
        return view('dashboard.helps.returning',compact('returning'));
    }

    public function create_helps(Request $request)
    { 
        $type=$request->type;
        return view('dashboard.helps.create_help',compact('type'));
    }

    public function save_help(Request $request)
    {
        $type=$request->kind_of_type;
        if( $request->question["en"] == null || $request->question["ar"] == null  || $request->question["ur"] == null  ){
            return view('dashboard.helps.create_help',compact('type'));
        }
        if( $request->answer["en"] == null || $request->answer["ar"] == null  || $request->answer["ur"] == null  ){
            return view('dashboard.helps.create_help',compact('type'));
        }
        if($request->kind_of_type=="track_order"){
            $value=new Trackorder;
        }
        if($request->kind_of_type=="faqs"){
            $value=new Faq;
        }
        if($request->kind_of_type=="returning"){
            $value=new Returning;
        }
        if($request->kind_of_type=="shipping"){
            $value=new Shipping;
        }
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $value->{"question:$localeCode"}      = $request->question["$localeCode"];
            $value->{"answer:$localeCode"}        = $request->answer["$localeCode"];
        }
        $value->save();

        if($request->kind_of_type=="track_order"){
            return redirect()->route('track_orders')->with(['status' => 'success', 'message' => __('Stored successfully')]);
        }
        if($request->kind_of_type=="shipping"){
            return redirect()->route('shipping')->with(['status' => 'success', 'message' => __('Stored successfully')]);
        }
        if($request->kind_of_type=="returning"){
            return redirect()->route('returns')->with(['status' => 'success', 'message' => __('Stored successfully')]);
        }
        if($request->kind_of_type=="faqs"){
            return redirect()->route('faqs')->with(['status' => 'success', 'message' => __('Stored successfully')]);
        }
    }

    public function edit_helps(Request $request, $id)
    {
        if($request->type=="track_order"){
            $value= Trackorder::find($id);
            $type=$request->type;
        }elseif($request->type=="faqs"){
            $value= Faq::find($id);
            $type=$request->type;
        }elseif($request->type=="returning"){
            $type=$request->type;
            $value= Returning::find($id);
        }elseif($request->type=="shipping"){
            $type=$request->type;
            $value= Shipping::find($id);
        }
        return view('dashboard.helps.edit_help',compact('value','type'));
    }

    public function save_edit_helps(Request $request,$id)
    {
        // return $request;
        $type=$request->kind_of_type;
        if( $request->question["en"] == null || $request->question["ar"] == null  || $request->question["ur"] == null  ){
            return view('dashboard.helps.create_help',compact('type'));
        }
        if( $request->answer["en"] == null || $request->answer["ar"] == null  || $request->answer["ur"] == null  ){
            return view('dashboard.helps.create_help',compact('type'));
        }
        if($request->kind_of_type=="track_order"){
            $value= Trackorder::find($id);
        }
        if($request->kind_of_type=="faqs"){
            $value= Faq::find($id);
        }
        if($request->kind_of_type=="returning"){
            $value= Returning::find($id);
        }
        if($request->kind_of_type=="shipping"){
            $value= Shipping::find($id);
        }
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $value->{"question:$localeCode"}      = $request->question["$localeCode"];
            $value->{"answer:$localeCode"}        = $request->answer["$localeCode"];
        }
        $value->save();

        if($request->kind_of_type=="track_order"){
            return redirect()->route('track_orders')->with(['status' => 'success', 'message' => __('Stored successfully')]);
        }
        if($request->kind_of_type=="shipping"){
            return redirect()->route('shipping')->with(['status' => 'success', 'message' => __('Stored successfully')]);
        }
        if($request->kind_of_type=="returning"){
            return redirect()->route('returns')->with(['status' => 'success', 'message' => __('Stored successfully')]);
        }
        if($request->kind_of_type=="faqs"){
            return redirect()->route('faqs')->with(['status' => 'success', 'message' => __('Stored successfully')]);
        }
    }

    public function delete_helps(Request $request, $id)
    {
        if($request->kind_of_type=="track_order"){
            $value= Trackorder::find($id);
        }
        if($request->type=="faqs"){
            $value= Faq::find($id);
        }
        if($request->type=="returning"){
            $value= Returning::find($id);
        }
        if($request->type=="shipping"){
            $value= Shipping::find($id);
        }
        $value->delete();
        return redirect()->back()->with(['status' => 'success', 'message' => __('deleted successfully')]);
    }

    public function about()
    {
        $about=\App\About::where('id',1)->firstOrFail();
        return view('dashboard.helps.about',compact('about'));
    }

    public function save_about(Request $request)
    {
        $this->validate_trans($request, [
            ['description', 'required|string|max:255'],
            ['title', 'required|string|max:255'],
            ['why_choose', 'nullable|string|max:255'],

            ['why_choose_title_1', 'nullable|string|max:255'],
            ['why_choose_title_2', 'nullable|string|max:255'],
            ['why_choose_title_3', 'nullable|string|max:255'],
            ['why_choose_title_4', 'nullable|string|max:255'],
            ['why_choose_desc_1', 'nullable|string|max:255'],
            ['why_choose_desc_2', 'nullable|string|max:255'],
            ['why_choose_desc_3', 'nullable|string|max:255'],
            ['why_choose_desc_4', 'nullable|string|max:255'],

        ]);
        $request->validate([
            'cover'                => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',

            'why_choose_image_1'                => 'nullable|string|max:255',
            'why_choose_image_2'                => 'nullable|string|max:255',
            'why_choose_image_3'                => 'nullable|string|max:255',
            'why_choose_image_4'                => 'nullable|string|max:255',
        ]);
        $about         =About::find(1);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $about->{"description:$localeCode"}  = $request->description["$localeCode"];
            $about->{"title:$localeCode"}        = $request->title["$localeCode"];
            $about->{"why_choose:$localeCode"}        = $request->why_choose["$localeCode"];

            $about->{"why_choose_title_1:$localeCode"}        = $request->why_choose_title_1["$localeCode"];
            $about->{"why_choose_title_2:$localeCode"}        = $request->why_choose_title_2["$localeCode"];
            $about->{"why_choose_title_3:$localeCode"}        = $request->why_choose_title_3["$localeCode"];
            $about->{"why_choose_title_4:$localeCode"}        = $request->why_choose_title_4["$localeCode"];
            $about->{"why_choose_desc_1:$localeCode"}        = $request->why_choose_desc_1["$localeCode"];
            $about->{"why_choose_desc_2:$localeCode"}        = $request->why_choose_desc_2["$localeCode"];
            $about->{"why_choose_desc_3:$localeCode"}        = $request->why_choose_desc_3["$localeCode"];
            $about->{"why_choose_desc_4:$localeCode"}        = $request->why_choose_desc_4["$localeCode"];
        }
        $about->why_choose_image_1  = $request->why_choose_image_1;
        $about->why_choose_image_2  = $request->why_choose_image_2;
        $about->why_choose_image_3  = $request->why_choose_image_3;
        $about->why_choose_image_4  = $request->why_choose_image_4;

        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(960, 450)->save($path);
            $about->image        =$filename;
        }
        if($request->hasFile('cover')){
            $image = $request->cover;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1920, 320)->save($path);
            $about->cover        =$filename;
        }
        $about->save();
        return redirect()->back()->with(['status' => 'success', 'message' => __('updated successfully')]);
    }

    public function edit_general_setting()
    {
        $general_setting=\App\Generalsetting::where('id',1)->firstOrFail();
        return view('dashboard.helps.edit_general_setting',compact('general_setting'));
    }
  
    public function save_general_setting(Request $request)
    {
        $this->validate_trans($request, [
            ['terms_condition', 'required|string'],
            ['desc_of_politic_register_user', 'required|string'],
            ['title_politic_register_user', 'required|string|max:255'],
            ['title_politic_register_company', 'required|string|max:255'],
            ['desc_of_politic_register_company', 'required|string|max:255'],


            ['title_of_div_6_of_home_section_2', 'required|string|max:255'],
            ['desc_of_div_6_of_home_section_2', 'required|string|max:255'],
            ['button_of_div_6_of_home_section_2', 'required|string|max:255'],

            ['desc_in_above_navbar', 'required|string|max:255'],
            ['get_touch', 'required|string|max:255'],
            ['desc_get_touch', 'required|string|max:255'],
            ['copy_right', 'required|string|max:255'],
            ['title_of_shipping', 'required|string|max:255'],
            ['title_of_track_order', 'required|string|max:255'],
            ['title_of_fqa', 'required|string|max:255'],
            ['title_of_returns', 'required|string|max:255'],
        ]);
        $request->validate([
            'link_of_track_order' => 'required|url',
            'logo'                => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'email_above_navbar'  => 'required|email',
        ]);

        $general_setting         =Generalsetting::find(1);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $general_setting->{"terms_condition:$localeCode"}                      = $request->terms_condition["$localeCode"];
            $general_setting->{"title_politic_register_user:$localeCode"}          = $request->title_politic_register_user["$localeCode"];
            $general_setting->{"desc_of_politic_register_user:$localeCode"}        = $request->desc_of_politic_register_user["$localeCode"];
            $general_setting->{"title_politic_register_company:$localeCode"}       = $request->title_politic_register_company["$localeCode"];
            $general_setting->{"desc_of_politic_register_company:$localeCode"}     = $request->desc_of_politic_register_company["$localeCode"];

            $general_setting->{"title_of_div_6_of_home_section_2:$localeCode"}  = $request->title_of_div_6_of_home_section_2["$localeCode"];
            $general_setting->{"desc_of_div_6_of_home_section_2:$localeCode"}   = $request->desc_of_div_6_of_home_section_2["$localeCode"];
            $general_setting->{"button_of_div_6_of_home_section_2:$localeCode"} = $request->button_of_div_6_of_home_section_2["$localeCode"];

            $general_setting->{"desc_in_above_navbar:$localeCode"}  = $request->desc_in_above_navbar["$localeCode"];
            $general_setting->{"get_touch:$localeCode"}             = $request->get_touch["$localeCode"];
            $general_setting->{"desc_get_touch:$localeCode"}        = $request->desc_get_touch["$localeCode"];
            $general_setting->{"copy_right:$localeCode"}            = $request->copy_right["$localeCode"];
            $general_setting->{"title_of_shipping:$localeCode"}     = $request->title_of_shipping["$localeCode"];
            $general_setting->{"title_of_track_order:$localeCode"}  = $request->title_of_track_order["$localeCode"];
            $general_setting->{"title_of_fqa:$localeCode"}          = $request->title_of_fqa["$localeCode"];
            $general_setting->{"title_of_returns:$localeCode"}      = $request->title_of_returns["$localeCode"];
        }
        $general_setting->link_of_track_order  = $request->link_of_track_order;
        $general_setting->email_above_navbar   = $request->email_above_navbar;
        if($request->hasFile('logo')){
            $image = $request->logo;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(120, 27)->save($path);
            $general_setting->logo        =$filename;
        }
        $general_setting->save();
        return redirect()->back()->with(['status' => 'success', 'message' => __('updated successfully')]);
    }
}
