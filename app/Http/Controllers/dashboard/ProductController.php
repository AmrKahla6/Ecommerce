<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Status;
use App\Archivepoint;
use App\Order;
use App\Review;
use App\Productsize;
use App\Productcolors;
use App\Productimages;
use App\Productoffers;
use App\Category;
use App\Subcategory;
use App\Subsubcategory;
use Illuminate\Support\Facades\Storage;

use LaravelLocalization;

use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:index_product')->only('index');
        $this->middleware('permission:create_product')->only(['create', 'store']);
        $this->middleware('permission:view_product')->only('show');
        $this->middleware('permission:edit_product')->only(['edit', 'update']);
        $this->middleware('permission:delete_product')->only('destroy');

        $this->middleware('permission:dash_all_sold_products')->only('all_sold_products');
        $this->middleware('permission:dash_all_suspend_products')->only('all_suspend_products');
        $this->middleware('permission:dash_all_pending_review')->only('all_pending_review');
        $this->middleware('permission:dash_all_archived_review')->only('all_archived_review');
        $this->middleware('permission:dash_change_status_0f_review')->only('change_status_0f_review');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
        return view('dashboard.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $this->validate_trans($request, [
            ['name', 'required|string|max:255'],
            ['description', 'required|string'],
        ]);
        $request->validate([
            'price'                     => 'required|numeric',
            'sale'                      => 'nullable|numeric',
            'number'                    => 'required|numeric',
            'category'                  => 'required|exists:categories,id',
            'productimage'              => 'nullable|array|min:1',
            'productimage.*'            => 'nullable|mimes:jpg,jpeg,png,gif',
            'image'                     => 'required|mimes:jpg,jpeg,png,gif',
            'youtube'                   => 'nullable|string|max:255',
            'subcategory'               => 'required|exists:subcategories,id',
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
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $product->{"name:$localeCode"}               = $request->name["$localeCode"];
            $product->{"description:$localeCode"}        = $request->description["$localeCode"];
        }
        $product->price          = $request->price;
        $product->number         =$request->number;
        $product->sale           =$request->sale;
        $product->video          = null;
        $product->youtube        = $request->youtube;
        $product->category_id    =$request->category;
        $product->subcategory_id =$request->subcategory;
        $product->user_id        =Auth()->user()->id;

        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(600, 400)->save($path);
            $product->image        =$filename;
        }
        $product->save();

        if(isset($request->productimage)){
            foreach ($request->productimage as  $image) {
                $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
                $path = storage_path('app/public/' . $filename);
                Image::make($image->getRealPath())->resize(1920, 800)->save($path);
                $productimage = new Productimages;
                $productimage->image             =$filename;
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
        return redirect()->route('products.index')->with(['status' => 'success', 'message' => __('Stored successfully')]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::find($id);
        return view('dashboard.products.view',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Product::find($id);
        $p_category=Category::find($product->category_id);
        $p_subcategories=Subcategory::where('category_id',$p_category->id)->get();
        return view('dashboard.products.edit',compact('product','p_category','p_subcategories','p_subsubcategories'));
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
        // return $request;
        $this->validate_trans($request, [
            ['name', 'required|string|max:255'],
            ['description', 'required|string'],
        ]);
        $request->validate([
            'price'                     => 'required|numeric',
            'sale'                      => 'nullable|numeric',
            'number'                    => 'required|numeric',
            'category'                  => 'required|exists:categories,id',
            'productimage'              => 'nullable|array|min:1',
            'productimage.*'            => 'nullable|mimes:jpg,jpeg,png,gif',
            'addmoresize'               => 'nullable|array|min:1',
            'addmorecolor'              => 'nullable|array|min:1',
            'addmoreoffer'              => 'nullable|array|min:1',
            'image'                     => 'nullable|mimes:jpg,jpeg,png,gif',
            'youtube'                   => 'nullable|string|max:255',
            'subcategory'               => 'required|exists:subcategories,id',
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
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $product->{"name:$localeCode"}               = $request->name["$localeCode"];
            $product->{"description:$localeCode"}        = $request->description["$localeCode"];
        }
        $product->price          = $request->price;
        $product->number         =$request->number;
        $product->sale           =$request->sale;
        $product->category_id    =$request->category;
        $product->subcategory_id =$request->subcategory;
        if($request->youtube && $request->youtube !== null){
            $product->youtube        = $request->youtube;
            Storage::disk('public')->delete($product->video);
            $product->video          = null;

        }

        if($request->hasFile('image')){
            Storage::disk('public')->delete($product->image);
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(500, 500)->save($path);
            $product->image        =$filename;
        }
        $product->save();

        if(isset($request->removed_image)){
            foreach($request->removed_image as $remove){
                foreach($product->productimages as $img){
                    if($remove == $img->image){
                        Storage::disk('public')->delete($remove);
                        $img->delete();
                    }
                }
            }
        }
        if(isset($request->productimage)){
            foreach ($request->productimage as  $image) {
                $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
                $path = storage_path('app/public/' . $filename);
                Image::make($image->getRealPath())->resize(115, 50)->save($path);
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

        return redirect()->route('products.index')->with(['status' => 'success', 'message' => __('updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('products.index')->with('status', 'position Deleted suucssefully');;
    }

    // public function all_suspend_products()
    // {
    //     $status=Status::where('slug','pending')->firstOrFail()->id;
    //     $products=Product::where('status_id',$status)->get();
    //     return view('dashboard.products.suspend_products',compact('products'));
    // }

    // public function all_sold_products()
    // {
    //     return view('dashboard.orders.pending_requests');
    // }

    // public function change_status_of_order($id)
    // {
    //     $user=\App\User::find($id);
    //     return view('dashboard.orders.pending_requests',compact('user'));
    // }


    // public function not_paid_no_deduct(Request $request , $id)
    // {
    //     // return $request;
    //     $order=Order::find($id);
    //     $user=\App\User::find($order->user_id);
    //     $order->status="not_paid_no_deduct";
    //     $order->save();
    //     $product=\App\Product::find($order->product_id);
    //     if($request->method_pay == "cash"){
    //         $user->active_points += $product->number_of_pending_points_to_pay_cash;
    //         $user->pending_points -= $product->number_of_pending_points_to_pay_cash;
    //         $user->save();

    //         $archive_point= new Archivepoint;
    //         $archive_point->user_id=$user->id;
    //         $archive_point->{'description:ar'}           = 'تم رجوع '.$product->number_of_pending_points_to_pay_cash.'  لعدم اتاحة منتج  '.$product->{'name:ar'};
    //         $archive_point->{'description:en'}           = 'we returned ' .$product->number_of_pending_points_to_pay_cash. ' point because '.$product->{'name:en'}.' Not available';
    //         $archive_point->{'description:ur'}           =  'we returned ' .$product->number_of_pending_points_to_pay_cash. ' point because '.$product->{'name:en'}.' Not available';
    //         $archive_point->save();

    //     }elseif($request->method_pay == "points"){
    //         $package=\App\Package::first();
    //         $currency=\App\Currency::find($package->currency_id);
    //         $point_in_dollar=$package->price/$currency->contain_in_dollar;
    //         $number_of_points=$order->total_of_price_product/$point_in_dollar;
    //         $user->active_points += $number_of_points;
    //         $user->pending_points -= $number_of_points;
    //         $user->save();

    //         $archive_point= new Archivepoint;
    //         $archive_point->user_id=$user->id;
    //         $archive_point->{'description:ar'}           = 'تم رجوع '.$number_of_points.'  لعدم اتاحة منتج  '.$product->{'name:ar'};
    //         $archive_point->{'description:en'}           = 'we returned ' .$number_of_points. ' point because '.$product->{'name:en'}.' Not available';
    //         $archive_point->{'description:ur'}           =  'we returned ' .$number_of_points. ' point because '.$product->{'name:en'}.' Not available';
    //         $archive_point->save();
    //     }
    //     $product=\App\Product::find($order->product_id);
    //     $product->number +=$order->quantity;
    //     $product->save();
    //     return redirect()->back()->with(['status' => 'success', 'message' => __('updated successfully')]);
    // }
    // public function not_paid_with_deduct(Request $request , $id)
    // {
    //     $order=Order::find($id);
    //     $order->status="not_paid_with_deduct";
    //     $order->save();
    //     $user=\App\User::find($order->user_id);
    //     $product=\App\Product::find($order->product_id);

    //     if($order->method_pay == "cash"){
    //         $user->pending_points -= $product->number_of_pending_points_to_pay_cash;
    //         $user->save();

    //         $archive_point= new Archivepoint;
    //         $archive_point->user_id=$user->id;
    //         $archive_point->{'description:ar'}           = 'تم خصم '.$product->number_of_pending_points_to_pay_cash.'نقطة من منتج  '.$product->{'name:ar'};
    //         $archive_point->{'description:en'}           = 'we deduct ' .$product->number_of_pending_points_to_pay_cash. ' point from '.$product->{'name:en'};
    //         $archive_point->{'description:ur'}           =  'we deduct ' .$product->number_of_pending_points_to_pay_cash. ' point from '.$product->{'name:en'};
    //         $archive_point->save();

    //     }else{
    //         $package=\App\Package::first();
    //         $currency=\App\Currency::find($package->currency_id);
    //         $point_in_dollar=$package->price/$currency->contain_in_dollar;
    //         $number_of_points=$order->total_of_price_product/$point_in_dollar;
    //         $user->active_points += $number_of_points - $product->number_of_pending_points_to_pay_cash;
    //         $user->pending_points -= $number_of_points;
    //         $user->save();

    //         $archive_point= new Archivepoint;
    //         $archive_point->user_id=$user->id;
    //         $archive_point->{'description:ar'}           = 'تم خصم '.$product->number_of_pending_points_to_pay_cash.' نقطة من منتج '.$product->{'name:ar'};
    //         $archive_point->{'description:en'}           = 'we deduct ' .$product->number_of_pending_points_to_pay_cash. ' point from '.$product->{'name:en'};
    //         $archive_point->{'description:ur'}           =  'we deduct ' .$product->number_of_pending_points_to_pay_cash. ' point from '.$product->{'name:en'};
    //         $archive_point->save();
    //     }
    //     $product->number += $order->quantity;
    //     $product->save();
    //     return redirect()->back()->with(['status' => 'success', 'message' => __('updated successfully')]);
    // }

    // public function had_paid(Request $request , $id)
    // {
    //     $order=Order::find($id);
    //     $user=\App\User::find($order->user_id);
    //     $order->status="active";
    //     $order->save();
    //     if($request->method_pay == "cash"){
    //         $user=\App\User::find($order->user_id);
    //         $product=\App\Product::find($order->product_id);
    //         $user->active_points += $product->number_of_pending_points_to_pay_cash;
    //         $user->pending_points -= $product->number_of_pending_points_to_pay_cash;
    //         $user->save();

    //         $archive_point= new Archivepoint;
    //         $archive_point->user_id=$user->id;
    //         $archive_point->{'description:ar'}           = 'تم رجوع '.$product->number_of_pending_points_to_pay_cash.'  لشرائك منتج  '.$product->{'name:ar'} .'كاش';
    //         $archive_point->{'description:en'}           = 'we returned ' .$product->number_of_pending_points_to_pay_cash. ' point because you buy '.$product->{'name:en'} .'cash';
    //         $archive_point->{'description:ur'}           =  'we returned ' .$product->number_of_pending_points_to_pay_cash. ' point because you buy '.$product->{'name:en'} .'cash';
    //         $archive_point->save();

    //     }elseif($request->method_pay == "points"){
    //         $package=\App\Package::first();
    //         $currency=\App\Currency::find($package->currency_id);
    //         $point_in_dollar=$package->price/$currency->contain_in_dollar;
    //         $number_of_points=$order->total_of_price_product/$point_in_dollar;
    //         $user->pending_points -= $number_of_points;
    //         $user->save();

    //         $archive_point= new Archivepoint;
    //         $archive_point->user_id=$user->id;
    //         $archive_point->{'description:ar'}           = 'تم خصم '.$number_of_points.'  لشرائك منتج  '.$product->{'name:ar'} .'بالنقاط';
    //         $archive_point->{'description:en'}           = 'we deduct ' .$number_of_points. ' point because you buy '.$product->{'name:en'} .'points';
    //         $archive_point->{'description:ur'}           =  'we deduct ' .$number_of_points. ' point because you buy '.$product->{'name:en'} .'points';
    //         $archive_point->save();
    //     }

    //     return redirect()->back()->with(['status' => 'success', 'message' => __('updated successfully')]);
    // }

    public function all_pending_review()
    {
        $reviews=Review::where('status','pending')->get();
        return view('dashboard.reviews.pending',compact('reviews'));
    }
    public function all_archived_review()
    {
        $reviews=Review::where('status','!=','pending')->get();
        return view('dashboard.reviews.archived',compact('reviews'));
    }

    // public function change_status_0f_review(Request $request , $id)
    // {
    //     $review=Review::find($id);
    //     $product=\App\Product::find($review->product_id);
    //     if($request->status=="active"){
    //         $request->validate([
    //             'number_of_points'                     => 'required|numeric',
    //         ]);

    //         $review->status="active";
    //         $review->number_of_points=$request->number_of_points;
    //         $review->save();
    //         $user=\App\User::find($review->user_id);
    //         $user->active_points +=$request->number_of_points;
    //         $user->review_points   += $request->number_of_points;
    //         $user->save();

    //         $archive_point= new Archivepoint;
    //         $archive_point->user_id=$user->id;
    //         $archive_point->{'description:ar'}           = 'تم اضافة '.$request->number_of_points.'  لاضافتك تقييم الى منتج  '.$product->{'name:ar'} ;
    //         $archive_point->{'description:en'}           = 'we add ' .$request->number_of_points. ' point because you add review to '.$product->{'name:en'} ;
    //         $archive_point->{'description:ur'}           =  'we add ' .$request->number_of_points. ' point because you add review to '.$product->{'name:en'} ;
    //         $archive_point->save();

    //         return redirect()->back()->with(['status' => 'success', 'message' => __('updated successfully')]);
    //     }
    //     if($request->status=="block"){
    //         $review->status="block";
    //         $review->save();
    //         return redirect()->back()->with(['status' => 'success', 'message' => __('updated successfully')]);
    //     }
    // }

}
