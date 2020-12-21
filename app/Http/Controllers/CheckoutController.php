<?php

namespace App\Http\Controllers;
use App\Cart;
use App\Order;
use App\OrderProduct;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request) 
    {
        $carts = Cart::where('user_id', auth()->user()->id)->get();
        $user  = auth()->user();
        $total = $request->total;
        return view('site.checkout', compact('carts' , 'user' ,'total' ));
    }

    public function cash_on_delevery(Request $request) 
    { 
        // return $request->billing_last_name;
        // return $request;
        add_order($request);
        return auth()->user();
    }
}
