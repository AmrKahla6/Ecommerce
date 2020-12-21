<?php

namespace App\Http\Controllers;
use App\User;
use App\Setting;
use App\Status;
use App\Cart;
use App\Category;
use App\Product;
use App\Review;
use Hash;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function googleLogin(Request $request)  {
        $google_redirect_url = route('glogin');
        $gClient = new \Google_Client();
        $gClient->setApplicationName(config('services.google.app_name'));
        $gClient->setClientId(config('services.google.client_id'));
        $gClient->setClientSecret(config('services.google.client_secret'));
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setDeveloperKey(config('services.google.api_key'));
        $gClient->setScopes(array(
            'https://www.googleapis.com/auth/plus.me',
            'https://www.googleapis.com/auth/userinfo.email',
            'https://www.googleapis.com/auth/userinfo.profile',
        ));
        $google_oauthV2 = new \Google_Service_Oauth2($gClient);
        if ($request->get('code')){
            $gClient->authenticate($request->get('code'));
            $request->session()->put('token', $gClient->getAccessToken());
        }
        if ($request->session()->get('token'))
        {
            $gClient->setAccessToken($request->session()->get('token'));
        }
        if ($gClient->getAccessToken())
        {
            //For logged in user, get details from google using access token
            $guser = $google_oauthV2->userinfo->get();  
               
                $request->session()->put('name', $guser['name']);
                if ($user =User::where('email',$guser['email'])->first())
                {
                    //logged your user via auth login
                }else{
                    //register your user with response data
                }               
         return redirect()->route('user.glist');          
        } else
        {
            //For Guest user, get google login url
            $authUrl = $gClient->createAuthUrl();
            return redirect()->to($authUrl);
        }
    }
    public function listGoogleUser(Request $request){
      $users = User::orderBy('id','DESC')->paginate(5);
     return view('users.list',compact('users'))->with('i', ($request->input('page', 1) - 1) * 5);;
    }

    
    public function profile_user()
    {
        $user       =Auth()->user();
        $active     = "profile" ;
        return view('site.user.edit_profile' , compact('user' , 'active' ));
    }

    public function cart_profile_user()
    {
        $carts      = auth()->user()->carts;
        $user       =Auth()->user();
        $active     = "cart" ;
        return view('site.user.cart_user', compact('carts','user' , 'active'));
    }
    public function favourite_profile_user()
    {
        $session_favourite = session()->get('favourite');
        $user              =Auth()->user();
        $active            = "favourite" ;
        return view('site.user.favourite_user', compact('session_favourite' ,'user' , 'active'));
    }

    public function show_image(Request $request)
    {
        $product=Product::find($request->kk);
        return "route('image_show', $product->image)";
    }

    public function favourite()
    {
        $session_favourite = session()->get('favourite');
        return view('site.favourite', compact('session_favourite'));
    }

    public function add_to_cart_from_favourite(Request $request)
    {
        $product = Product::find($request->product);
        if(auth()->check()){
            if(!count(Cart::where('product_id',$request->product)->where('user_id',auth()->user()->id)->get())){
                $cart                       =new Cart;
                $cart->product_id           =$request->product; 
                $cart->quantity_of_product  =1;

                if($product->sale != null){
                    $cart->total_of_price_product  =( (100-$product->sale) / 100) * $product->price;
                    $cart->price_of_product        =( (100-$product->sale) / 100) * $product->price;
                    $cart->total_of_price_cart     =( (100-$product->sale) / 100) * $product->price;
                }else{
                    $cart->total_of_price_product  =$product->price;
                    $cart->price_of_product        =$product->price;
                    $cart->total_of_price_cart     =$product->price;
                }
                $cart->user_id                     =auth()->user()->id;
                $cart->save();
        
                $favourite = session()->get('favourite');
                unset($favourite[$request->product]);
                session()->put('favourite', $favourite);

                session()->flash('success', 'Added to cart successfully');
                return redirect()->back();
            }else{
                $cart=Cart::where('product_id',$request->product)->firstOrFail();
                $cart->quantity_of_product    += 1;
                $cart->save();
    
                $favourite = session()->get('favourite');
                unset($favourite[$request->product]);
                session()->put('favourite', $favourite);
                 
                session()->flash('success', 'Added to cart successfully');
                return redirect()->back();
            }
          
        }else{
            $cart = session()->get('cart');
            $product = Product::find($request->product);
            if($cart && isset($cart[$request->product]) ) {
                $cart[$product->id]['quantity_of_product'] += 1;
                $float = (float)$cart[$product->id]['total_of_price_product'];
                if($product->sale != null){
                    $cart[$product->id]['total_of_price_product']= $float + ( (100-$product->sale) / 100) * $product->price ;
                }else{
                    $cart[$product->id]['total_of_price_product']= $float+$product->price;
                }
                session()->put('cart', $cart);

                $favourite = session()->get('favourite');
                unset($favourite[$request->product]);
                session()->put('favourite', $favourite);

                session()->flash('success', 'Added to cart successfully');
                return redirect()->back();
            }else{
                // if item not exist in cart then add to cart with quantity = 1
                if($product->sale != null){
                    $price = ( (100-$product->sale) / 100) * $product->price ;
                }else{
                    $price = $product->price;
                }
                $cart[$product->id] = [
                    "id" => $product->id,
                    "name" => $product->name,
                    "price" => $price ,
                    "quantity_of_product" => 1,
                    "total_of_price_product" => $price,
                    "photo" => route('image_show', $product->image)
                ];
                session()->put('cart', $cart);

                $favourite = session()->get('favourite');
                unset($favourite[$request->product]);
                session()->put('favourite', $favourite);

                session()->flash('success', 'Added to cart successfully');
                return redirect()->back();
            }
        }
    }

    public function remove_from_favourite_2(Request $request)
    {
        if($request->product) {
            $favourite = session()->get('favourite');
            unset($favourite[$request->product]);
            session()->put('favourite', $favourite);
            count(session('favourite')) ? $count=count(session('favourite')) : $count=0 ;
            session()->flash('success', 'Remove from favourite successfully');
            return redirect()->back();
        }
    }

    public function add_to_favourite(Request $request)
    {
        // return $request;
        $product = Product::find( $request->product);
        $id=$product->id;
        if(!$product) {
            abort(404);
        }
        $favourite = session()->get('favourite');
        // if cart is empty then this the first product
        if(!$favourite) {
            $favourite = [
                $id => [
                    "id" => $product->id,
                    "name" => $product->name,
                    "price" => $product->price,
                    "photo" => route('image_show', $product->image)
                ]
            ];
            session()->put('favourite', $favourite);
            count(session('favourite')) ? $count=count(session('favourite')) : $count=0 ;
            return response()->json([$favourite[$id],$count]);
        }
        // if item not exist in cart then add to cart with quantity = 1
        $favourite[$id] = [
            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            "photo" => route('image_show', $product->image)
        ];

        session()->put('favourite', $favourite);
        count(session('favourite')) ? $count=count(session('favourite')) : $count=0 ;
        return response()->json([$favourite[$id],$count]);
    }

    public function delete_cart(Request $request)
    {
        if(auth()->check()){
            $cart=Cart::where('product_id',$request->product)->firstOrFail()->delete();
            session()->flash('success', 'cart deleted successfully');
            return redirect()->back();
        }else{
            $cart = session()->get('cart');
            unset($cart[$request->product]);
            session()->put('cart', $cart);
            session()->flash('success', 'cart deleted successfully');
            return redirect()->back();
        }
    }

    public function update_cart(Request $request)
    {
        // return $request;
        if(auth()->check()){
            foreach($request->products as $key_product => $product_id){
                foreach($request->quantities as $key_quantity => $quantity){
                    if($key_product == $key_quantity){
                        $cart=Cart::where('product_id',$product_id)->firstOrFail();
                        $cart->quantity_of_product    = $quantity;
                        $cart->save();
                    }
                }
            }
            session()->flash('success', 'cart updated successfully');
            return redirect()->back();
        }else{
            $cart = session()->get('cart');
            foreach($request->products as $key_product => $product_id){
                foreach($request->quantities as $key_quantity => $quantity){
                    if($key_product == $key_quantity){
                        $product = Product::find($product_id);
                        $cart[$product->id]['quantity_of_product'] = $quantity;
                        $float = (float)$cart[$product->id]['total_of_price_product'];
                        if($product->sale != null){
                            $cart[$product->id]['total_of_price_product']= $float + ( (100-$product->sale) / 100) * $product->price ;
                        }else{
                            $cart[$product->id]['total_of_price_product']= $float+$product->price;
                        }
                        session()->put('cart', $cart);
                    }
                }
            }
            session()->flash('success', 'cart updated successfully');
            return redirect()->back();
        }
    }

    
    public function addToCart(Request $request)
    {
        $product = Product::find( $request->product);
        $id=$product->id;
        if(!$product) {
            abort(404);
        }
        $quantity = 1 ;
        isset($request->quantity) ? $quantity = $request->quantity : '' ;
        if(auth()->check()){
            if(!count(Cart::where('product_id',$product->id)->where('user_id',auth()->user()->id)->get())){
                $cart              =new Cart;
                $cart->product_id  =$request->product; 
                $cart->quantity_of_product=$quantity;

                if($product->sale != null){
                    $cart->total_of_price_product=(( (100-$product->sale) / 100) * $product->price) * $quantity;
                    $cart->price_of_product=( (100-$product->sale) / 100) * $product->price;
                    $cart->total_of_price_cart=( (100-$product->sale) / 100) * $product->price;

                }else{
                    $cart->total_of_price_product=$product->price * $quantity;
                    $cart->price_of_product=$product->price;
                    $cart->total_of_price_cart=$product->price * $quantity;
                }
            
                $cart->user_id=auth()->user()->id;
                $cart->save();
        
                return response()->json([$product->id  ,  1  ,  $product->name  ,  route('image_show', $product->image)  , $cart->total_of_price_product , $cart->quantity_of_product , $cart->price_of_product  ]);
            }else{
                $cart=Cart::where('product_id',$product->id)->where('user_id',auth()->user()->id)->firstOrFail();
                $cart->quantity_of_product    = $cart->quantity_of_product + $quantity;

                if($product->sale != null){
                    $cart->total_of_price_product = $cart->total_of_price_product + ((( (100-$product->sale) / 100) * $product->price) * $quantity);
                    $cart->total_of_price_cart    = $cart->total_of_price_cart + ((( (100-$product->sale) / 100) * $product->price) * $quantity);
                    $pr_product=( (100-$product->sale) / 100) * $product->price;

                }else{
                    $cart->total_of_price_product = $cart->total_of_price_product + ($product->price * $quantity) ;
                    $cart->total_of_price_cart    = $cart->total_of_price_cart + ($product->price * $quantity);
                    $pr_product=$product->price;
                }
               
                $cart->user_id=auth()->user()->id;
                $cart->save();
                return response()->json([$product->id , 0 , $product->name , route('image_show', $product->image)  ,  $cart->total_of_price_product  ,  $cart->quantity_of_product  , $pr_product]);
            }
        }else{
            $cart = session()->get('cart');
            // if item not exist in cart
            if( $cart && isset($cart[$id]) ) {
                $cart[$id]['quantity_of_product'] += $quantity;
                $float = (float)$cart[$id]['total_of_price_product'];
                if($product->sale != null){
                    $pr_product = (( (100-$product->sale) / 100) * $product->price) * $quantity;
                    $cart[$id]['total_of_price_product']= $float + (( (100-$product->sale) / 100) * $product->price) * $quantity ;
                }else{
                    $cart[$id]['total_of_price_product']= $float+($product->price  * $quantity);
                    $pr_product = $product->price * $quantity;
                }
                session()->put('cart', $cart);
                return response()->json([$product->id  ,  0  ,  $product->name  ,  route('image_show', $product->image)  ,  $cart[$id]['total_of_price_product']  ,  $cart[$id]['quantity_of_product']  ,  $pr_product]);
            }else{
                // if item not exist in cart then add to cart with quantity = 1
                if($product->sale != null){
                    $price = ( (100-$product->sale) / 100) * $product->price ;
                    $total_price = (( (100-$product->sale) / 100) * $product->price)  * $quantity ;
                }else{
                    $price = $product->price;
                    $total_price = $product->price  * $quantity;
                }
                $cart[$id] = [
                    "id" => $product->id,
                    "name" => $product->name,
                    "price" => $price ,
                    "quantity_of_product" => $quantity,
                    "total_of_price_product" => $total_price ,
                    "photo" => route('image_show', $product->image)
                ];
                session()->put('cart', $cart);
                return response()->json([$product->id  ,  1  ,  $product->name  ,  route('image_show', $product->image)  ,  $cart[$id]['total_of_price_product']  ,  $cart[$id]['quantity_of_product']  ,  $price * $quantity]);
            }
        }
    }

    public function remove_from_favourite(Request $request)
    {
       
        if($request->product) {
            
            $favourite = session()->get('favourite');
          
                unset($favourite[$request->product]);
                session()->put('favourite', $favourite);
                count(session('favourite')) ? $count=count(session('favourite')) : $count=0 ;
                return response()->json([$request->product,$count]);
        }
    }
    public function find_product(Request $request){
     
        $product = Product::where('id', $request->id)->with(['productsizes'])->with(['productcolors'])->get();
        return $product;
        $product = Product::where('id', $request->id)->with(['productsizes' => function ($query) use ($request) {
            $query->where('product_id',$request->id); }])
            ->with(['productcolors' => function ($query) use ($request) {
            $query->where('product_id',$request->id); }])
            ->get();
        return $product;
    }

  

    public function change_photo(Request $request){
        $request->validate([
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $user               =  User::find(Auth::user()->id);
        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(100, 100)->save($path);
            $user->image        =$filename;
            $user->save();
            session()->flash('success', 'You Are Changing Your Photo Successfully');
            return redirect()->back();
        }
    }
//login
    public function login(){
        return view('site.login');
    }

    public function store_user(Request $request)
    {
        // return $request;
        $request->validate([
            'name'                 => 'required|string|max:255',    
            'email'                => 'required|string|email|unique:users,email|max:255', 
            'password'             => ['required', 'string', 'min:6', 'confirmed'],  
        ]);
        
        $user                     =new User;
        $active                   = Status::where('slug', 'active')->firstOrFail();
        $user->name               =$request->name;
        $user->email              =$request->email;
        $user->password           =bcrypt($request->password);
        $user->status_id          =$active ->id;     
        $user->save();

        if(session('cart')){ 
            foreach(session('cart') as $details){
                if(!empty(\App\Product::find($details['id']))){
                    $cart                           =new Cart();
                    $cart->product_id               =$details['id']; 
                    $cart->quantity_of_product      =$details['quantity_of_product'];
                    $cart->total_of_price_product   =$details['total_of_price_product'];
                    $cart->price_of_product         =\App\Product::find($details['id'])->price;
                    $cart->user_id                  =$user->id;
                    $cart->save();
                }
            }
        }
       
        Auth::loginUsingId($user->id);
        return redirect()->route('indexeco')->with("success","you register succefully");
    }


//change_details
    public function change_details(Request $request){
        $user               =  User::find(Auth::user()->id);
        // return $request;
        $request->validate([
            'name'      => 'nullable|string',
            'phone'     => 'nullable|string',
            'email'     =>'nullable|email|unique:users,email,'.$user->id, 
            'address'   => 'nullable|string|max:255',      
            'image'     => 'nullable|mimes:jpg,jpeg,png,gif',
        ]);
        $user->name         = $request->name;
        $user->phone        = $request->phone;
        $user->email        = $request->email;
        $user->address      =$request->address;
        if($request->hasFile('image')){
            $image = $request->image;
            $filename  = mt_rand(1000, 10000).time().uniqid().'.'.$image->getClientOriginalExtension();
            $path = storage_path('app/public/' . $filename);
            Image::make($image->getRealPath())->resize(120, 120)->save($path);
            $user->image        =$filename;
        }

        $user->save();
        session()->flash('success', 'Updated successfully');
        return redirect()->back();
    }
//changePassword
    public function changePassword(Request $request){
        if (!(Hash::check($request->input('current_password'), Auth::user()->password))) {
            // The passwords matches
            session()->flash('error', 'Your current password does not matches with the password you provided. Please try again.');
            return redirect()->back();
        }
        if(strcmp($request->get('current_password'), $request->get('password')) == 0){
            //Current password and new password are same
            session()->flash('error', 'New Password cannot be same as your current password. Please choose a different password.');
            return redirect()->back();
        }
        $validatedData = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('password'));
        $user->save();
        session()->flash('success', 'Password changed successfully !');
        return redirect()->back();
    }
}
