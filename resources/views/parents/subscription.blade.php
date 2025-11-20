@extends('parents.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white border-0">
                    <h4 class="mb-0">
                        <i class="fas fa-credit-card"></i> Complete Your Subscription
                    </h4>
                </div>

                <div class="card-body p-5">
                    <h5 class="mb-2">{{ $plan->name }} Plan</h5>
                    <p class="text-muted mb-4">{{ $plan->description }}</p>

                    <div class="alert alert-info border-0">
                        <h3 class="mb-0">€{{ number_format($plan->price, 0) }}<small>/month</small></h3>
                    </div>

                    <h6 class="mb-3 font-weight-bold">Plan Includes:</h6>
                    <ul class="mb-4">
                        @foreach($plan->features as $feature)
                            <li class="mb-2">
                                <i class="fas fa-check text-success"></i>
                                <small>{{ $feature }}</small>
                            </li>
                        @endforeach
                    </ul>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#stripeModal">
                                <i class="fas fa-credit-card"></i> Card
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <form action="{{ route('paypal.checkout', $plan) }}" method="POST" class="d-inline w-100">
                                @csrf
                                <button type="submit" class="btn btn-info btn-block">
                                    <i class="fab fa-paypal"></i> PayPal
                                </button>
                            </form>
                        </div>
                    </div>

                    <a href="{{ route('pricing.index') }}" class="btn btn-outline-secondary btn-block mt-3">
                        Back to Pricing
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stripe Modal -->
<div class="modal fade" id="stripeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title">Pay with Card</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="stripe-form">
                @csrf
                <div class="modal-body">
                    <div id="card-element" class="form-control p-3"></div>
                    <div id="card-errors" class="text-danger mt-2"></div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        Pay €{{ number_format($plan->price, 0) }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe('{{ env("STRIPE_PUBLIC_KEY") }}');
const elements = stripe.elements();
const cardElement = elements.create('card');

$('#stripeModal').on('show.bs.modal', function() {
    cardElement.mount('#card-element');
});

$('#stripe-form').on('submit', async function(e) {
    e.preventDefault();

    const { paymentMethod, error } = await stripe.createPaymentMethod({
        type: 'card',
        card: cardElement
    });

    if (error) {
        document.getElementById('card-errors').textContent = error.message;
    } else {
        fetch('{{ route("stripe.checkout", $plan) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ payment_method_id: paymentMethod.id })
        })
        .then(r => r.json())
        .then(data => {
            window.location.href = '{{ route("stripe.success", $plan) }}?payment_intent=' + data.client_secret;
        });
    }
});
</script>
@endsection