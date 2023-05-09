<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMAail;
use App\Models\User;



class StripeController extends Controller
{
    public function StripeOrder(Request $request){

        if(Session::has('coupon')){
            $total_amount = Session::get('coupon')['total_amount'];
        }else{
            $total_amount = round(Cart::total());
        }

        \Stripe\Stripe::setApiKey('sk_test_51MyaHSG5qP0t8377h2GzG7PvdWA4DZ3KAWfw3QPrhYLPNfc02P34Tfq34qtsr2poR5Pwd4MtnEN2MZCbeH8csMkl00n1Oy4xZs');


        $token = $_POST['stripeToken'];

        $charge = \Stripe\Charge::create([
            'amount' => $total_amount*100,
            'currency' => 'usd',
            'description' => 'Easy  Shop',
            'source' => $token,
            'metadata' => ['order_id' => uniqid()],
        ]);

        //dd($charge);

        $order_id = Order::insertGetId([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'zipcode' => $request->zipcode,
            'city' => $request->city,
            'country' => $request->country,
            'phone' => $request->phone,
            'address' => $request->address,
            'notes' => $request->notes,

            'payment_type' => $charge->payment_method,
            'payment_method' => 'Stripe',
            'transaction_id' => $charge->balance_transaction,
            'currency' => $charge->currency,
            'amount' => $total_amount,

            'order_number' => $charge->metadata->order_id,

            'invoice_no' => 'EOS'.mt_rand(10000000,99999999),
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'),
            'status' => 'pending',
            'created_at' => Carbon::now(),

        ]);

        // Start Send Email

        $invoice = Order::findOrFail($order_id);

        $data = [

            'invoice_no' => $invoice->invoice_no,
            'amount' => $total_amount,
            'name' => $invoice->name,
            'email' => $invoice->email,

        ];

        Mail::to($request->email)->send(new OrderMAail($data));

        // End Send Email


        $carts = Cart::content();
        foreach($carts as $cart){

            OrderItem::insert([
                'order_id' => $order_id,
                'product_id' => $cart->id,
                'color' => $cart->options->color,
                'size' => $cart->options->size,
                'amount' => $total_amount,
                'qty' => $cart->qty,
                'price' => $cart->price,
                'created_at' =>Carbon::now(),

            ]);

        } // End Foreach

        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        Cart::destroy();

        $notification = array(
            'message' => 'Your Order Place Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('dashboard')->with($notification);



    }// End Method




    public function CashOrder(Request $request){

        $user = User::where('role','admin')->get();

        if(Session::has('coupon')){
            $total_amount = Session::get('coupon')['total_amount'];
        }else{
            $total_amount = round(Cart::total());
        }


        $order_id = Order::insertGetId([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'username' => $request->username,
            'zipcode' => $request->zipcode,
            'city' => $request->city,
            'country' => $request->country,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'notes' => $request->notes,

            'payment_type' => 'Cash On Delivery',
            'payment_method' => 'Cash On Delivery',

            'currency' => 'Usd',
            'amount' => $total_amount,


            'invoice_no' => 'EOS'.mt_rand(10000000,99999999),
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'),
            'status' => 'pending',
            'created_at' => Carbon::now(),

        ]);



        // Start Send Email

        $invoice = Order::findOrFail($order_id);

        $data = [

            'invoice_no' => $invoice->invoice_no,
            'amount' => $total_amount,
            'name' => $invoice->name,
            'email' => $invoice->email,

        ];

        Mail::to($request->email)->send(new OrderMAail($data));

        // End Send Email



        $carts = Cart::content();
        foreach($carts as $cart){

            OrderItem::insert([
                'order_id' => $order_id,
                'product_id' => $cart->id,
                'amount' => $total_amount,
                'color' => $cart->options->color,
                'size' => $cart->options->size,
                'qty' => $cart->qty,
                'price' => $cart->price,
                'created_at' =>Carbon::now(),

            ]);

        } // End Foreach

        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        Cart::destroy();

        $notification = array(
            'message' => 'Your Order Place Successfully',
            'alert-type' => 'success'
        );

//        Notification::send($user, new OrderComplete($request->name));
        return redirect()->route('dashboard')->with($notification);



    }// End Method


}