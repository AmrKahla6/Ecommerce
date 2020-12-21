<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Aucation;
use App\Status;
use App\Aucationimages;
use App\Category;
use App\Subcategory;
use App\Subsubcategory;
use App\Commentsaucation;
use App\Archivepoint;
use App\User;
use LaravelLocalization;
use Intervention\Image\ImageManagerStatic as Image;

class AucationController extends Controller
{
    public function __construct() 
    {
        $this->middleware('permission:index_aucation')->only('index');
        $this->middleware('permission:create_aucation')->only(['create', 'store']);
        $this->middleware('permission:view_aucation')->only('show');
        $this->middleware('permission:edit_aucation')->only(['edit', 'update']);
        $this->middleware('permission:delete_aucation')->only(['destroy']);

        $this->middleware('permission:pending_aucations_in_dash')->only('pending_aucations_in_dash');
        $this->middleware('permission:all_suspend_prices')->only('all_suspend_prices');
        $this->middleware('permission:change_status_0f_prices')->only('change_status_0f_prices');
        $this->middleware('permission:pending_order_aucation')->only('pending_order_aucation');
        $this->middleware('permission:archived_order_aucation')->only('archived_order_aucation');
    }
    public function index()
    {
        $status_inactive =Status::where('slug','inactive')->firstOrFail()->id;
        $status_active   =Status::where('slug','active')->firstOrFail()->id;
        $aucations       =[];
        foreach(Aucation::where('status_id',$status_active)->get() as $a){
            $now = new \DateTime('NOW',  new \DateTimeZone('Africa/Cairo'));
            $end_at = new \DateTime($a->end_at,  new \DateTimeZone('Africa/Cairo'));
            if($end_at > $now ){
                $aucations[]=$a;
            }else{
                $a->status_id    =$status_inactive;
                $a->save();
                // $prices =[];
                // if(count($a->commentsaucations()->where('status_id',$status_active)->get() )){
                //     foreach($a->commentsaucations()->where('status_id',$status_active)->get()  as $comment){
                //         $prices[]=$comment->price;
                //     }
                //     $max_price          = max($prices);
                //     $comment_max            = Commentsaucation::where('price',$max_price)->where('aucation_id',$a->id)->firstOrFail();
                //     $user               = User::where('id',$comment_max->user_id)->firstOrFail();
                //     $a->buyer_id        = $user->id;
                //     $a->save();
                // }
            }
        }
        return view('dashboard.aucations.index',compact('aucations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.aucations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  
    public function store(Request $request)
    {
        $request->validate([
            'end_at'                 => 'required|date',
            'currency'               => 'required|exists:currencies,id',
            'city'                   => 'required|exists:cities,id',
            'category'               => 'required|exists:categories,id', 
            'subcategory'            => 'required|exists:subcategories,id', 
            'subsubcategory'         => 'required|exists:subsubcategories,id'
        ]);
        $this->validate_trans($request, [
            ['title', 'required|string|max:255'],
            ['description', 'required|string'],
        ]);
        $aucation = new Aucation;
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $aucation->{"title:$localeCode"}              = $request->title["$localeCode"];
            $aucation->{"description:$localeCode"}        = $request->description["$localeCode"];
        }
        if($request->end_at)
        $aucation->end_at              = date('Y-m-d H:i', strtotime($request->end_at));
        $aucation->is_publish_comment  =(boolean)$request->is_publish_comment;
        $aucation->currency_id         =$request->currency;
        $aucation->user_id              =Auth()->user()->id;
        $status=Status::where('slug','active')->firstOrFail();
        $aucation->status_id            =$status->id;
        $aucation->category_id          =$request->category;
        $aucation->subcategory_id       =$request->subcategory;
        $aucation->subsubcategory_id    =$request->subsubcategory;
        $aucation->price_from                 =$request->price_from;
        $aucation->number_of_points_to_join   =$request->number_of_points_to_join;
        $aucation->city_id                    =$request->city;
        $aucation->save();
        if(isset($request->productimage)){
            foreach ($request->productimage as  $image) {
                $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
                $path = storage_path('app/public/' . $filename);
                Image::make($image->getRealPath())->resize(800, 400)->save($path);
                $path2 = storage_path('app/public/th/' . $filename);
                Image::make($image->getRealPath())->resize(800, 380)->save($path2);
                $aucationimage = new Aucationimages;
                $aucationimage->image        =$filename;
                $aucationimage->aucation_id  =$aucation->id;
                $aucationimage->save();
            }
        }
        return redirect()->route('aucations.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aucation = Aucation::find($id);
        return view('dashboard.aucations.view', compact('aucation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aucation = Aucation::find($id);
        $p_category=Category::find($aucation->category_id);
        $p_subcategories=Subcategory::where('category_id',$p_category->id)->get();
        $p_subsubcategories=Subsubcategory::where('subcategory_id',$aucation->subcategory_id)->get();
        return view('dashboard.aucations.edit', compact('aucation','p_category','p_subcategories','p_subsubcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id)
    {
        $request->validate([
            'end_at'                 => 'required|date',
            'currency'               => 'required|exists:currencies,id',
            'city'                   => 'required|exists:cities,id',
            'category'               => 'required|exists:categories,id', 
            'subcategory'            => 'required|exists:subcategories,id', 
            'subsubcategory'         => 'required|exists:subsubcategories,id'
        ]);
        $this->validate_trans($request, [
            ['title', 'required|string|max:255'],
            ['description', 'required|string'],
        ]);
        $aucation =Aucation::find($id);
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $aucation->{"title:$localeCode"}              = $request->title["$localeCode"];
            $aucation->{"description:$localeCode"}        = $request->description["$localeCode"];
        }
        $aucation->end_at              = date('Y-m-d H:i', strtotime($request->end_at));
        $aucation->is_publish_comment  =(boolean)$request->is_publish_comment;
        $status=Status::where('slug', $request->status)->firstOrFail();
        $aucation->status_id           =$status->id;
        $aucation->currency_id         =$request->currency;
        $aucation->category_id         =$request->category;
        $aucation->subcategory_id      =$request->subcategory;
        $aucation->subsubcategory_id   =$request->subsubcategory;
        $aucation->price_from                 =$request->price_from;
        $aucation->number_of_points_to_join   =$request->number_of_points_to_join;
        $aucation->city_id                    =$request->city;
        $aucation->save();
        if(isset($request->removed_image)){
            foreach($request->removed_image as $remove){
                foreach($aucation->aucationimages as $img){
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
                $path2 = storage_path('app/public/th/' . $filename);
                Image::make($image->getRealPath())->resize(800, 400)->save($path2);
                $aucationimage               = new Aucationimages;
                $aucationimage->image        =$filename;
                $aucationimage->aucation_id  =$aucation->id;
                $aucationimage->save();
            }
        }
        return redirect()->route('aucations.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status=Status::where('slug', 'block')->firstOrFail();
        $aucation = Aucation::find($id);
        $aucation->status_id = $status->id;
        $aucation->save();
        return redirect()->route('aucations.index')->with('status', 'aucation Deleted suucssefully');;
    }

    public function view_prices($id)
    {
        $aucation = Aucation::find($id);
        return view('dashboard.aucations.view_prices',compact('aucation'));
    }

    public function block_price($id)
    {
        $status=\App\Status::where('slug','block')->firstOrFail();
        $commentsaucation = Commentsaucation::find($id);
        $commentsaucation->status_id=$status->id;
        $commentsaucation->save();
        $user=\App\User::find($commentsaucation->user_id);
      
        $aucation = Aucation::find($commentsaucation->aucation_id);
        foreach($aucation->commentsaucations as $comment){
            if($comment->id != $commentsaucation->id){
                if($comment->user_id == $user->id){
                    //block comment
                    $comment->status_id=$status->id;
                    $comment->save();
                }
            }
        }

        $user->active_points +=$aucation->number_of_points_to_join;
        $user->pending_points -=$aucation->number_of_points_to_join;
        $user->save();

        $archive_point= new Archivepoint;
        $archive_point->user_id=$user->id;
        $archive_point->{'description:ar'}           = 'تم رجوع '.$aucation->number_of_points_to_join.'  نقطة من مزاد  '. $aucation->{'title:ar'};
        $archive_point->{'description:en'}           = $aucation->number_of_points_to_join .'points returned from ' .$aucation->{'title:en'};
        $archive_point->{'description:ur'}           = $aucation->number_of_points_to_join .'points returned from ' .$aucation->{'title:ur'};
        $archive_point->save();

        return redirect()->back()->with('status', 'comment Deleted suucssefully');;
    }

    public function block_price_deduct($id)
    {
        $status=\App\Status::where('slug','block')->firstOrFail();
        $commentsaucation = Commentsaucation::find($id);
        $commentsaucation->status_id=$status->id;
        $commentsaucation->save();
        $user=\App\User::find($commentsaucation->user_id);
      
        $aucation = Aucation::find($commentsaucation->aucation_id);
        foreach($aucation->commentsaucations as $comment){
            if($comment->id != $commentsaucation->id){
                if($comment->user_id == $user->id){
                    //block comment
                    $comment->status_id=$status->id;
                    $comment->save();
                }
            }
        }

        $user->pending_points -=$aucation->number_of_points_to_join;
        $user->save();

        $archive_point= new Archivepoint;
        $archive_point->user_id=$user->id;
        $archive_point->{'description:ar'}           = 'تم خصم  '.$aucation->number_of_points_to_join.'  نقطة من مزاد  '. $aucation->{'title:ar'};
        $archive_point->{'description:en'}           = $aucation->number_of_points_to_join .'points deducted from ' .$aucation->{'title:en'};
        $archive_point->{'description:ur'}           = $aucation->number_of_points_to_join .'points deducted from ' .$aucation->{'title:ur'};
        $archive_point->save();

        return redirect()->back()->with('status', 'comment Deleted suucssefully');;
    }

    public function pending_aucations_in_dash()
    {
        $pending   =Status::where('slug','pending')->firstOrFail()->id;
        $aucations =Aucation::where('status_id',$pending)->get();
        return view('dashboard.aucations.index',compact('aucations'));
    }

    public function all_suspend_prices()
    {
        $status=Status::where('slug','pending')->firstOrFail()->id;
        $aucations = Aucation::whereHas('commentsaucations', function ($query) {
            $query->where('status_id', \App\Status::where('slug','pending')->firstOrFail()->id);
        })->get();
        return view('dashboard.aucations.pending_prices', compact('aucations','status'));
    }
   
    public function change_status_0f_prices(Request $request, $id)
    {
        $status           =Status::where('slug','pending')->firstOrFail()->id;
        $status_reqest    =Status::where('slug',$request->status)->firstOrFail()->id;
        $price            =Commentsaucation::find($id);
        $price->status_id =$status_reqest;
        $price->save();
        $aucations = Aucation::whereHas('commentsaucations', function ($query) {
            $query->where('status_id', \App\Status::where('slug','pending')->firstOrFail()->id);
        })->get();
        return redirect()->route('all_suspend_prices', compact('aucations','status'))->with(['status' => 'success', 'message' => __('status changed successfully')]);
    }

    public function pending_order_aucation()
    {
        $aucations=Aucation::where('status_of_pay','pending')->get();
        return view('dashboard.orders.pending_aucation', compact('aucations'));
    }
    public function archived_order_aucation()
    {
        $aucations=Aucation::where('status_of_pay',"!=",'pending')->get();
        return view('dashboard.orders.archived_aucation', compact('aucations'));
    }

    public function change_status_aucation(Request $request, $id)
    {
        $aucation=Aucation::find($id);
        if($aucation->method_pay == "cash"){
            $users=[];
            foreach($aucation->commentsaucations as $comment){
                $user=User::find($comment->user_id);
                if( !in_array($user->id, $users) && $comment->status_id != 4){
                    $user=User::find($comment->user_id);
                    $user->active_points  += $aucation->number_of_points_to_join;
                    $user->pending_points -= $aucation->number_of_points_to_join;
                    $user->save();
                    $users[]=$comment->user_id;

                    $archive_point= new Archivepoint;
                    $archive_point->user_id=$user->id;
                    $archive_point->{'description:ar'}           = 'تم رجوع '.$aucation->number_of_points_to_join.'  نقطة من مزاد  '. $aucation->{'title:ar'};
                    $archive_point->{'description:en'}           = $aucation->number_of_points_to_join .'points returned from ' .$aucation->{'title:en'};
                    $archive_point->{'description:ur'}           = $aucation->number_of_points_to_join .'points returned from ' .$aucation->{'title:ur'};
                    $archive_point->save();
                }
            }
    
        }elseif($aucation->method_pay == "points"){
            $status_active=\App\Status::where('slug','active')->firstOrFail();
            $prices =[];
            if(count($aucation->commentsaucations()->where('status_id',$status_active->id)->get() )){
                foreach($aucation->commentsaucations()->where('status_id',$status_active->id)->get() as $comment){
                    $prices[]=$comment->price;
                }
                $max_price              = max($prices);
                $max_price_in_dollar	=$max_price / $aucation->currency->contain_in_dollar ;
                $package				=\App\Package::first();
                $currency				=\App\Currency::find($package->currency_id);
                $point_in_dollar		=$package->price/$currency->contain_in_dollar;
                $number_of_points		=$max_price_in_dollar / $point_in_dollar;

                $user=User::find($aucation->buyer_id);
                $user->pending_points   -=  $number_of_points;

                $archive_point= new Archivepoint;
                $archive_point->user_id=$user->id;
                $archive_point->{'description:ar'}           = 'تم خصم '.$number_of_points.'  نقطة من مزاد  '. $aucation->{'title:ar'};
                $archive_point->{'description:en'}           = $number_of_points .'points deducted from ' .$aucation->{'title:en'};
                $archive_point->{'description:ur'}           = $number_of_points.'points deducted from ' .$aucation->{'title:ur'};
                $archive_point->save();

                $user->save();
                $users=[];
                foreach($aucation->commentsaucations as $comment){
                    $user=User::find($comment->user_id);
                    if($user->id != $aucation->buyer_id && !in_array($user->id, $users) && $comment->status_id != 4){
                        $user->active_points  += $aucation->number_of_points_to_join;
                        $user->pending_points -= $aucation->number_of_points_to_join;
                        $user->save();
                        $users[]=$comment->user_id;

                        $archive_point= new Archivepoint;
                        $archive_point->user_id=$user->id;
                        $archive_point->{'description:ar'}           = 'تم رجوع '.$aucation->number_of_points_to_join.'  نقطة من مزاد  '. $aucation->{'title:ar'};
                        $archive_point->{'description:en'}           = $aucation->number_of_points_to_join .'points returned from ' .$aucation->{'title:en'};
                        $archive_point->{'description:ur'}           = $aucation->number_of_points_to_join .'points returned from ' .$aucation->{'title:ur'};
                        $archive_point->save();
                    }
                }

            }
        }
        $aucation->status_of_pay="active";
        $aucation->is_bought=1;
        $aucation->save();
        return redirect()->back()->with(['status' => 'success', 'message' => __('status changed successfully')]);
    } 

}
