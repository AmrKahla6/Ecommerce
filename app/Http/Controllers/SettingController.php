<?php

namespace App\Http\Controllers;
use App\Setting;
use App\Homesection1;
use App\Homesection2;
use App\Homesection4;
use App\Category;
use App\Subcategory;
use App\Homesection2s;

use Illuminate\Http\Request;
use App\Helper\FileManager;
use LaravelLocalization;
use Intervention\Image\ImageManagerStatic as Image;

class SettingController extends Controller
{
    public function __constuct() {
        $this->middleware('permission:home_section_1')->only('home_section_1');
        $this->middleware('permission:edit_home_section_1')->only([ 'edit_home_section_1','save_edit_home_section_1']);
        $this->middleware('permission:edit_home_section_2')->only('edit_home_section_2','save_edit_home_section_2');   
        $this->middleware('permission:home_section_2')->only([ 'home_section_2']);
        $this->middleware('permission:edit_home_section_3')->only('edit_home_section_3','save_edit_home_section_3');   
        $this->middleware('permission:edit_home_section_4')->only([ 'edit_home_section_4','save_edit_home_section_4']);
    }

    public function home_section_1(){
        $homesection1s=Homesection1::all();
        return view('dashboard.settings.homesection1',compact('homesection1s'));
    }

    public function create_home_section_1(){
        return view('dashboard.settings.create_home_section_1',compact('homesection1s'));
    }

    public function save_home_section_1(Request $request )
    {
        $request->validate([
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $this->validate_trans($request, [
            ['title', 'required|string|max:255'],
            ['description', 'required|string|max:255'],
            ['button', 'required|string|max:255'],
        ]);
        
        $homesection1s =  new Homesection1;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $homesection1s->{"title:$localeCode"}         = $request->title["$localeCode"];
            $homesection1s->{"description:$localeCode"}   = $request->description["$localeCode"];
            $homesection1s->{"button:$localeCode"}        = $request->button["$localeCode"];
        }
        $homesection1s->duration_of_new_arrival         = $request->duration_of_new_arrival;   
        $homesection1s->category_id                     = $request->category;   
        $homesection1s->subcategory_id                 = $request->subcategory;  
        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1400, 300)->save($path);
            $homesection1s->image        =$filename;
        }
        $homesection1s->save();
        return redirect()->route('home_section_1')->with(['status' => 'success', 'message' => __('updated successfully')]);
    }

    public function edit_home_section_1($id){
        $homesection1=Homesection1::find($id);
        $p_category=Category::find($homesection1->category_id);
        $p_subcategories=Subcategory::where('category_id',$p_category->id)->get();
        return view('dashboard.settings.edit_home_section_1',compact('homesection1','p_category','p_subcategories'));
    }
    public function save_edit_home_section_1(Request $request ,$id)
    {
        $request->validate([
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $this->validate_trans($request, [
            ['title', 'required|string|max:255'],
            ['description', 'required|string|max:255'],
            ['button', 'required|string|max:255'],
        ]);
        
        $homesection1s =  Homesection1::find($id);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $homesection1s->{"title:$localeCode"}         = $request->title["$localeCode"];
            $homesection1s->{"description:$localeCode"}   = $request->description["$localeCode"];
            $homesection1s->{"button:$localeCode"}        = $request->button["$localeCode"];
        }
        $homesection1s->category_id                     = $request->category;   
        $homesection1s->subcategory_id                  = $request->subcategory;     
        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(1400, 300)->save($path);
            $homesection1s->image        =$filename;
        }
        $homesection1s->save();
        return redirect()->route('home_section_1')->with(['status' => 'success', 'message' => __('updated successfully')]);
    }

    public function destroy_homesection1s($id)
    {
        $homesection1s = Homesection1::findOrFail($id);
        $homesection1s->delete();
        return redirect()->route('home_section_1');
    }

    public function home_section_2(){
        $homesection2s=Homesection2::all();
        return view('dashboard.settings.homesection2',compact('homesection2s'));
    }

    public function create_home_section_2(){
        return view('dashboard.settings.create_home_section_2',compact('homesection2s'));
    }

    public function save_home_section_2(Request $request )
    {
        $request->validate([
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $this->validate_trans($request, [
            ['title', 'required|string|max:255'],
            ['description', 'required|string|max:255'],
        ]);
        
        $homesection2s =  new Homesection2;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $homesection2s->{"title:$localeCode"}         = $request->title["$localeCode"];
            $homesection2s->{"description:$localeCode"}   = $request->description["$localeCode"];
        }
        $homesection2s->category_id                     = $request->category;   
        $homesection2s->subcategory_id                 = $request->subcategory;  
        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(390, 450)->save($path);
            $homesection2s->image        =$filename;
        }
        $homesection2s->save();
        return redirect()->route('home_section_2')->with(['status' => 'success', 'message' => __('updated successfully')]);
    }

    public function edit_home_section_2($id){
        $homesection2=Homesection2::find($id);
        $p_category=Category::find($homesection2->category_id);
        $p_subcategories=Subcategory::where('category_id',$p_category->id)->get();
        return view('dashboard.settings.edit_home_section_2',compact('homesection2','p_category','p_subcategories'));
    }

    public function save_edit_home_section_2(Request $request ,$id)
    {
        $request->validate([
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $this->validate_trans($request, [
            ['title', 'required|string|max:255'],
            ['description', 'required|string|max:255'],
        ]);
        $homesection2 =  Homesection2::find($id);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $homesection2->{"title:$localeCode"}         = $request->title["$localeCode"];
            $homesection2->{"description:$localeCode"}   = $request->description["$localeCode"];
        }
        $homesection2->category_id                     = $request->category;   
        $homesection2->subcategory_id                 = $request->subcategory;  
        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('/app/public/' . $filename);
            Image::make($image->getRealPath())->resize(390, 450)->save($path);
            $homesection2->image        =$filename;
        }
        $homesection2->save();
        return redirect()->route('home_section_2')->with(['status' => 'success', 'message' => __('updated successfully')]);
    } 

    public function destroy_homesection2s($id)
    {
        $homesection2s = Homesection2::findOrFail($id);
        $homesection2s->delete();
        return redirect()->route('home_section_2');
    }

  

    public function edit_home_section_3(){
            $homesection3=\App\Homesection3::find(1);
            return view('dashboard.settings.edit_home_section_3',compact('homesection3'));
     
    }
    public function save_edit_home_section_3(Request $request)
    {
        $this->validate_trans($request, [
            ['title', 'required|string|max:255'],
        ]);
        
        $homesection3=\App\Homesection3::find(1);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $homesection3->{"title:$localeCode"}         = $request->title["$localeCode"];
        }
        $homesection3->type        =$request->type;
        $homesection3->save();
        return redirect()->back()->with(['status' => 'success', 'message' => __('updated successfully')]);
    } 

    public function edit_home_section_4(){
        if(\App\Homesection4::find(1) !== null){
            $homesection4=\App\Homesection4::find(1);
            return view('dashboard.settings.edit_home_section_4',compact('homesection4'));
        }else{
            return view('dashboard.settings.edit_home_section_4');
        }
    }

    public function save_edit_home_section_4(Request $request)
    {
        $request->validate([
            'product_id'       => 'nullable|exists:products,id',
            'aggregation_id'   => 'nullable|exists:aggregations,id',
            'aucation_id'      => 'nullable|exists:aucations,id',
        ]);
        if(Homesection4::find(1) !== null){
            $homesection4=Homesection4::find(1);
        }else{
            $homesection4=new Homesection4;
        }
        $homesection4->product_id       =$request->product_id;
        $homesection4->aucation_id      =$request->aucation_id;
        $homesection4->aggregation_id   =$request->aggregation_id;
        $homesection4->save();
        return redirect()->back()->with(['status' => 'success', 'message' => __('updated successfully')]);
    }

    public function update(Request $request , $id){
        // $request->validate([
        //     'order'     => 'required|integer',
        //     'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        // ]);
        // foreach(LaravelLocalization::getSupportedLocales() as $locale => $prop) {
        //     $this->validate($request,[
        //         "title.$locale"       => 'required|string',
        //         "description.$locale" => 'required|string',
        //     ]);
        //  }

        // $setting                =Setting::find($id);
        // $setting->order         =$request->order;
        // foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
        //     $setting->{"title:$localeCode"}    = $request->title["$localeCode"];
        //     $setting->{"description:$localeCode"}    = $request->description["$localeCode"];
        // }
        // if($request->hasFile('image'))
        // $setting->image              = FileManager::upload_image($request, 'image', 1000, 1000);
        // $setting->save();
        // return redirect()->route('dashboard')->with(['status' => 'success', 'message' => __('updated successfully')]);
    }
}
