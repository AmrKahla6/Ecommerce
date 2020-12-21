<?php

namespace App\Http\Controllers\site;
use App\Status;
use App\Subsubcategory;
use App\Commentsaucation;
use App\Archivepoint;
use App\User;
use App\Aucation;
use App\Aucationimages;
use App\Category;
use App\Subcategory;
use LaravelLocalization;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AucationController extends Controller
{
    public function search_aucations(Request $request) 
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
            $aucations     = Aucation::whereTranslationLike('description', '%'. $request->search .'%')->where('status_id',$status)->orWhereTranslationLike('title', '%'. $request->search .'%')->where('status_id',$status)->paginate(10);
        }elseif($request->search == null){
            $aucations     = Aucation::where('status_id',$status)->where('city_id',$request->city)->paginate(10);
        }else{
            $aucations     = Aucation::whereTranslationLike('description', '%'. $request->search .'%')->where('status_id',$status)->where('city_id',$request->city)->orWhereTranslationLike('title', '%'. $request->search .'%')->where('status_id',$status)->where('city_id',$request->city)->paginate(10);
        }
        return view('site.aucation',compact('aucations'));
    }

    public function search_archived_aucations(Request $request)
    {
        $request->validate([
            'search'             => 'nullable|string|max:255',
            'city'               => 'nullable|exists:cities,id',
        ]);
        $finished=[];
        if($request->city == null && $request->search == null){
            session()->flash('error', 'choose city or search by word');
            return redirect()->back();
        }
        $finished   =[];
        $status         =Status::where('slug','inactive')->firstOrFail()->id;
        if($request->city == null){
            $aucations     = Aucation::whereTranslationLike('description', '%'. $request->search .'%')->where('status_id',$status)->orWhereTranslationLike('title', '%'. $request->search .'%')->where('status_id',$status)->get();
        }elseif($request->search == null){
            $aucations     = Aucation::where('status_id',$status)->where('city_id',$request->city)->get();
        }else{
            $aucations     = Aucation::whereTranslationLike('description', '%'. $request->search .'%')->where('status_id',$status)->where('city_id',$request->city)->orWhereTranslationLike('title', '%'. $request->search .'%')->where('status_id',$status)->where('city_id',$request->city)->get();
        }
        return view('site.aucations.archived',compact('aucations','finished'));
    }
    public function aucations($id){
        $subsubcategory =Subsubcategory::find($id);
        $status_active  =Status::where('slug','active')->firstOrFail()->id;
        $aucations      =[];
        foreach($subsubcategory->aucations()->where('status_id',$status_active)->get() as $a){
            $now = new \DateTime('NOW',  new \DateTimeZone('Africa/Cairo'));
            $end_at = new \DateTime($a->end_at,  new \DateTimeZone('Africa/Cairo'));

            if($end_at > $now ){
                $aucations[]=$a;
            }else{
                $status_inactive          =Status::where('slug','inactive')->firstOrFail();
                $a->status_id             =$status_inactive->id;
                $a->save();
                // $prices =[];
                // if(count($a->commentsaucations()->where('status_id',$status_active->id)->get()  )){
                //     foreach($a->commentsaucations()->where('status_id',$status_active->id)->get()   as $comment){
                //         $prices[]=$comment->price;
                //     }
                //     $max_price          = max($prices);
                //     $comment            = Commentsaucation::where('price',$max_price)->firstOrFail();
                //     $user               = User::where('id',$comment->user_id)->firstOrFail();
                //     $a->buyer_id        = $user->id;
                //     $a->save();
                // }
            }
        }
        return view('site.aucation',compact('aucations'));
    }

    public function aucation($id){
        // return $id;
        $status_active  =Status::where('slug','active')->firstOrFail()->id;
        $in_active      =Status::where('slug','inactive')->firstOrFail()->id;
        $aucation       =Aucation::where('id',$id)->where('status_id',$status_active)->orWhere('status_id',$in_active)->where('id',$id)->firstOrFail();
        $now = new \DateTime('NOW',  new \DateTimeZone('Africa/Cairo'));
        $end_at = new \DateTime($aucation->end_at,  new \DateTimeZone('Africa/Cairo'));

        if($end_at < $now ){
            $status_inactive          =Status::where('slug','inactive')->firstOrFail();
            $aucation->status_id      =$status_inactive->id;
            $aucation->save();
            $prices =[];

            $status_block          =Status::where('slug','block')->firstOrFail();
            if(count($aucation->commentsaucations()->where('status_id',$status_active)->get() )){
                foreach($aucation->commentsaucations()->where('status_id',$status_active)->get() as $comment){
                    $user               = User::where('id',$comment->user_id)->firstOrFail();
                    //check if the user is blocked ===>  your price is deleted 
                    if($user->status_id == $status_block->id && $aucation->method_pay != "active"){
                        $comment->status_id = $status_block->id;
                        $comment->save();
                    }else{
                        $prices[]=$comment->price;
                    }
                }
                $max_price          = max($prices);
                $comment_max        = Commentsaucation::where('price',$max_price)->where('aucation_id',$aucation->id)->firstOrFail();
                $user_max           = User::where('id',$comment_max->user_id)->firstOrFail();
            
                $aucation->buyer_id        = $user_max->id;
                // return $user_max;
                $aucation->save();
            }
        }
        return view('site.aucation_details',compact('aucation'));
    }

    public function archived_aucations(){
        $status_active     =Status::where('slug','active')->firstOrFail()->id;
        $status_inactive   =Status::where('slug','inactive')->firstOrFail()->id;

        $finished       = Aucation::where( 'status_id',$status_inactive )->get();
        $aucations      =[];
        foreach(Aucation::where('status_id',$status_active)->get() as $a){
            $now = new \DateTime('NOW',  new \DateTimeZone('Africa/Cairo'));
            $end_at = new \DateTime($a->end_at,  new \DateTimeZone('Africa/Cairo'));

            if($end_at < $now ){
                $aucations[]=$a;
                $a->status_id             =$status_inactive;
                $a->save();
                // $prices =[];
                // $status_block          =Status::where('slug','block')->firstOrFail();
                // if(count($a->commentsaucations()->where('status_id',$status_active)->get() )){
                //     foreach($a->commentsaucations()->where('status_id',$status_active)->get() as $comment){
                //         $user               = User::where('id',$comment->user_id)->firstOrFail();
                //         if($user->status_id == $status_block->id && $aucation->method_pay != "active"){
                //             $comment->status_id = $status_block->id;
                //             $comment->save();
                //         }else{
                //             $prices[]=$comment->price;
                //         }
                //     }
                //     $max_price          = max($prices);
                //     $comment            = Commentsaucation::where('price',$max_price)->firstOrFail();
                //     $user               = User::where('id',$comment->user_id)->firstOrFail();
                //     $aucation->buyer_id        = $user->id;
                //     $aucation->save();
                // }
            }
        }
        return view('site.aucations.archived',compact('aucations','finished'));
    }

    public function create_aucation()
    {
        return view('site.company.create_aucation');
    }

    public function save_aucation(Request $request)
    {
        // return $request;
        if( $request->title["en"] == null && $request->title["ar"] == null  && $request->title["ur"] == null  ){
            return redirect()->back()->with(['status' => 'error', 'message' => __('you must entered at least one value of title ')]);
        }
        if( $request->description["en"] == null && $request->description["ar"] == null  && $request->description["ur"] == null  ){
            return redirect()->back()->with(['status' => 'error', 'message' => __('you must entered at least one value of description ')]);
        }
        $request->validate([
            'end_at'                 => 'required|date',
            'price_from'             => 'required|numeric',
            'currency'               => 'required|exists:currencies,id',
            'productimage'           => 'required', 
            'city'                   => 'required|exists:cities,id', 
            'category'               => 'required|exists:categories,id', 
            'subcategory'            => 'required|exists:subcategories,id', 
            'subsubcategory'         => 'required|exists:subsubcategories,id', 
        ]);
        $aucation                            = new Aucation;
        $aucation->{"title:ar"}              = $request->title["ar"];
        $aucation->{"title:ur"}              = $request->title["ur"];
        $aucation->{"title:en"}              = $request->title["en"];

        $aucation->{"description:ar"}        = $request->description["ar"];
        $aucation->{"description:ur"}        = $request->description["ur"];
        $aucation->{"description:en"}        = $request->description["en"];
        $aucation->end_at                    = date('Y-m-d H:i', strtotime($request->end_at));
        $aucation->currency_id               =$request->currency;
        $aucation->is_publish_comment        =1;
        $aucation->user_id                   =Auth()->user()->id;
        $status=Status::where('slug','pending')->firstOrFail();
        $aucation->status_id                =$status->id;
        $aucation->category_id              =$request->category;
        $aucation->subcategory_id           =$request->subcategory;
        $aucation->subsubcategory_id        =$request->subsubcategory;
        $aucation->price_from               =$request->price_from;
        $aucation->city_id                  =$request->city;
        $aucation->save();
        if(isset($request->productimage)){
            foreach ($request->productimage as  $image) {
                $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
                $path = storage_path('app/public/' . $filename);
                Image::make($image->getRealPath())->resize(800, 400)->save($path);
                $aucationimage = new Aucationimages;
                $aucationimage->image        =$filename;
                $aucationimage->aucation_id  =$aucation->id;
                $aucationimage->save();
            }
        }
        session()->flash('success', 'Suspended until approved by the Admin');
        return redirect()->route('finished_aucation');
    }

    public function add_comment_to_aucation(Request $request , $id)
    {
        //return $request;
        $request->validate([
            'price'                 => 'required|numeric',
        ]);
        $status_active  =Status::where('slug','active')->firstOrFail()->id;
        $aucation       =Aucation::where('id',$id)->where('status_id',$status_active)->firstOrFail();
        $is_exist=false;
        foreach($aucation->commentsaucations as $comment){
            if($comment->user_id == Auth()->user()->id){
                $is_exist=true;
            }
            if($request->maxprice >= $request->price){
                session()->flash('error', 'The price must be greater than' .' '.$request->maxprice);
                return redirect()->back();
            }
        }
        $now = new \DateTime('NOW',  new \DateTimeZone('Africa/Cairo'));
        $end_at = new \DateTime($aucation->end_at,  new \DateTimeZone('Africa/Cairo'));
        if($end_at < $now ){
            session()->flash('error', 'Sorry the auction time is over'  );
            return redirect()->back();
        }
        if($request->price < $aucation->price_from){
            session()->flash('error', 'The price must be at least '.$aucation->price_from  .' '. $aucation->currency->short_code  );
            return redirect()->back();
        }
        $comment_aucation                 =new Commentsaucation;
        $comment_aucation->price          =$request->price;
        $comment_aucation->aucation_id    =$aucation->id;
        $comment_aucation->user_id        =Auth()->user()->id;
        if($aucation->is_publish_comment==1){
            $status=Status::where('slug','active')->firstOrFail();
            $comment_aucation->status_id=$status->id;
        }else{
            $status=Status::where('slug','pending')->firstOrFail();
            $comment_aucation->status_id=$status->id;
        }
        $comment_aucation->number=Auth()->user()->id;
      
        if($is_exist == false){
            if($aucation->number_of_points_to_join > Auth()->user()->active_points || Auth()->user()->active_points == null){
                session()->flash('error', 'you must buy points to join this aucation at least '.$aucation->number_of_points_to_join . ' '.'point'  );
                return redirect()->back();
            }
            $user=User::find(Auth()->user()->id);
            $user->active_points  -= $aucation->number_of_points_to_join;
            $user->pending_points += $aucation->number_of_points_to_join;
            $user->save();

            $archive_point= new Archivepoint;
            $archive_point->user_id=$user->id;
            $archive_point->{'description:ar'}           = 'تم تعليق '.$aucation->number_of_points_to_join.'  نقطة لاشتراكك في مزاد  '. $aucation->{'title:ar'};
            $archive_point->{'description:en'}           = 'we pending ' .$aucation->number_of_points_to_join. ' point because you subscribe '.$aucation->{'title:ar'};
            $archive_point->{'description:ur'}           = 'we pending ' .$aucation->number_of_points_to_join. ' point because you subscribe '.$aucation->{'title:ar'};
            $archive_point->save();
        }
      
        $comment_aucation->save();
        if($status->slug == 'active'){
            session()->flash('success', 'price added succefully');
            return redirect()->back();
        }else{
            session()->flash('success', 'price pending even approved');
            return redirect()->back();
        }
    }

    public function finished()
    {
        $status_active    =Status::where('slug','active')->firstOrFail()->id;
        $status_inactive  =Status::where('slug','inactive')->firstOrFail()->id;
        $pending          =Status::where('slug','pending')->firstOrFail()->id;
        $block            =Status::where('slug','block')->firstOrFail()->id;

        $finished         =Aucation::where('status_id',$status_inactive)->where('user_id',Auth()->user()->id)->get();
        $block_aucation   =Aucation::where('status_id',$block)->where('user_id',Auth()->user()->id)->get();
        // return $block_aucation;
        $aucations_finished      =[];
        foreach(Aucation::where('status_id',$status_active)->where('user_id',Auth()->user()->id)->get() as $a){
            $now = new \DateTime('NOW',  new \DateTimeZone('Africa/Cairo'));
            $end_at = new \DateTime($a->end_at,  new \DateTimeZone('Africa/Cairo'));
            if($end_at < $now ){
                $aucations_finished[]     =$a;
                $a->status_id             =$status_inactive->id;
                $a->save();

                $prices =[];
                $status_block          =Status::where('slug','block')->firstOrFail();
                if(count($a->commentsaucations()->where('status_id',$status_active->id)->get() )){
                    foreach($a->commentsaucations()->where('status_id',$status_active->id)->get() as $comment){
                        $user               = User::where('id',$comment->user_id)->firstOrFail();
                        if($user->status_id == $status_block->id && $aucation->method_pay != "active"){
                            $comment->status_id = $status_block->id;
                            $comment->save();
                        }else{
                            $prices[]=$comment->price;
                        }
                    }
                    $max_price          = max($prices);
                    $comment            = Commentsaucation::where('price',$max_price)->where('aucation_id',$a->id)->firstOrFail();
                    $user               = User::where('id',$comment->user_id)->firstOrFail();
                    $aucation->buyer_id        = $user->id;
                    $aucation->save();
                }
            }
        }
        $aucations_active   =Aucation::where('status_id',$status_active)->where('user_id',Auth()->user()->id)->get();
        $aucations_pending  =Aucation::where('status_id',$pending)->where('user_id',Auth()->user()->id)->get();
        return view('site.aucations.finished',compact('aucations_finished','finished','aucations_active','aucations_pending','block_aucation'));
    }

    public function subcategories(Request $request) {
        return Category::findOrFail($request->id)->subcategories()->get();
    }

    public function subsubcategories(Request $request) {
        return Subcategory::findOrFail($request->id)->subsubcategories()->get();
    }

    public function subscription_aucation_company()
    {
        $pending    =Status::where('slug','pending')->firstOrFail()->id;
        $aucations  =Aucation::where('status_id','!=',$pending)->orderBy('created_at', 'desc')->get();
        if(Auth()->user()->is_company==1){
            return view('site.company.subscription_aucation',compact('aucations'));
        }else{
            return view('site.user.subscription_aucation',compact('aucations'));
        }
    }

    public function pay_aucation(Request $request )
    {
        return $request;
        $status_active  =Status::where('slug','active')->firstOrFail()->id;
        $in_active      =Status::where('slug','inactive')->firstOrFail()->id;
        $aucation       =Aucation::where('id',$request->id)->where('status_id',$status_active)->orWhere('status_id',$in_active)->where('id',$request->id)->firstOrFail();

        if($request->method_pay == "cash"){
            $aucation->method_pay       ="cash";
            $aucation->status_of_pay    ="pending";
            $aucation->buyer_id         =$request->user_max_price;
            $aucation->save();
            session()->flash('success', 'pending even connecting with admin');
            return redirect()->back();
        }elseif($request->method_pay == "points"){
            $user=User::find($request->user_max_price);
            if($user->active_points < ($request->number_of_points - $aucation->number_of_points_to_join)){
                session()->flash('error', 'you must have at least '.($request->number_of_points - $aucation->number_of_points_to_join).' point');
                return redirect()->back();
            }else{
                $aucation->method_pay       ="points";
                $aucation->status_of_pay    ="pending";
                $aucation->buyer_id         =$request->user_max_price;

                $user->active_points    -=  ($request->number_of_points - $aucation->number_of_points_to_join);
                $user->pending_points   +=  ($request->number_of_points - $aucation->number_of_points_to_join);
                $user->save();
                $aucation->save();

                $archive_point= new Archivepoint;
                $archive_point->user_id=$user->id;
                $archive_point->{'description:ar'}           = 'تم خصم '.($request->number_of_points - $aucation->number_of_points_to_join).'  نقطة من مزاد  '. $aucation->{"title:ar"} . ' وذلك لاتمامك عمليه الشراء بالنقاط ';
                $archive_point->{'description:en'}           = ($request->number_of_points - $aucation->number_of_points_to_join) .'points deducted from ' .$aucation->{'title:en'}. 'because you buy with points';
                $archive_point->{'description:ur'}           = ($request->number_of_points - $aucation->number_of_points_to_join) .'points deducted from ' .$aucation->{'title:ur'}. 'because you buy with points';
                $archive_point->save();

                session()->flash('success', 'pending even connecting with admin');
                return redirect()->back();
            }
        }
    }
}
