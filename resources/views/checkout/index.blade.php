@extends('layouts.master')

{{-- Meta CSRF --}}
@section('meta-csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

{{-- Extra script --}}
@section('extra_script')
    <script src="https://js.stripe.com/v3/"></script>
@endsection

{{-- Content section --}}
@section('content')

<div class="container">
    <div class="row">

        <div class="col-md-12 my-3">

            <h2>Chekout</h2>
            <form method="POST" action="{{ route('checkout.store') }}" id="payment-form">
                @csrf
                <div id="card-element">
                  <!-- Elements will create input elements here -->
                </div>
              
                <!-- We'll put the error messages in this element -->
                <div id="card-errors" role="alert"></div>
              
                <button class="btn btn-success my-3" id="submit" style="width: 100%">Submit Payment</button>
              </form>
        </div>

    </div>
</div>
    
@endsection

{{-- Extra js code section --}}
@section('extra_js_code')
    <script>
        var stripe = Stripe(''); // paste your stripe key
        var elements = stripe.elements();

        var style = {
                base: {
                color: "#32325d",
                    }
                };

        var card = elements.create("card", { style: style });
        card.mount("#card-element");

        card.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
        });

        var form = document.getElementById('payment-form');
        var submitBtn = document.getElementById('submit');

        form.addEventListener('submit', function(ev) {
        ev.preventDefault();
        submitBtn.disabled = true;

        // If the client secret was rendered server-side as a data-secret attribute
        // on the <form> element, you can retrieve it here by calling `form.dataset.secret`
        stripe.confirmCardPayment("{{ $client_secret }}", {
            payment_method: {
            card: card
            }
        }).then(function(result) {
            if (result.error) {
            // Show error to your customer (e.g., insufficient funds)
            console.log(result.error.message);
            submitBtn.disabled = false;
            } else {

            // The payment has been processed!
                if (result.paymentIntent.status === 'succeeded') {

                    // Variables to start our fetch api with post method
                    var paymentIntent = result.paymentIntent;
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    var url = form.action;
                    var redirect = "/successfulpayment";

                    fetch(
                        url,
                        {
                            method: 'post',
                            headers: {
                                    "Content-Type": "application/json",
                                    "Accept": "application/json",
                                    "X-Requested-With": "XMLHttpRequest",
                                    "X-CSRF-Token": token
                        },
                            body: JSON.stringify({
                            paymentIntent: paymentIntent
                        })
                        }
                    ).then((data) => {
                        console.log(data);
                        window.location.href = redirect;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
                }
            }
        });
        });

    </script>
@endsection