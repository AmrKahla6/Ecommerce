<?php
use App\Cart;
use App\Order;
use App\OrderProduct;

function add_order($request) 
{
    // return $request;
    $request->validate([
        'billing_total'        => 'required|integer',
        'billing_first_name'   => 'required|string|max:255',
        'billing_last_name'    => 'required|string|max:255',
        'billing_email'        => 'required|string|email|max:255',
        'billing_phone'        => 'required|string|max:255',
        'billing_city'         => 'required|string|max:255',
        'billing_province'     => 'required|string|max:255',
        'billing_address'      => 'required|string',
    ]);
    $data = $request->all();
    $user = auth()->user();
    $data['user_id']  = $user->id;
    $order = Order::create($data);
    // $user->orders()->create($data);
    
    foreach ($user->carts as $item) {
        OrderProduct::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity_of_product,
        ]);
    }
    if(isset($request->is_edit) && $request->is_edit == "on"){
        $user->name      = $request->billing_first_name ;
        $user->last_name = $request->billing_last_name ;
        $user->city      = $request->billing_city ;
        $user->province  = $request->billing_province ;
        $user->email     = $request->billing_email ;
        $user->phone     = $request->billing_phone ;
        $user->address   = $request->billing_address ;
        $user->save();
    }

}
?>