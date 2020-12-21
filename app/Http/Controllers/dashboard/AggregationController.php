<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Aggregation;
use App\Status;
use App\Aggregationimage;
use App\Category;
use App\Aggregationgroup;
use App\Subcategory;
use App\Subsubcategory;
use App\Commentsaucation;
use App\User;
use LaravelLocalization;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;

class AggregationController extends Controller
{
    public function __construct()
    {     
        $this->middleware('permission:index_aggregation')->only('index');
        $this->middleware('permission:create_aggregation')->only(['create', 'store']);
        $this->middleware('permission:view_aggregation')->only('show');
        $this->middleware('permission:edit_aggregation')->only(['edit', 'update']);

        $this->middleware('permission:pending_aggregation_in_dash')->only('pending_aggregation_in_dash');
        $this->middleware('permission:all_pending_quantities')->only('all_pending_quantities');
        $this->middleware('permission:change_status_0f_quantity')->only('change_status_0f_quantity');
        $this->middleware('permission:pending_order_aggregations')->only('pending_order_aggregations');
        $this->middleware('permission:archived_order_aggregations')->only('archived_order_aggregations');
        // $this->middleware('permission:change_status_aggregation_group')->only('change_status_aggregation_group');
    }
    public function index()
    {
        $pending         =Status::where('slug','pending')->firstOrFail()->id;
        $aggregations    =Aggregation::where('status_id','!=',$pending)->get();
        return view('dashboard.aggregations.index',compact('aggregations'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.aggregations.create');
    }
    public function store(Request $request)
    {
        //return $request;
        $request->validate([
            'end_at'                    => 'required|date',
            'all_quantity'              => 'required|numeric',
            'number_of_points_to_join'  => 'required|numeric',
            'price'                     => 'required',
            'productimage'              => 'required',
            'category'                  => 'required|exists:categories,id',
            'subcategory'               => 'required|exists:subcategories,id',
            'subsubcategory'            => 'required|exists:subsubcategories,id',
            'currency'                  => 'required|exists:currencies,id',
            'productimage'              => 'required', 
            'city'                      => 'required|exists:cities,id',           
        ]);
        $this->validate_trans($request, [
            ['title', 'required|string|max:255'],
            ['description', 'required|string'],
        ]);
        $aggregation = new Aggregation;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $aggregation->{"title:$localeCode"}              = $request->title["$localeCode"];
            $aggregation->{"description:$localeCode"}        = $request->description["$localeCode"];
        }
        $aggregation->end_at              = date('Y-m-d H:i', strtotime($request->end_at));
        $aggregation->is_publish_comment  =(boolean)$request->is_publish_comment;
        $aggregation->currency_id         =$request->currency;
        $aggregation->user_id             =Auth()->user()->id;
        $status=Status::where('slug','active')->firstOrFail();
        $aggregation->status_id            =$status->id;
        $aggregation->category_id          =$request->category;
        $aggregation->subcategory_id       =$request->subcategory;
        $aggregation->subsubcategory_id    =$request->subsubcategory;
        $aggregation->price                =$request->price;
        $aggregation->all_quantity         =$request->all_quantity;
        $aggregation->number_of_points_to_join   =$request->number_of_points_to_join;
        $aggregation->city_id                    =$request->city;
        $aggregation->save();
        if(isset($request->productimage)){
            foreach ($request->productimage as  $image) {
                $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
                $path = storage_path('app/public/' . $filename);
                Image::make($image->getRealPath())->resize(800, 400)->save($path);
                $aggregationimage = new Aggregationimage;
                $aggregationimage->image        =$filename;
                $aggregationimage->aggregation_id  =$aggregation->id;
                $aggregationimage->save();
            }
        }
        return redirect()->route('aggregations.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show_quantities($id) 
    {
        $aggregation = Aggregation::find($id);
        return view('dashboard.aggregations.show_quantities', compact('aggregation'));
    }

      public function add_points_from_aggregation(Request $request, $id) 
    {
        $agg_group = Aggregationgroup::find($id);
        $aggregation = Aggregation::find($agg_group->aggregation_id);

        $user=User::find($agg_group->user_id);
        $block=\App\Status::where('slug','block')->firstOrFail(); 
        
        $user->active_points    += ($aggregation->number_of_points_to_join * $agg_group->user_quantity) + $request->number_of_points;
        $user->pending_points   -=  $aggregation->number_of_points_to_join * $agg_group->user_quantity;
        $user->aggregation_points   += $request->number_of_points;
        $user->save();

        $aggregation->current_quantity   -= $agg_group->user_quantity;
        $aggregation->save();
        // return $user;
        $agg_group->status_id   = $block->id;
        $agg_group->save();
        return view('dashboard.aggregations.show_quantities', compact('aggregation'));
    }

    public function edit($id)
    {
        $aggregation = Aggregation::find($id);
        $p_category=Category::find($aggregation->category_id);
        $p_subcategories=Subcategory::where('category_id',$p_category->id)->get();
        $p_subsubcategories=Subsubcategory::where('subcategory_id',$aggregation->subcategory_id)->get();
        return view('dashboard.aggregations.edit', compact('aggregation','p_category','p_subcategories','p_subsubcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
            $request->validate([
                'end_at'                    => 'required|date',
                'all_quantity'              => 'required|numeric',
                'number_of_points_to_join'  => 'required|numeric',
                'price'                     => 'required',
                'productimage'              => 'nullable',
                'category'                  => 'required|exists:categories,id',
                'subcategory'               => 'required|exists:subcategories,id',
                'subsubcategory'            => 'required|exists:subsubcategories,id',
                'currency'                  => 'required|exists:currencies,id',
                'city'                      => 'required|exists:cities,id', 
            ]);
            $this->validate_trans($request, [
                ['title', 'required|string|max:255'],
                ['description', 'required|string'],
            ]);
            $aggregation = Aggregation::find($id);
            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                $aggregation->{"title:$localeCode"}              = $request->title["$localeCode"];
                $aggregation->{"description:$localeCode"}        = $request->description["$localeCode"];
            }
            $aggregation->end_at              = date('Y-m-d H:i', strtotime($request->end_at));
            $aggregation->is_publish_comment  =(boolean)$request->is_publish_comment;
            $aggregation->currency_id         =$request->currency;
            $status=Status::where('slug', $request->status)->firstOrFail();
            $aggregation->status_id            =$status->id;
            $aggregation->category_id          =$request->category;
            $aggregation->subcategory_id       =$request->subcategory;
            $aggregation->subsubcategory_id    =$request->subsubcategory;
            $aggregation->price                =$request->price;
            $aggregation->all_quantity         =$request->all_quantity;
            $aggregation->number_of_points_to_join   =$request->number_of_points_to_join;
            $aggregation->city_id                    =$request->city;
            $aggregation->save();
            if(isset($request->removed_image)){
                foreach($request->removed_image as $remove){
                    foreach($aggregation->aggregationimages as $img){
                        if($img->image==$remove){
                            $img->delete();
                        }
                    }
                }
            }
            if(isset($request->productimage)){
                foreach ($request->productimage as  $image) {
                    $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
                    $path = storage_path('app/public/' . $filename);
                    Image::make($image->getRealPath())->resize(800, 400)->save($path);
                    $aggregationimage = new Aggregationimage;
                    $aggregationimage->image        =$filename;
                    $aggregationimage->aggregation_id  =$aggregation->id;
                    $aggregationimage->save();
                }
            }
            return redirect()->route('aggregations.index')->with(['status' => 'success', 'message' => __('updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function pending_aggregation_in_dash()
    {
        $pending      =Status::where('slug','pending')->firstOrFail()->id;
        $aggregations =Aggregation::where('status_id',$pending)->get();
        // return $aggregations;
        return view('dashboard.aggregations.pending_aggregations',compact('aggregations'));
    }

    public function all_pending_quantities()
    {
        $status=Status::where('slug','pending')->firstOrFail()->id;
        $aggregations = Aggregation::whereHas('aggregationgroups', function ($query) {
            $query->where('status_id', \App\Status::where('slug','pending')->firstOrFail()->id);
        })->get();
        return view('dashboard.aggregations.pending_quantities', compact('aggregations','status'));
    }

    public function change_status_0f_quantity(Request $request, $id)
    {
        // return $request;
        $aggregationgroup=Aggregationgroup::find($id);
        $aggregation =Aggregation::find($aggregationgroup->aggregation_id);
        if( $aggregation->all_quantity  < ($aggregation->current_quantity+$aggregationgroup->user_quantity) )
        return redirect()->back()->with(['status' => 'error', 'message' => __('the quantity is over')]);

        $status=Status::where('slug','active')->firstOrFail()->id;

        $is_exist=false;
        foreach($aggregation->aggregationgroups as $v){
            if($v->id != $aggregationgroup->id){
                if($v->user_id == $aggregationgroup->user_id){
                    $is_exist=true;
                    $v->user_quantity += $aggregationgroup->user_quantity;
                    $v->status_id =$status;
                    $v->save();
                    $aggregationgroup->delete();

                    $aggregation->current_quantity += $aggregationgroup->user_quantity;
                    $aggregation->save();
                    return redirect()->back()->with(['status' => 'success', 'message' => __('status changed successfully')]);
                }
            }
        }

        $status_reqest            =Status::where('slug',$request->status)->firstOrFail()->id;
        $quantity                 =Aggregationgroup::find($id);
        $quantity->user_quantity += $aggregationgroup->user_quantity;
        $quantity->status_id      =$status->id;
        $quantity->save();

        $aggregation->current_quantity += $request->quantity;
        $aggregation->save();
        return redirect()->back()->with(['status' => 'success', 'message' => __('status changed successfully')]);
    }

    public function pending_order_aggregations()
    {
        $aggregations=Aggregation::where('status_id', \App\Status::where('slug','inactive')->firstOrFail()->id)->get();
        return view('dashboard.orders.pending_aggregations', compact('aggregations'));
    }

    public function archived_order_aggregations()
    {
        $aggregations=Aggregation::where('status_id', \App\Status::where('slug','inactive')->firstOrFail()->id)->get();
        return view('dashboard.orders.archived_aggregations', compact('aggregations'));
    }

    public function change_status_aggregation_group(Request $request, $id)
    {
        // return $request;
        $aggregationgroup=Aggregationgroup::find($id);
        $aggregation=Aggregation::find($aggregationgroup->aggregation_id);
        $user=\App\User::find($aggregationgroup->user_id);

        if($aggregationgroup->method_pay=="cash"){
            $user->active_points  += $aggregation->number_of_points_to_join * $aggregationgroup->user_quantity;
            $user->pending_points -= $aggregation->number_of_points_to_join * $aggregationgroup->user_quantity;
            $user->save();
            $aggregationgroup->status_pay = "active";
            $aggregationgroup->save();
            return redirect()->back()->with(['status' => 'success', 'message' => __('status changed successfully')]);
            
        }elseif($aggregationgroup->method_pay=="points"){
            $user->pending_points -= $request->number_of_points;
            $user->save();
            $aggregationgroup->status_pay = "active";
            $aggregationgroup->save();
            return redirect()->back()->with(['status' => 'success', 'message' => __('status changed successfully')]);
        }
    }
    public function change_status_aggregation_group_with_no_deduct(Request $request, $id)
    {
        // return $request;
        $aggregationgroup=Aggregationgroup::find($id);
        $aggregation=Aggregation::find($aggregationgroup->aggregation_id);
        $user=\App\User::find($aggregationgroup->user_id);

        $aggregation->current_quantity -= $request->user_quantity;
        $aggregation->save(); 

        $aggregationgroup->status_pay = "failed_with_no_deduct";
        $aggregationgroup->user_quantity -=$request->user_quantity ;
        $aggregationgroup->save();

        if($aggregationgroup->method_pay=="points"){
            $user->pending_points -= $request->number_of_points;
            $user->active_points  += $request->number_of_points;
            $user->save();
            $aggregationgroup->status_pay = "active";
            $aggregationgroup->save();
            return redirect()->back()->with(['status' => 'success', 'message' => __('status changed successfully')]);
        }

        $user->active_points    +=  $request->user_quantity * $aggregation->number_of_points_to_join;
        $user->pending_points   -=  $request->user_quantity * $aggregation->number_of_points_to_join;
        $user->save();     
    }
}
