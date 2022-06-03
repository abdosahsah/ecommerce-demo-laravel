<?php

namespace App\Http\Controllers;

use App\Order;
use DateTime;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Cart::count() < 1) {
            return redirect()->route('store.index');
        }

        Stripe::setApiKey(''); // paste your stripe key

        $paymentIntent = PaymentIntent::create([
            'amount' => round(Cart::total()),
            'currency' => 'usd'
          ]);

        $client_secret = Arr::get($paymentIntent, 'client_secret');

        return view('checkout.index', [
            'client_secret' => $client_secret
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->json()->all();

        $order = new Order();

        $order->payment_intent_id = $data['paymentIntent']['id'];
        $order->amount = $data['paymentIntent']['amount'];

        $order->payment_ctreated_at = (new DateTime())
            ->setTimestamp($data['paymentIntent']['created'])
            ->format('Y-m-d H:i:s');

        $products = [];
        $i = 0;

        foreach(Cart::content() as $product)
        {
            $products['product_'. $i][] = $product->model->title;
            $products['product_'. $i][] = $product->model->price;
            $products['product_'. $i][] = $product->model->qty;
            $i++;
        }

        $order->products = serialize($products);
        $order->user_id = 1;
        $order->save();

        // Remove items from cart
        if ($data['paymentIntent']['status'] === 'succeeded') {

            Cart::destroy();
            Session::flash('successMessage', 'Your payment was successful');
            return response()->json(['success' => 'Payment intent succeded']);

           }
           else{
               return response()->json(['error' => 'Payment intent failed']);
           }
    }

    public function successfulpayment()
    {
        if (Session::has('successMessage')) 
        {
            return view('checkout.successfulpayment');
        } 
        else {
            return redirect()->route('store.index');
        }
        
    }
}
