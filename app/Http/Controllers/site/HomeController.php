<?php

namespace App\Http\Controllers\site;
use App\Product;
use App\Status;
use App\Subcategory;
use App\Contact;
use App\Subscripe;
use App\Category;
use App\Subsubcategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    public function about(Request $request)
    {
        return view('site.about');
    }
    public function contact()
    {
        return view('site.contact');
    }

    public function save_contact(Request $request)
    {
        $request->validate([
            'email'              =>'required|string|email|max:255',
            'name'               => 'required|string|max:255',
            'phone'              => 'nullable|string|max:255',
            'message'            => 'required|string',
        ]);
        $contact                = new Contact();
        $contact->name          = $request->name;
        $contact->message       = $request->message;
        $contact->phone         = $request->phone;
        $contact->email         = $request->email;
        $contact->save();
        session()->flash('success', 'message sent successfully');
        return redirect()->back();
    }

    public function save_subscripe(Request $request)
    {
        $request->validate([
            'email'              =>'required|string|email|max:255|unique:subscripes',
        ]);
        $subscripe                = new Subscripe();
        $subscripe->email         = $request->email;
        $subscripe->save();
        session()->flash('success', 'subscripe successfully');
        return redirect()->back();
    }

    public function search(Request $request)
    {
        return $request;
        $status=Status::where('slug','active')->firstOrFail()->id;
        if(isset($request->search)){
            $type_of_search=$request->search;
            $products     = Product::whereTranslationLike('description', '%'. $request->search .'%')->orWhereTranslationLike('name', '%'. $request->search .'%')->latest()->paginate(12);
        }
        elseif(isset($request->type) && $request->the_type==''){
            if($request->type=="new_arrival"){
                $type_of_search="new_arrival";
                $products     = Product::where('created_at','>=',$request->duration)->latest()->paginate(12);
            }elseif($request->type=="sale"){
                $type_of_search="sale";
                $products     = Product::where('sale', '!=' ,null )->latest()->paginate(12);
            }elseif($request->type=="offer"){
                $type_of_search="offer";
                $products     = Product::whereHas('productoffers')->latest()->paginate(12);
            }else{
                $products     = Product::whereTranslationLike('description', '%'. $request->search .'%')->orWhereTranslationLike('name', '%'. $request->search .'%')->where('price','>=',$request->to)->latest()->paginate(12);
            }
        }
        elseif(isset($request->the_type) ){
            if($request->from && $request->to==null){
                if($request->the_type=="new_arrival"){
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }elseif($request->the_type=="sale"){
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }elseif($request->the_type=="offer"){
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }elseif(is_numeric($request->the_type)){
                    $subsubcategory=Subsubcategory::find($request->the_type);
                    $status=Status::where('slug','active')->firstOrFail()->id;
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }else{
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            // return $request;
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->where('city_id',$request->city)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('price','>=',$request->from)->where('city_id',$request->city)->where('is_free',1)->where('status_id',$status)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('price','>=',$request->from)->where('is_free',1)->where('status_id',$status)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('price','>=',$request->from)->where('city_id',$request->city)->where('is_free',1)->where('status_id',$status)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('price','>=',$request->from)->where('city_id',$request->city)->where('is_free',1)->where('status_id',$status)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('price','>=',$request->from)->where('city_id',$request->city)->where('is_free',1)->where('status_id',$status)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->from)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }
            }elseif($request->to && $request->from==null){
                if($request->the_type=="new_arrival"){
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            // return $request;
                            $products     = Product::where('created_at','>=',$request->duration)->where('price','<=',$request->to)->where('city_id',$request->city)->where('is_free',1)->where('status_id',$status)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::where('created_at','>=',$request->duration)->where('price','<=',$request->to)->where('is_free',1)->where('status_id',$status)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }elseif($request->the_type=="sale"){
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }elseif($request->the_type=="offer"){
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }elseif(is_numeric($request->the_type)){
                    $subsubcategory=Subsubcategory::find($request->the_type);
                    $status=Status::where('slug','active')->firstOrFail()->id;
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }else{
                    // return $request;
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            // return $request;
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->to)->where('city_id',$request->city)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->to)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('price','>=',$request->to)->where('is_free',1)->where('status_id',$status)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','>=',$request->to)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        return $request;
                        if($request->city != null){
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('city_id',$request->city)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('price','<=',$request->to)->where('city_id',$request->city)->where('is_free',1)->where('status_id',$status)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }
            }elseif($request->to && $request->from){
                if($request->the_type=="new_arrival"){
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            // return $request;
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }elseif($request->the_type=="sale"){
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }elseif($request->the_type=="offer"){
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }elseif(is_numeric($request->the_type)){
                    $subsubcategory=Subsubcategory::find($request->the_type);
                    $status=Status::where('slug','active')->firstOrFail()->id;
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }else{
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->where('city_id',$request->city)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('price','>=',$request->from)->where('price','<=',$request->to)->where('city_id',$request->city)->where('is_free',1)->where('status_id',$status)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('price','<=',$request->to)->where('price','>=',$request->from)->where('is_free',1)->where('status_id',$status)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        return $request;
                        if($request->city != null){
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('price','<=',$request->to)->where('price','>=',$request->from)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }
            }elseif($request->to==null && $request->from==null){
                if($request->the_type=="new_arrival"){
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            // return $request;
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::where('created_at','>=',$request->duration)->where('is_free',1)->where('status_id',$status)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }elseif($request->the_type=="sale"){
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::where('sale', '!=' ,null )->where('is_free',1)->where('status_id',$status)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }elseif($request->the_type=="offer"){
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::whereHas('productoffers')->where('is_free',1)->where('status_id',$status)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }elseif(is_numeric($request->the_type)){
                    $subsubcategory=Subsubcategory::find($request->the_type);
                    $status=Status::where('slug','active')->firstOrFail()->id;
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        if($request->city != null){
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = $subsubcategory->products()->where('is_free',1)->where('status_id',$status)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }else{
                    // return $request;
                    if($request->sorting == "heigh_to_low"){
                        if($request->city != null){
                            // return $request;
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('city_id',$request->city)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('city_id',$request->city)->orderBy('price', 'DESC')->paginate(12);
                        }else{
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->orderBy('price', 'DESC')->paginate(12);
                        }
                    }else{
                        return $request;
                        if($request->city != null){
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->where('city_id',$request->city)->orderBy('price', 'ASC')->paginate(12);
                        }else{
                            $products     = Product::whereTranslationLike('description', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->orWhereTranslationLike('name', '%'. $request->the_type .'%')->where('is_free',1)->where('status_id',$status)->orderBy('price', 'ASC')->paginate(12);
                        }
                    }
                }
            }
            $type_of_search=$request->the_type;
        }
        return view('site.product',compact('products','type_of_search'));
    }

    public function all_products_2(Request $request , $id=null){
  
        if(isset($request->search) ){
            $products=Product::whereTranslationLike('description', '%'. $request->search .'%')->orWhereTranslationLike('name', '%'. $request->search .'%')->get();
            if(!empty(Product::whereTranslationLike('description', '%'. $request->search .'%')->orWhereTranslationLike('name', '%'. $request->search .'%')->first()->id)){
                $category=Category::where('id',Product::whereTranslationLike('description', '%'. $request->search .'%')->orWhereTranslationLike('name', '%'. $request->search .'%')->first()->category_id)->first();
                return view('site.all_products_2',compact('category','products','id'));
            }else{
                $no_data = true;
                return view('site.all_products_2',compact('no_data','products','id'));
            }
        }if($id == null){
            session()->flash('error', 'Plz insert value ');
            return redirect()->route('indexeco');
        }

        $category=Subcategory::find($id);
        $products=Product::where('subcategory_id',$category->id);
        if($request->price_sort || $request->from || $request->to || $request->sizes || $request->colors){
            if($request->from){
                $products=$products->where('price', '>=', $request->from );
            } if($request->to){
                $products=$products->where('price', '<=', $request->to );
            } if($request->price_sort == 'heigh_to_low'){
                $products=$products->orderBy('price', 'Asc');
            } if($request->price_sort == 'low_to_heigh'){
                $products=$products->orderBy('price', 'DESC');
            }if($request->colors){
                $products=$products->whereHas('productcolors',function ($query) use ($request){
                    $query->whereIn('color',$request->colors);
                });
            }if($request->sizes){
                $products=$products->whereHas('productsizes',function ($query) use ($request){
                    $query->whereIn('size',$request->sizes);
                });
            }
            // return $request;
            $products= $products->get();
        }else{
            $products=Subcategory::find($id)->products;
        }
        return view('site.all_products_2',compact('category','products','id'));
    }

    public function all_products(Request $request , $id=null){
        // return $request->price_sort;
        if(isset($request->search) ){
            $products=Product::whereTranslationLike('description', '%'. $request->search .'%')->orWhereTranslationLike('name', '%'. $request->search .'%')->get();
            if(!empty(Product::whereTranslationLike('description', '%'. $request->search .'%')->orWhereTranslationLike('name', '%'. $request->search .'%')->first()->id)){
                $category=Category::where('id',Product::whereTranslationLike('description', '%'. $request->search .'%')->orWhereTranslationLike('name', '%'. $request->search .'%')->first()->category_id)->first();
                return view('site.all_products',compact('category','products'));
            }else{
                $no_data = true;
                return view('site.all_products',compact('no_data','products'));
            }
        }if($id == null){
            session()->flash('error', 'Plz insert value ');
            return redirect()->route('indexeco');
        }

        $category=Category::find($id);
        $products=Product::where('category_id',$category->id);
        if($request->price_sort || $request->from || $request->to || $request->sizes || $request->colors){
            if($request->from){
                $products=$products->where('price', '>=', $request->from );
            } if($request->to){
                $products=$products->where('price', '<=', $request->to );
            } if($request->price_sort == 'heigh_to_low'){
                $products=$products->orderBy('price', 'DESC');
            } if($request->price_sort == 'low_to_high'){
                $products=$products->orderBy('price', 'ASC');
                // return $products;
            }if($request->colors){
                $products=$products->whereHas('productcolors',function ($query) use ($request){
                    $query->whereIn('color',$request->colors);
                });
            }if($request->sizes){
                $products=$products->whereHas('productsizes',function ($query) use ($request){
                    $query->whereIn('size',$request->sizes);
                });
            }
            // return $request;
            $products= $products->get();
        }else{
            $products=Category::find($id)->products;
        }
        return view('site.all_products',compact('category','products'));
    }

    public function product_details( $id){
      
        $product=Product::where('id',$id)->firstOrFail();
        // return $product;
        if($product->is_free==0){
            session()->flash('error', 'the product is not free');
            return redirect()->route('indexeco');
        }
        return view('site.product_details',compact('product'));
    }

  
    
}
