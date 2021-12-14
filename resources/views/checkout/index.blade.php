@extends('layouts.master')

@section('extra-meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('extra-script')
<script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
    <div class="col-md-12">
        <h1>paiement</h1>
        <div class="row">
            <div class="col-md-6">
<form action="{{ route('checkout.store')}}" method="POST" class="my-4" id="payment_form">
              @csrf
    <div id="card-element">

                    </div>
                    <div id="card-errors" role="alert"></div>

                    <button class="btn btn-success mt-3" id="submit">Procéder au paiement ({{ getPrice($total )}})</button>
</form>
            </div>
        </div>
</div>

<div>
<h1>Paypale paiment </h1>
<form action="#" method="POST" class="my-4" id="payment_form">
    @csrf
<div id="card-element">

          </div>
          <div id="card-errors" role="alert"></div>

          <button class="btn btn-success mt-3" id="submit">Procéder au paiement ({{ getPrice($total )}})</button>
</form>
</div>
@endsection

@section('extra-js')
<script>
//paypal



//stripe
    var stripe = Stripe('pk_test_51I0To3D8dPNMnDC3v0nWIEoWRmVyQK3l63ZRzeNByHGwAVFEHCUjUTYYZN3IN7JfLWktT96In8gwJ2vKK6Mb6T3b00EH8rLbAc');
    var elements = stripe.elements();
    var style = {
        base: {
        color: "#32325d",
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: "antialiased",
        fontSize: "16px",
        "::placeholder": {
            color: "#aab7c4"
        }
        },
        invalid: {
        color: "#fa755a",
        iconColor: "#fa755a"
        }
    };
    var card = elements.create("card", { style: style });
    card.mount("#card-element");
    card.addEventListener('change', ({error}) => {
    const displayError = document.getElementById('card-errors');
        if (error) {
            displayError.classList.add('alert', 'alert-warning', 'mt-3');
            displayError.textContent = error.message;
        } else {
            displayError.classList.remove('alert', 'alert-warning', 'mt-3');
            displayError.textContent = '';
        }
    });
    var submitButton = document.getElementById('submit');
    submitButton.addEventListener('click', function(ev) {
    ev.preventDefault();
    submitButton.disabled = true;
    stripe.confirmCardPayment("{{ $clientSecret }}", {
        payment_method: {
            card: card
        }
        }).then(function(result) {
            if (result.error) {
                submitButton.disabled = false;
            // Show error to your customer (e.g., insufficient funds)
            console.log(result.error.message);
            } else {
                // The payment has been processed!
                if (result.paymentIntent.status === 'succeeded') {
                    var paymentIntent = result.paymentIntent;
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    var form = document.getElementById('payment_form');
                    var url = form.action;

                    fetch(
                        url,
                        {
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json, text-plain, */*",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-TOKEN": token
                            },
                            method: 'post',
                            body: JSON.stringify({
                                paymentIntent: paymentIntent
                            })
                        }).then((data) => {
                            if(data.status === 400){
                                var redirect = '/site';
                            }
                            else{
                                var redirect = '/merci';
                            }
                           // console.log(data);
                            //form.reset();
                            window.location.href = redirect;
                    }).catch((error) => {
                        console.log(error)
                    })
                }

            }
        });
    });
</script>
@endsection
