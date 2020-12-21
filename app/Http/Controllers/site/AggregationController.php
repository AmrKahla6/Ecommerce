<?php

namespace App\Http\Controllers\site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Aggregation;
use App\Aggregationgroup;
use App\Status;
use App\Aggregationimage;
use App\Category;
use App\Subcategory;
use App\Subsubcategory;
use App\User;
use LaravelLocalization;
use Intervention\Image\ImageManagerStatic as Image;

class AggregationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_aggregation()
    {
        return view('site.company.create_aggregation');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save_aggregation(Request $request)
    {  
        if( $request->title["en"] == null && $request->title["ar"] == null  && $request->title["ur"] == null  ){
            session()->flash('error', 'you must entered at least one value of title');
            return redirect()->back();
        }
        if( $request->description["en"] == null && $request->description["ar"] == null  && $request->description["ur"] == null  ){
            session()->flash('error', 'you must entered at least one value of description');
            return redirect()->back();
        }
        
        $request->validate([
            'end_at'                    => 'required|date',
            'all_quantity'              => 'required|numeric',
            'price'                     => 'required',
            'productimage'              => 'required',
            'category'                  => 'required|exists:categories,id',
            'subcategory'               => 'required|exists:subcategories,id',
            'subsubcategory'            => 'required|exists:subsubcategories,id',
            'currency'                  => 'required|exists:currencies,id',
            'productimage'              => 'required', 
            'city'                      => 'required|exists:cities,id', 
        ]);
        $aggregation = new Aggregation;
        $aggregation->{"title:ar"}              = $request->title["ar"];
        $aggregation->{"title:ur"}              = $request->title["ur"];
        $aggregation->{"title:en"}              = $request->title["en"];
        $aggregation->{"description:ar"}        = $request->description["ar"];
        $aggregation->{"description:ur"}        = $request->description["ur"];
        $aggregation->{"description:en"}        = $request->description["en"];

        $aggregation->end_at              = date('Y-m-d H:i', strtotime($request->end_at));
        $aggregation->is_publish_comment  =1;
        $aggregation->currency_id         =$request->currency;
        $aggregation->user_id             =Auth()->user()->id;
        $status=Status::where('slug','pending')->firstOrFail();
        $aggregation->status_id            =$status->id;
        $aggregation->category_id          =$request->category;
        $aggregation->subcategory_id       =$request->subcategory;
        $aggregation->subsubcategory_id    =$request->subsubcategory;
        $aggregation->price                =$request->price;
        $aggregation->all_quantity         =$request->all_quantity;
        $aggregation->city_id              =$request->city;

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
        session()->flash('success', 'created successfully and pending even approved by admin');
        return redirect()->route('aggregations_of_company');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search_aggregations(Request $request)
    {
        $request->validate([
            'search'             => 'nullable|string|max:255',
            'city'               => 'nullable|exists:cities,id',
        ]);
        if($request->city == null && $request->search == null){
            session()->flash('error', 'choose city or search by word');
            return redirect()->back();
        }
        $status         =Status::where('slug','active')->firstOrFail()->id;
        if($request->city == null){
            $aggregations     = Aggregation::whereTranslationLike('description', '%'. $request->search .'%')->where('status_id',$status)->orWhereTranslationLike('title', '%'. $request->search .'%')->where('status_id',$status)->paginate(10);
        }elseif($request->search == null){
            $aggregations     = Aggregation::where('status_id',$status)->where('city_id',$request->city)->paginate(10);
        }else{
            $aggregations     = Aggregation::whereTranslationLike('description', '%'. $request->search .'%')->where('status_id',$status)->where('city_id',$request->city)->orWhereTranslationLike('title', '%'. $request->search .'%')->where('status_id',$status)->where('city_id',$request->city)->paginate(10);
        }
        return view('site.aggregations',compact('aggregations'));
    }


    public function aggregations($id)
    {
        $subsubcategory =Subsubcategory::find($id);
        $status         =Status::where('slug','active')->firstOrFail()->id;
        $aggregations   =$subsubcategory->aggregations()->where('status_id',$status)->latest()->paginate(10);
        return view('site.aggregations',compact('aggregations'));
    }

    public function aggregation($id)
    {
        $pending    =\App\Status::where('slug','pending')->firstOrFail()->id;
        $status_active=\App\Status::where('slug','active')->firstOrFail();
        $block      =\App\Status::where('slug','block')->firstOrFail()->id;
        $aggregation =Aggregation::where('id',$id)->where('status_id','!=',$pending)->where('status_id','!=',$block)->firstOrFail();

        if(count($aggregation->aggregationgroups()->where('status_id',$status_active->id)->get())){
            foreach($aggregation->aggregationgroups()->where('status_id',$status_active->id)->get() as $comment ){
                $user=User::find($comment->user_id);
                if($user->status_id == $block && $comment->status_pay == null){
                    $aggregation->current_quantity += $comment->user_quantity;
                    $aggregation->save();

                    $user->active_points  += $aggregation->number_of_points_to_join * $user_quantity;
                    $user->pending_points -= $aggregation->number_of_points_to_join * $user_quantity;
                    $user->save();

                    $comment->status_id == $block;
                    $comment->save();                    
                }
            }
        }
        return view('site.aggregation',compact('aggregation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add_quantity_to_aggregation(Request $request , $id)
        {
            $request->validate([
                'quantity'                 => 'required|numeric',
            ]);
            $pending    =\App\Status::where('slug','pending')->firstOrFail()->id;
            $block      =\App\Status::where('slug','block')->firstOrFail()->id;
            $aggregation =Aggregation::where('id',$id)->where('status_id','!=',$pending)->where('status_id','!=',$block)->firstOrFail();

            $now    = new \DateTime('NOW');
            $end_at = new \DateTime($aggregation->end_at);
            if($end_at < $now ){
                session()->flash('error', 'Sorry the aggregation time is over'  );
                return redirect()->back();
            }

            if(($aggregation->all_quantity - $aggregation->current_quantity)  < $request->quantity){
                session()->flash('error', 'this quantity is over');
                return redirect()->back();
            }

            if(($aggregation->number_of_points_to_join * $request->quantity) > Auth()->user()->active_points || Auth()->user()->active_points == null){
                session()->flash('error', 'you must buy points to join this aucation at least '.$aggregation->number_of_points_to_join . ' '.'point'  );
                return redirect()->back();
            }
            $user=User::find(Auth()->user()->id);
            $user->active_points  -= $aggregation->number_of_points_to_join * $request->quantity;
            $user->pending_points += $aggregation->number_of_points_to_join * $request->quantity;
            $user->save();

            $is_exist=false;
            foreach($aggregation->aggregationgroups as $aggregationgroup){
                if($aggregationgroup->user_id == Auth()->user()->id){
                    $is_exist=true;
                    if($aggregation->is_publish_comment==1){
                        $aggregationgroup->user_quantity += $request->quantity;
                        $status=Status::where('slug','active')->firstOrFail();
                        $aggregationgroup->status_id=$status->id;
                        $aggregationgroup->save();

                        $aggregation->current_quantity += $request->quantity;
                        $aggregation->save();
                    }
                }
            }
    
            $aggregationgroup                   =new Aggregationgroup;
            $aggregationgroup->user_quantity    =$request->quantity;
            $aggregationgroup->aggregation_id   =$aggregation->id;
            $aggregationgroup->user_id          =Auth()->user()->id;
            if($aggregation->is_publish_comment==0 && $is_exist == false || $aggregation->is_publish_comment==0 && $is_exist ==true ){
                $status=Status::where('slug','pending')->firstOrFail();
                $aggregationgroup->status_id=$status->id;
                $aggregationgroup->save();
            }elseif($aggregation->is_publish_comment==1 && $is_exist == false){
                $status=Status::where('slug','active')->firstOrFail();
                $aggregationgroup->status_id=$status->id;
                $aggregation->current_quantity += $request->quantity;
                $aggregation->save();
                $aggregationgroup->save();
            }
           
            if($status->slug == 'active'){
                session()->flash('success', 'quantity added succefully');
                return redirect()->back();
            }else{
                session()->flash('success', 'quantity pending even approved');
                return redirect()->back();
            }
        }

        public function aggregations_of_company()
        {
            $aggregations    = Aggregation::where('user_id',Auth()->user()->id)->get();
            return view('site.company.aggregations',compact('aggregations'));
        }

        public function pay_aggregation(Request $request , $id)
        {
            $agg_group   = Aggregationgroup::find($id);
            $pending     =\App\Status::where('slug','pending')->firstOrFail()->id;
            $block       =\App\Status::where('slug','block')->firstOrFail()->id;
           
            $aggregation =Aggregation::where('id',$agg_group->aggregation_id)->where('status_id','!=',$pending)->where('status_id','!=',$block)->firstOrFail();
            if($request->method_pay == "cash"){
                $agg_group->method_pay       ="cash";
                $agg_group->status_pay       ="pending";
                $agg_group->save();
                session()->flash('success', 'pending even connecting with admin');
                return redirect()->back();
            }elseif($request->method_pay == "points"){
                $user=User::find($agg_group->user_id);
                if($user->active_points < ($request->number_of_points - ($aggregation->number_of_points_to_join * $agg_group->user_quantity))){
                    session()->flash('error', 'you must have at least '.($request->number_of_points - $aggregation->number_of_points_to_join).' point');
                    return redirect()->back();
                }else{
                    $agg_group->method_pay    ="points";
                    $agg_group->status_pay    ="pending";
    
                    $user                    =User::find($agg_group->user_id);
                    $user->active_points    -=  ($request->number_of_points - ($aggregation->number_of_points_to_join * $agg_group->user_quantity));
                    $user->pending_points   +=  ($request->number_of_points - ($aggregation->number_of_points_to_join * $agg_group->user_quantity));
                    $user->save();
                    $agg_group->save();
                    session()->flash('success', 'pending even connecting with admin');
                    return redirect()->back();
                }
            }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  
    public function archived_Aggregations(){
        $status_active  =Status::where('slug','active')->firstOrFail()->id;
        $in_active      =Status::where('slug','inactive')->firstOrFail()->id;

        $finished       = Aggregation::where( 'status_id',$in_active )->get();
        $aggregations   =[];
        foreach(Aggregation::where('status_id',$status_active)->get() as $aggregation){
            $now = new \DateTime('NOW');
            $end_at = new \DateTime($aggregation->end_at);
            if($end_at < $now || $aggregation->all_quantity == $aggregation->current_quantity){
                $aggregations[]=$aggregation;
                $aggregation->status_id             =$status_inactive;
                $aggregation->save();
                $status="finished";
            }
        }
        return view('site.archived_aggregations',compact('aggregations','finished'));
    }

    public function search_archived_aggregations(Request $request)
    {
        $request->validate([
            'search'             => 'nullable|string|max:255',
            'city'               => 'nullable|exists:cities,id',
        ]);
        if($request->city == null && $request->search == null){
            session()->flash('error', 'choose city or search by word');
            return redirect()->back();
        }
        $finished   =[];
        $status         =Status::where('slug','inactive')->firstOrFail()->id;
        if($request->city == null){
            $aggregations     = Aggregation::whereTranslationLike('description', '%'. $request->search .'%')->where('status_id',$status)->orWhereTranslationLike('title', '%'. $request->search .'%')->where('status_id',$status)->paginate(10);
        }elseif($request->search == null){
            $aggregations     = Aggregation::where('status_id',$status)->where('city_id',$request->city)->paginate(10);
        }else{
            $aggregations     = Aggregation::whereTranslationLike('description', '%'. $request->search .'%')->where('status_id',$status)->where('city_id',$request->city)->orWhereTranslationLike('title', '%'. $request->search .'%')->where('status_id',$status)->where('city_id',$request->city)->paginate(10);
        }
        return view('site.archived_aggregations',compact('aggregations','finished'));
    }

    public function subscription_aggregation_company()
    {
        $pending       =Status::where('slug','pending')->firstOrFail()->id;
        $aggregations  =Aggregation::where('status_id','!=',$pending)->orderBy('created_at', 'desc')->get();
        if(Auth()->user()->is_company==1){
            return view('site.company.subscription_aggregations',compact('aggregations'));
        }else{
            return view('site.user.subscription_aggregations',compact('aggregations'));
        }
      
    }
}
