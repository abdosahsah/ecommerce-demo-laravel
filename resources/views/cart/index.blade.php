@extends('layouts.master')

{{-- Meta CSRF --}}
@section('meta-csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<div class="container">
    <div class="row my-3">

     <div class="col-md-12 my-2">
         
        @if (Cart::count() > 0)
        
        @if (session('success'))
        <div class="alert alert-dismissible alert-info">
          <p>{{ session('success') }}</p>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-dismissible alert-danger">
          <p>{{ session('error') }}</p>
        </div>
        @endif

        {{-- Cart section --}}
        <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Remove</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($cart as $product)
              <tr>

                <th scope="row">
                    <div class="d-flex">
                        <img src="{{ $product->model->image }}" width="65">
                        <h5 class="mx-2">{{ $product->name }}</h5>
                    </div>
                </th>

                <td>${{ $product->subtotal() }}</td>

                {{-- <td>{{ $product->qty }}</td> --}}
                <td>
                  <select name="qty" data-id="{{ $product->rowId }}" class="form-select" id="product-qty">
                    @for ($i = 1; $i <= 10; $i++)
                      <option value="{{ $i }}" {{ $i == $product->qty ? 'selected' : '' }}>
                        {{ $i }}
                      </option>
                    @endfor 
                  </select>
                </td>

                <td>
                    <form action="{{ route('cart.destroy', $product->rowId) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
                
              </tr>
              @endforeach
              
            </tbody>
          </table>
            
        @else

        {{-- Alert empty cart --}}
         <div class="alert alert-dismissible alert-secondary">
            <p>Your shopping cart is empty. <a href="{{ route('store.index') }}">Go back to store</a></p>
          </div>

        @endif

     </div>

     {{-- Coupon code section --}}
     <div class="col-md-5 ml-1 my-2">

        <div class="card border-secondary mb-3" style="max-width: 20rem;">
            <div class="card-header">Coupon code</div>
            <div class="card-body">
              <p class="card-text">
                  If you have a coupon code please enter it in the below box.
              </p>
              <div>
                <input type="text" name="coupon" placeholder="Apply coupon" style="width: 100%">
                <input type="submit" value="Apply coupon" class="btn btn-dark my-2" style="width: 100%">
            </div>
            </div>
          </div>

     </div>

     <div class="col-md-7 ml-1 my-1">

        {{-- Order summary section --}}
        @if (Cart::count() > 0)

        <div class="card border-secondary mb-3" style="max-width: 20rem;">
            <div class="card-header">Order summary</div>
            <div class="card-body">
              <p class="card-text">
                  Total cost of your products
              </p>
               
              <ul class="list-group">

                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <p>Order subtotal</p>
                    <strong>${{ Cart::subtotal() }}</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <p>Shipping</p>
                    <strong>$0</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <p>Tax</p>
                    <strong>${{ Cart::tax() }}</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Total</strong>
                    <h5><strong>${{ Cart::total() }}</strong></h5>
                </li>

              </ul>

                  <a href="{{ route('checkout.index') }}">
                    <input 
                        type="submit" 
                        value="Procceed to checkout" 
                        class="btn btn-dark my-2"
                        style="width: 100%">
                  </a>

            </div>
          </div>
         
        @else
        {{-- Order summary empty cart --}}
        <div class="card border-secondary mb-3" style="max-width: 20rem;">
            <div class="card-header">Order summary</div>
            <div class="card-body">
              <p class="card-text">
                  Total cost of your products
              </p>
               
              <ul class="list-group">

                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Total</strong>
                    <strong>$0</strong>
                </li>

              </ul>

            </div>
          </div>
        @endif
     </div>

    </div>
</div>

@endsection

@section('extra_js_code')

  <script>

    var productQty = document.querySelectorAll('#product-qty');

    Array.from(productQty).forEach((element) => {

      var rowId = element.getAttribute('data-id');
      var url = `/shoppingcart/${rowId}`;
      var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      addEventListener('change', () => {

        fetch(
        url,
        {
          method: 'put',
          headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": token
                    },
          body: JSON.stringify({
            qty: element.value
          }),
        }
      )
      .then((data) => {
        console.log(data);
        window.location.reload();
      })
      .catch((error) => {
        console.log(error);
      })

      })

    })    

  </script>
    
@endsection