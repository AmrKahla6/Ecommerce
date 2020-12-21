<?php

namespace App\Http\Controllers\site;
use App\User;
use App\Status;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Productsize;
use App\Transferpoints;
use App\Category;
use App\Companyimag;
use App\Subcategory;
use App\Subsubcategory;
use App\Productcolors;
use App\Requestpoint;
use App\Productimages;
use Illuminate\Support\Facades\Storage;
use LaravelLocalization;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Productoffers;
use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
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
    public function create_company()
    {
        return view('site.create_company');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_company(Request $request)
    {
        $request->validate([
            'name_of_company'      => 'required|string|max:255',    
            'name_of_owner'        => 'required|string|max:255',      
            'address'              => 'nullable|string|max:255',      
            'desc'                 => 'required|string|max:255',      
            'url'                  => 'nullable|string|url|max:255',  
            'phone'                => 'required|string',     
            'commercial_number'    => 'nullable|integer|min:0',                
           'image'                 => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',         
           'email'                 => 'required|string|email|unique:users,email|unique:companies,email|max:255',   
           'pdf'                   => 'nullable',
           'password'              => ['required', 'string', 'min:6', 'confirmed'],  
           'city'                 => 'required|exists:cities,id',            
        ]);
        $company                     =new User;
        $company->city_id            =$request->city;
        $pending                     = Status::where('slug', 'pending')->firstOrFail();
        $currency=\App\Currency::where('is_default',1)->firstOrFail();
    
        $company->name_of_company    =$request->name_of_company;
        $company->name_of_owner      =$request->name_of_owner;
        $company->email              =$request->email;
        $company->currency_id        =$currency->id;
        $company->phone              =$request->phone;
        $company->url                =$request->url;
        $company->commercial_number  =$request->commercial_number;
        $company->desc               =$request->desc;
        $company->is_company         =1;
        $company->address            =$request->address;
        $company->password           =bcrypt($request->password);
        $company->name_of_company    =$request->name_of_company;
        $company->status_id          =$pending ->id;
        if($request->hasFile('pdf')){
            $pdf = $request->pdf;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$pdf->getClientOriginalExtension();
            $request->file('pdf')->storeAs(
                'public', $filename
            ); 
            $company->pdf        =$filename;
        }
        
        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(100, 100)->save($path);
            $company->image        =$filename;
        }
        $company->save();
        if(isset($request->images)){
            foreach ($request->images as  $image) {
                $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
                $path = storage_path('app/public/' . $filename);
                Image::make($image->getRealPath())->resize(100, 100)->save($path);
                $companyimag = new Companyimag;
                $companyimag->image        =$filename;
                $companyimag->user_id        =$company->id;
                $companyimag->save();
            }
        }
        // Auth::loginUsingId($company->id); Session::flash('success', 'Stored successfully'); ('success', ['your message,here'])
        session()->flash('success', 'Suspended until approved by the Admin');
        return redirect()->route('indexeco');
    }

    public function change_details_company(Request $request )
    {
        // return $request;
        $company                     =User::find(Auth()->user()->id);
        $request->validate([
            'name_of_company'      => 'required|string|max:255',    
            'name_of_owner'        => 'required|string|max:255',      
            'address'              => 'nullable|string|max:255',      
            'desc'                 => 'required|string|max:255',      
            'url'                  => 'nullable|string|url|max:255',  
            'phone'                => 'required|string',     
            'commercial_number'    => 'required|integer|min:0',                
           'email'                 => 'unique:users,email,'.$company->id,
           'pdf'                   => 'nullable',
           'city'                  => 'required|exists:cities,id',
        ]);
 
        $pending                     = Status::where('slug', 'pending')->firstOrFail();
        $company->name_of_company    =$request->name_of_company;
        $company->name_of_owner      =$request->name_of_owner;
        $company->email              =$request->email;
        $company->city_id            =$request->city;
        $company->phone              =$request->phone;
        $company->url                =$request->url;
        $company->commercial_number  =$request->commercial_number;
        $company->desc               =$request->desc;
        $company->is_company         =1;
        $company->address            =$request->address;
        $company->password           =bcrypt($request->password);
        $company->name_of_company    =$request->name_of_company;
        $company->status_id          =$pending ->id;
        if($request->hasFile('pdf')){
            $pdf = $request->pdf;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$pdf->getClientOriginalExtension();
            $request->file('pdf')->storeAs(
                'public', $filename
            ); 
            $company->pdf        =$filename;
        }
        
        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(100, 100)->save($path);
            $company->image        =$filename;
        }
        $company->save();
        if(isset($request->images)){
            foreach ($request->images as  $image) {
                $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
                $path = storage_path('app/public/' . $filename);
                Image::make($image->getRealPath())->resize(100, 100)->save($path);
                $companyimag = new Companyimag;
                $companyimag->image        =$filename;
                $companyimag->user_id        =$company->id;
                $companyimag->save();
            }
        }
        // Auth::loginUsingId($company->id); Session::flash('success', 'Stored successfully'); ('success', ['your message,here'])
     
        if(isset($request->removed_image)){
            foreach($request->removed_image as $remove){
                foreach($company->companyimages as $img){
                    if($remove == $img->image){
                        Storage::disk('public')->delete($remove);
                        $img->delete();
                    }
                }
            }
        }
        session()->flash('success', 'Suspended until approved by the Admin');
        return redirect()->route('indexeco');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function archive_points() 
    {
        $user =\App\User::find(Auth()->user()->id);
        if($user->is_company==1){
            return view('site.company.archive_points',compact('user'));
        }else{
            return view('site.user.archive_points',compact('user'));
        }
    }
    public function archive_transfer_points() 
    {
        $user =\App\User::find(Auth()->user()->id); 
        $transferpoint_from = Transferpoints::where('from',Auth()->user()->id)->get();
        $transferpoint_to= Transferpoints::where('to',Auth()->user()->id)->get();
        if($user->is_company==1){
            return view('site.company.archive_transfer_points',compact('user','transferpoint_from','transferpoint_to'));
        }else{
            return view('site.user.archive_transfer_points',compact('user','transferpoint_from','transferpoint_to'));
        }
    }

    public function pending_orders_company()
    {
        $user =\App\User::find(Auth()->user()->id);
        $products=$user->products;
        return view('site.company.pending_orders',compact('products','user'));
    }
    public function archived_orders_company() 
    {
        $user =\App\User::find(Auth()->user()->id);
        $products=$user->products;
        return view('site.company.archived_orders',compact('products','user'));
    }

    public function pending_orders_out()
    {
        $user =\App\User::find(Auth()->user()->id);
        $orders=$user->orders()->where('status','pending')->get();
        return view('site.company.pending_orders_out',compact('orders','user'));
    }
    public function archived_orders_out() 
    {
        $user =\App\User::find(Auth()->user()->id);
        $orders=$user->orders()->where('status', '!=','pending')->get();
        return view('site.company.archived_orders_out',compact('orders','user'));
    }

    public function pending_orders_aucation_out()
    {
        $user =\App\User::find(Auth()->user()->id);
        $aucations=$user->bought_aucations()->where('status_of_pay','pending')->get();
        if($user->is_company==1){
            return view('site.company.pending_orders_aucation_out',compact('aucations'));
        }else{
            return view('site.user.pending_orders_aucation_out',compact('aucations'));
        }
      
    }

    public function archived_orders_aucation_out()
    {
        $user =\App\User::find(Auth()->user()->id);
        $aucations=$user->bought_aucations()->where('status_of_pay','!=','pending')->get();
        if($user->is_company==1){
            return view('site.company.archived_orders_aucation_out',compact('aucations'));
        }else{
            return view('site.user.archived_orders_aucation_out',compact('aucations'));
        }
     
    }

    public function archived_orders_aucation_company()
    {
        $user =\App\User::find(Auth()->user()->id);
        $aucations=$user->aucations()->where('status_of_pay','active')->get();
        // return $aucations;
        return view('site.company.pending_orders_aucation',compact('aucations'));
    }

    public function pending_orders_aggregation_out()
    {
        $user     =\App\User::find(Auth()->user()->id);
        $aggregationgroups=$user->aggregationgroups()->where('status_pay','pending')->get();
        if($user->is_company==1){
            return view('site.company.pending_orders_aggregations_out',compact('aggregationgroups'));
        }else{
            return view('site.user.pending_orders_aggregations_out',compact('aggregationgroups'));
        }
      
    }

    public function archived_orders_aggregation_out()
    {
        $user       =\App\User::find(Auth()->user()->id);
        $aggregationgroups=$user->aggregationgroups()->where('status_pay','active')->get();
        if($user->is_company==1){
            return view('site.company.archived_orders_aggregations_out',compact('aggregationgroups'));
        }else{
            return view('site.user.archived_orders_aggregations_out',compact('aggregationgroups'));
        }
       
    }

    public function pending_orders_aucation_company()
    {
        $user =\App\User::find(Auth()->user()->id);
        $aucations=$user->aucations()->where('status_of_pay','pending')->get();
        return view('site.company.pending_orders_aucation',compact('aucations'));
    }

    public function pending_orders_aggregation_company()
    {
        $user =\App\User::find(Auth()->user()->id);
        $aggregations=$user->aggregations()->where('status_id', \App\Status::where('slug','inactive')->firstOrFail()->id)->get();
        return view('site.company.pending_orders_aggregations',compact('aggregations'));
    }

    public function buy_points()
    {
        return view('site.company.buy_points');
    }

    public function save_request_of_buy_points(Request $request)
    {
        $request->validate([    
            'number_of_points'          => 'required|numeric',
            'Payment_method'            => 'required',
        ]);
        $package                        =\App\Package::firstOrFail();
        $currency                       =\App\Currency::find($package->currency_id);
        $status                         =Status::where('slug','pending')->firstOrFail();
        $requestpoint                   =new Requestpoint;
        $requestpoint->status_id        =$status->id;
        $requestpoint->number_of_points =$request->number_of_points;
        $requestpoint->price            =$package->price * $request->number_of_points;
        $requestpoint->currency_id      =$currency->id;
        $requestpoint->user_id          =Auth()->user()->id;
        if($request->Payment_method=="cash"){
            $requestpoint->Payment_method   =$request->Payment_method;
            $requestpoint->save(); 

            session()->flash('success', 'Suspended until approved by the Admin');
            return redirect()->route('profile_user0');
        }
    }

    public function transfer_points()
    {
        if(Auth()->user()->is_company==1){
            return view('site.company.transfer_points');
        }else{
            return view('site.user.transfer_points');
        }
       
    }

    public function save_transfer_points(Request $request)
    {
        
        $request->validate([    
            'number_of_points'          => 'required|numeric',
            'email'                     => 'required|email',
        ]);
       
        $user=User::find(Auth()->user()->id);
        if($user->active_points < $request->number_of_points){
            session()->flash('error', 'quantity of points is over');
            return redirect()->back();
        }
        
        $to=User::where('email',$request->email)->firstOrFail()->id;
        // return $to;
        if($to){
            $status                           =Status::where('slug','pending')->firstOrFail();
            $transferpoint                    =new Transferpoints;
            $transferpoint->status_id         =$status->id;
            $transferpoint->number_of_points  =$request->number_of_points;
            $transferpoint->to                =$to;
            $transferpoint->from              =Auth()->user()->id;
            $transferpoint->save();
        
            $user->active_points  -= $request->number_of_points;
            $user->pending_points += $request->number_of_points;
            $user->save();
            session()->flash('success', 'transfer pending untill approved by admin');
            return redirect()->back();
        }else{
            session()->flash('error', 'this email not exist');
            return redirect()->back();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }

    public function create_product()
    {
        $user=User::find(Auth()->user()->id);
        if($user->is_company==1){
            return view('site.company.create_product',compact('user'));
        }else{
            return redirect()->route('indexeco') ;
        }
    }

    public function save_product(Request $request)
    {
        // return $request;
        if( $request->name["en"] == null && $request->name["ar"] == null&& $request->name["ur"] == null ){
            session()->flash('error', 'you must entered at least one value of title');
            return redirect()->back();
        }
        if( $request->description["en"] == null && $request->description["ar"] == null && $request->description["ar"] == null ){
            session()->flash('error', 'you must entered at least one value of description');
            return redirect()->back();
        }
        $request->validate([    
            'price'                     => 'required|numeric',
            'sale'                      => 'nullable|numeric',
            'number'                    => 'required|numeric',
            'position'                  => 'required|exists:positions,id',
            'category'                  => 'required|exists:categories,id',
            'subcategory'               => 'required|exists:subcategories,id',
            'currency'                  => 'required|exists:currencies,id',
            'productimage'              => 'nullable|array|min:1',
            'productimage.*'            => 'nullable|mimes:jpg,jpeg,png,gif',
            'image'                     => 'required|mimes:jpg,jpeg,png,gif',
            'video'                     => 'nullable|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4,application/octet-stream',
            'city'                      => 'required|exists:cities,id',
        ]);
        if(isset($request->addmoreoffer)){
            foreach ($request->addmoreoffer as  $value) {
                if($value[0] > $request->number){
                    return redirect()->back()->with(['status' => 'error', 'message' => __('the number must be greeter than from offer ')]);
                } 
                if($value[1] > $request->number){
                    return redirect()->route('products.index')->with(['status' => 'error', 'message' => __('the number must be greeter than from offer ')]);
                } 
            }
        }
    
        // return $request;
        $product                 =new Product;
        $product->{"name:ar"}              = $request->name["ar"];
        $product->{"name:en"}              = $request->name["en"];
        $product->{"name:ur"}              = $request->name["ur"];

        $product->{"description:ar"}        = $request->description["ar"];
        $product->{"description:en"}        = $request->description["en"];
        $product->{"description:ur"}        = $request->description["ur"];

        $product->price          = $request->price;
        $product->order          =100;
        $product->number          =$request->number;
        $product->sale           =$request->sale;
        $product->category_id    =$request->category;
        $product->subcategory_id =$request->subcategory;
        $product->subsubcategory_id =$request->subsubcategory;
        $product->currency_id    =$request->currency;
        $product->position_id    =$request->position;
        $product->user_id        =Auth()->user()->id;
        $product->city_id        =$request->city;

        // if(Auth::user()->hasRole('admin')){
        //     $status=Status::where('slug','active')->firstOrFail()->id;
        //     $product->status_id      =$status;
        // }
        $status=Status::where('slug','pending')->firstOrFail()->id;
        $product->status_id      =$status;
       
        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(600, 400)->save($path);
            $product->image        =$filename;
        }
        if($request->hasFile('video')){
            $video = $request->video;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$video->getClientOriginalExtension();
            $request->file('video')->storeAs(
                'public', $filename
            ); 
            $product->video        =$filename;
        }
        $product->save();
       
        if(isset($request->productimage)){
            foreach ($request->productimage as  $image) {
                $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
                $path = storage_path('app/public/' . $filename);
                Image::make($image->getRealPath())->resize(600, 400)->save($path);
                $productimage = new Productimages;
                $productimage->image        =$filename;
                $productimage->product_id        =$product->id;
                $productimage->save();
            }
        }
        if(isset($request->addmoresize)){
            foreach ($request->addmoresize as  $value) {
                $productsize = new Productsize;
                $productsize->size =$value[0];
                $productsize->product_id =$product->id;
                $productsize->save();
            }
        }
        if(isset($request->addmorecolor)){
            foreach ($request->addmorecolor as  $value) {
                $productcolor = new Productcolors;
                $productcolor->color =$value[0];
                $productcolor->product_id =$product->id;
                $productcolor->save();
            }
        }
        if(isset($request->addmoreoffer)){
            foreach ($request->addmoreoffer as  $value) {
                $productoffer = new Productoffers;
                $productoffer->from =$value[0];
                $productoffer->to =$value[1];
                $productoffer->price =$value[2];
                $productoffer->product_id =$product->id;
                $productoffer->save();
            }
        }
        session()->flash('success', 'Suspended until approved by the Admin');
        return redirect()->route('suspend_products');
    
    }
    
    public function edit_product( $id){
        $product=Product::find($id);
        $p_category=Category::find($product->category_id);
        $p_subcategories=Subcategory::where('category_id',$p_category->id)->get();
        $p_subsubcategories=Subsubcategory::where('subcategory_id',$product->subcategory_id)->get();
        return view('site.company.edit_product',compact('product','p_category','p_subcategories','p_subsubcategories'));
    }

    public function save_edit_product(Request $request, $id){
        // return $request;
        if( $request->name["en"] == null && $request->name["ar"] == null  && $request->name["ur"] == null  ){
            session()->flash('error', 'you must entered at least one value of title');
            return redirect()->back();
        }
        if( $request->description["en"] == null && $request->description["ar"] == null  && $request->description["ur"] == null  ){
            session()->flash('error', 'you must entered at least one value of description');
            return redirect()->back();
        }
        $request->validate([    
            'price'                     => 'required|numeric',
            'sale'                      => 'nullable|numeric',
            'number'                    => 'required|numeric',
            'position'                  => 'required|exists:positions,id',
            'category'                  => 'required|exists:categories,id',
            'subcategory'               => 'required|exists:subcategories,id',
            'currency'                  => 'required|exists:currencies,id',
            'productimage'              => 'nullable|array|min:1',
            'productimage.*'            => 'nullable|mimes:jpg,jpeg,png,gif',
            'addmoresize'               => 'nullable|array|min:1',
            'addmorecolor'              => 'nullable|array|min:1',
            'addmoreoffer'              => 'nullable|array|min:1',
            'image'                     => 'nullable|mimes:jpg,jpeg,png,gif',
            'video'                     => 'nullable|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4,application/octet-stream',
            'city'                      => 'required|exists:cities,id',
        ]);
     
        if(isset($request->addmoreoffer)){
            foreach ($request->addmoreoffer as  $value) {
                if($value[0] > $request->number){
                    return redirect()->back()->with(['status' => 'error', 'message' => __('the number must be greeter than from offer ')]);
                } 
                if($value[1] > $request->number){
                    return redirect()->route('products.index')->with(['status' => 'error', 'message' => __('the number must be greeter than from offer ')]);
                } 
            }
        }
        
        $product                 =Product::find($id);
        $product->{"name:ar"}              = $request->name["ar"];
        $product->{"name:ur"}              = $request->name["ur"];
        $product->{"name:en"}              = $request->name["en"];

        $product->{"description:ar"}        = $request->description["ar"];
        $product->{"description:ur"}        = $request->description["ur"];
        $product->{"description:en"}        = $request->description["en"];
        
        $product->price           = $request->price;
        $product->order          =100;
        $product->sale           =$request->sale;
        $product->is_free        =(boolean)$request->is_free;
        $product->category_id    =$request->category;
        $product->subcategory_id =$request->subcategory;
        $product->currency_id    =$request->currency;
        $product->position_id    =$request->position;
        $product->user_id        =Auth()->user()->id;
        $status=Status::where('slug','pending')->firstOrFail()->id;
        $product->status_id      =$status;
        $product->city_id        =$request->city;
             
        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(600, 400)->save($path);
            $product->image        =$filename;
        }
        if($request->hasFile('video')){
            $video = $request->video;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$video->getClientOriginalExtension();
            $request->file('video')->storeAs(
                'public', $filename
            ); 
            $product->video        =$filename;
        }

        $product->save();
        
        if(isset($request->removed_image)){
            foreach($request->removed_image as $remove){
                foreach($product->productimages as $img){
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
                Image::make($image->getRealPath())->resize(600, 400)->save($path);
                $productimage = new Productimages;
                $productimage->image        =$filename;
                $productimage->product_id        =$product->id;
                $productimage->save();
            }
        }

        foreach($product->productsizes as $size){
            $size->delete();
        }
        if(isset($request->addmoresize)){
            foreach ($request->addmoresize as  $value) {
                $productsize = new Productsize;
                $productsize->size =$value[0];
                $productsize->product_id =$product->id;
                $productsize->save();
            }
        }

        foreach($product->productcolors as $color){
            $color->delete();
        }
        if(isset($request->addmorecolor)){
            foreach ($request->addmorecolor as  $value) {
                $productcolor = new Productcolors;
                $productcolor->color =$value[0];
                $productcolor->product_id =$product->id;
                $productcolor->save();
            }
        }

        foreach($product->Productoffers as $offer){
            $offer->delete();
        }
        if(isset($request->addmoreoffer)){
            foreach ($request->addmoreoffer as  $value) {
                $productoffer = new Productoffers;
                $productoffer->from =$value[0];
                $productoffer->to =$value[1];
                $productoffer->price =$value[2];
                $productoffer->product_id =$product->id;
                $productoffer->save();
            }
        }

        session()->flash('success', 'Suspended until approved by the Admin');
        return redirect()->route('suspend_products');

}

    public function products()
    {
        $products=Product::where('user_id',Auth()->user()->id)->orderBy('created_at', 'asc')->paginate(5);
        $user=User::find(Auth()->user()->id);
        return view('site.company.products',compact('products','user'));
    }

    public function all_subcategories(Request $request) {
        return Category::findOrFail($request->id)->subcategories()->get();
    }
}
