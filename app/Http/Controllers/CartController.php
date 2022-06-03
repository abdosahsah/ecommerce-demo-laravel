<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart.index', [
            "cart" => Cart::content()
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
        // Get product by id
        $product = Product::findOrFail($request->product_id);
        // Add product to cart
        Cart::add($product->id, $product->title, 1, $product->price)
        ->associate('App\Product');

        return redirect()->route('store.index')->with('alertmessage', 'Your product was added to cart successful!');
    }

    public function update(Request $request, $rowId)
    {
        $data = $request->json()->all();

        Cart::update($rowId, $data['qty']);

        $qtyValidator = Validator::make($request->all(), [
            'qty' => 'required|numeric|between:1,10'
        ]);

        if ($qtyValidator->fails()) {
            Session::flash('error', 'you cannot exceed 10 product');
            return response()->json(['error', 'you cannot exceed 10 product']);
        }
        
        Session::flash('success', 'Cart quantity has been updated');
        return response()->json(['success', 'Cart quantity has been updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);

        return back()->with('alertmessage', 'Your product was deleted successfully!');
    }
}
