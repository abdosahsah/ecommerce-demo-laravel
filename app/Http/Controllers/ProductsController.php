<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    
    public function index()
    {
        // Take 6 products in a random order
        $products = Product::inRandomOrder()->take(6)->get();

        return view('store.index')->with('products', $products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('store.show')->with('product', $product);
    }
}
