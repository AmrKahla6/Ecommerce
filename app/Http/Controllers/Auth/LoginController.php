<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\Cart;
use App\Status;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        session()->put('previousUrl', url()->previous());

        return view('auth.login');
    }


    public function login(Request $request)
    {
        // return $request;
        $status=Status::where('slug','active')->firstOrFail()->id;
        $field  = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        if (Auth::attempt([$field => $request->login, 'password' => $request->password, 'status_id' => $status])) {

            if(session('cart')){ 
                foreach(session('cart') as $details){
                    if(!empty(\App\Product::find($details['id']))){
                        if(!empty(Cart::where('product_id',$details['id'])->where('user_id',auth()->user()->id)->first() )){
                            $cart                           =Cart::where('product_id',$details['id'])->where('user_id',auth()->user()->id)->firstOrFail();
                            $cart->quantity_of_product     +=$details['quantity_of_product']; 
                            $cart->total_of_price_product  +=$details['total_of_price_product'];
                            $cart->save();
                        }else{
                            $cart                           =new Cart();
                            $cart->product_id               =$details['id']; 
                            $cart->quantity_of_product      =$details['quantity_of_product'];
                            $cart->total_of_price_product   =$details['total_of_price_product'];
                            $cart->price_of_product         =\App\Product::find($details['id'])->price;
                            $cart->user_id                  =auth()->user()->id;
                            $cart->save();
                        }
                    }
                }
            }
            return redirect()->route('indexeco');
        }elseif (Auth::attempt([$field => $request->login, 'password' => $request->password]) && Auth()->user()->status_id != $status ) {
            Auth::logout();
            return redirect()->route('indexeco')->withErrors(['field_name' => ['this User not approved by admin']]);
        }else {
            return redirect()->route('login')->withErrors(['field_name' => ['The email or password is incorrect']]);
        }
    }

    public function redirectTo()
    {
        return str_replace(url('/'), '', session()->get('previousUrl', '/'));
    }
}
