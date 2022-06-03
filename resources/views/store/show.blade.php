@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row justify-content-center my-3">

        <div class="col-md-3 mx-4 my-2">
            <img src="{{ $product->image }}">
        </div>

        <div class="col-md-5 mx-4 my-2">
            <h2 class="text-primary">{{ $product->title }}</h2>
            <strong>Category</strong>
            <p class="mt-2">{{ $product->description }}</p>
            <h5 class="text-primary"><b>${{ $product->price }}</b></h5>
            <form action="{{ route('cart.store') }}" method="POST" class="my-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button class="btn btn-lg btn-primary" type="submit">Order Now</button>
            </form>
        </div>
</div>
</div>

@endsection