@extends('layouts.master')

@section('slider')

    @if (session('alertmessage'))
    <div class="alert alert-dismissible alert-info">
      <p>{{ session('alertmessage') }}</p>
    </div>
    @endif

    {{-- @include('layouts.slider') --}}
@endsection

@section('content')

<h2 class="my-2">Latest Products</h2>

<div class="row justify-content-center">
  
   @if ($products)
      @foreach ($products as $product)

      <div class="col-lg-4 my-3">
        <div class="card" style="width: 12rem;">
          <img src="https://via.placeholder.com/50x50" class="card-img-top">
          <div class="card-body">
            <h5 class="card-title text-primary">{{ $product->title }}</h5>
            <b>Category</b>
            <div>
              <strong class="text-primary"><small>$</small>{{ $product->price }}</strong>
            </div>
            <p class="card-text">{{ $product->subtitle }}</p>
            <a href="{{ route('store.show', $product->slug) }}" class="btn btn-primary" style="width: 100%">More info</a>
          </div>
        </div>
      </div>

      @endforeach
   @else
       <div class="col-4 my-3">No products</div>
   @endif

</div>
      
@endsection