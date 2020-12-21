<?php

namespace App\Http\Controllers;
use App\Cart;
use App\Product;
use App\Archivepoint;
use App\Order;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart() 
    {
        if(auth()->check()){
            $carts = Cart::where('user_id', auth()->user()->id)->get();
            return view('site.cart', compact('carts'));
        }else{
            $session_cart = session()->get('cart');
            return view('site.cart', compact('session_cart'));
        }
    }

    public function add_to_cart(Request $request) {
        // return $request;
        $request->validate([    
            'size'                   => 'nullable|exists:productsizes,id',
            'color'                  => 'nullable|exists:productcolors,id',
            'position'               => 'nullable|exists:positions,id',
            'num_product'            => 'required|integer|min:1'
        ]);
        $product=Product::find($request->product);
        if(Auth()->user()->id == $product->user_id){
            session()->flash('error', 'this product for you');
            return redirect()->back();
        }
        if($product->number < $request->num_product){
            session()->flash('error', 'quantity over');
            return redirect()->back();
        }
        $cart                      = new Cart;
        $cart->user_id             = Auth()->user()->id;
        $cart->product_id          = $request->product;
      
        $currency=\App\Currency::where('short_code','USD')->firstOrFail();
        $cart->currency_id         = $currency->id;

        $cart->quantity_of_product = $request->num_product;

        if($request->position)
        $cart->position_id         = $request->position;
        if($request->color)
        $cart->color               = \App\Productcolors::find($request->color)->color;
        if($request->size)
        $cart->size                = \App\Productsize::find($request->size)->size;

        $x=0;
        if(count($product->productoffers)){
            foreach($product->productoffers as $offer){
                if( $offer->from <= $request->num_product && $offer->to >= $request->num_product || $offer->from >= $request->num_product && $offer->to <= $request->num_product){
                    $total_of_price_product      = $request->num_product * $offer->price;
                    $price_of_product=$offer->price;
                $x=1;
                break;
                }
            }
            if($x!=1){
                $prices=[];
                foreach($product->productoffers as $key => $offer){
                    array_push($prices,$offer->price);
                }
                $min_price=min($prices);
                foreach($product->productoffers as $offer){
                    if( $offer->from < $request->num_product && $offer->to < $request->num_product ){
                        $total_of_price_product      = $request->num_product * $min_price;
                        $price_of_product=$offer->price;
                    $x=1;
                    break;
                    }
                }
            }
        }
        if($x!=1){
            if($product->sale){
                $total_of_price_product =($product->price * (100-$product->sale)/100) * $request->num_product;
                $price_of_product=($product->price * (100-$product->sale)/100);
            }else{
                $total_of_price_product = $product->price * $request->num_product;
                $price_of_product=$product->price;
            }
            
        }
        $in_dollar_currency            =\App\Currency::find($product->currency_id);
        $cart->total_of_price_product  =$total_of_price_product/$in_dollar_currency->contain_in_dollar;
        $cart->price_of_product        =$price_of_product/$in_dollar_currency->contain_in_dollar;

        $cart->save();
        session()->flash('success', 'added to cart successfully');
        return redirect()->back();
    }

    public function delete_cart(Request $request,$id) {
        $cart=Cart::find($id);
        $cart->delete();
        session()->flash('success', 'deleted successfully');
        return redirect()->back();
    }

    public function update_cart(Request $request,$id) {
        // return $request;
        $cart=Cart::find($id);
        $product=\App\Product::find($cart->product_id); 
        if($request->num_product > $product->number){
            session()->flash('error', 'the free from this product is '.$product->number);
            return redirect()->back();
        }else{ 
            $x=0;
            if(count($product->productoffers)){
                foreach($product->productoffers as $offer){
                    if(  $offer->from <= $request->num_product && $offer->to >= $request->num_product || $offer->from >= $request->num_product && $offer->to <= $request->num_product){
                        $total_of_price_product      = $request->num_product * $offer->price;
                        $price_of_product=$offer->price;
                    $x=1;
                    break;
                    }
                }
                if($x!=1){
                    $prices=[];
                    foreach($product->productoffers as $key => $offer){
                        array_push($prices,$offer->price);
                    }
                    $min_price=min($prices);
                    foreach($product->productoffers as $offer){
                        if(  $offer->from < $request->num_product && $offer->to < $request->num_product ){
                            $total_of_price_product      = $request->num_product * $min_price;
                            $price_of_product=$offer->price;
                        $x=1;
                        break;
                        }
                    }
                }
            }
            if($x!=1){
                if($product->sale){
                    $total_of_price_product =($product->price * (100-$product->sale)/100) * $request->num_product;
                    $price_of_product=($product->price * (100-$product->sale)/100);
                }else{
                    $total_of_price_product = $product->price * $request->num_product;
                    $price_of_product=$product->price;
                }
                
            }
            // return $total_of_price_product;
            $in_dollar_currency =\App\Currency::find($product->currency_id);

            $cart->total_of_price_product  =$total_of_price_product/$in_dollar_currency->contain_in_dollar;
            $cart->price_of_product        =$price_of_product/$in_dollar_currency->contain_in_dollar;
            $cart->quantity_of_product = $request->num_product;
            $cart->save();
        }
        session()->flash('success', 'updated cart succefully');
        return redirect()->route('cart');
    }

    public function create_order(Request $request) {
        // return $request;
        $user=\App\User::find(Auth()->user()->id);
        if(count($request->cartorder)){
            if($request->method_pay == "cash"){
                if($user->active_points < $request->pending_points){
                    session()->flash('error', 'you must have at least'.$request->pending_points);
                    return redirect()->back();
                }
                foreach($request->cartorder as $cart_id){
                    $cart=Cart::find($cart_id);
                    $product=\App\Product::find($cart->product_id);
                    $position=\App\Position::find($product->position_id);
                    $currency=\App\Currency::where('short_code','USD')->firstOrFail();
                    if($cart->quantity_of_product > $product->number){
                        session()->flash('error', 'quantity over');
                        return redirect()->back();
                    }

                    $order                          = new Order;
                    $order->quantity                = $cart->quantity_of_product;
                    $order->user_id                 = $user->id;
                    $order->product_id              = $product->id;
                    $order->method_pay              = 'cash';
                    $order->price_of_product        = $cart->price_of_product;
                    $order->total_of_price_product  = $cart->total_of_price_product;
                    $order->currency_id             = $currency->id;
                    $order->position                = $position->name;
                    $order->status                  = 'pending';
                    if( isset($cart->color) && isset($cart->size) ){
                        $order->size                = $cart->size;
                        $order->color               = $cart->color;
                    }elseif( isset($cart->color) ){
                        $order->color               = $cart->color;
                    }elseif( isset($cart->size) ){
                        $order->size                = $cart->size;
                    }
                    $order->save();

                    $user->active_points -=  $product->number_of_pending_points_to_pay_cash;
                    $user->pending_points +=  $product->number_of_pending_points_to_pay_cash;
                    $user->save();

                    $archive_point= new Archivepoint;
                    $archive_point->user_id=$user->id;
                    $archive_point->{'description:ar'}           = 'تم تعليق '.$product->number_of_pending_points_to_pay_cash.'  نقطة لشرائك كاش '.$cart->quantity_of_product.' منتجات من  '. $product->{'name:ar'};
                    $archive_point->{'description:en'}           = 'we pending ' .$product->number_of_pending_points_to_pay_cash. ' point because you buy by cash' .$cart->quantity_of_product. 'products from '.$product->{'name:en'};
                    $archive_point->{'description:ur'}           = 'we pending ' .$product->number_of_pending_points_to_pay_cash. ' point because you buy by cash' .$cart->quantity_of_product. 'products from '.$product->{'name:en'};
                    $archive_point->save();

                    $product->number -= $cart->quantity_of_product;
                    $product->save();
                    $cart->delete();
                }
        
                session()->flash('success', 'deduct ' .$request->pending_points);
                return redirect()->back();

            }elseif($request->method_pay == "points"){
                if($user->active_points < $request->num_of_points){
                    session()->flash('error', 'you must have at least '.$request->num_of_points.' point');
                    return redirect()->back();
                }
                foreach($request->cartorder as $cart_id){
                    $cart=Cart::find($cart_id);
                    // return $cart;
                    $product=\App\Product::find($cart->product_id);
                    $position=\App\Position::find($product->position_id);
                    $currency=\App\Currency::where('short_code','USD')->firstOrFail();
                    if($cart->quantity_of_product > $product->number){
                        session()->flash('error', 'quantity over');
                        return redirect()->back();
                    }
                    
                    $order=new Order;
                    $order->quantity                =  $cart->quantity_of_product;
                    $order->user_id                 =  $user->id;
                    $order->product_id              =  $product->id;
                    $order->method_pay              = 'points';
                    $order->price_of_product        =  $cart->price_of_product;
                    $order->total_of_price_product  = $cart->total_of_price_product;
                    $order->currency_id             = $currency->id;
                    $order->position                = $position->name;
                    $order->status                  = 'pending';
                    if( isset($cart->color) && isset($cart->size) ){
                        $order->size                = $cart->size;
                        $order->color               =$cart->color;
                    }elseif( isset($cart->color) ){
                        $order->color               =$cart->color;
                    }elseif( isset($cart->size) ){
                        $order->size                = $cart->size;
                    }
                    $order->save();
                    $points_suspend = $cart->total_of_price_product / $request->point_in_dollar;
       
                    $user->active_points -=  $points_suspend;
                    $user->pending_points +=  $points_suspend;
                    $user->save();

                    $archive_point= new Archivepoint;
                    $archive_point->user_id=$user->id;
                    $archive_point->{'description:ar'}           = 'تم تعليق '.$points_suspend.'  نقطة لشرائك بالنقاط '.$cart->quantity_of_product.' منتجات من  '. $product->{'name:ar'};
                    $archive_point->{'description:en'}           = 'we pending ' .$points_suspend. ' point because you buy by points ' .$cart->quantity_of_product. 'products from '.$product->{'name:en'};
                    $archive_point->{'description:ur'}           = 'we pending ' .$points_suspend. ' point because you buy by points ' .$cart->quantity_of_product. 'products from '.$product->{'name:en'};
                    $archive_point->save();

                    $product->number -= $cart->quantity_of_product;
                    $product->save();
                    $cart->delete();
                }
            
                session()->flash('success', 'deduct ' .$request->num_of_points);
                return redirect()->back();
            }
        }
        return $request;
    }
}
