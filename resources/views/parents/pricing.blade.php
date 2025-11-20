@extends('parents.master')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4">Choose Your Plan</h1>
        <p class="lead text-muted">Get cutting-edge tools to maximize profits from matched betting, arbitrage, and volume betting.</p>
    </div>

    <div class="row">
        @foreach($plans as $plan)
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm {{ $plan->is_popular ? 'border-primary' : '' }}" 
                     style="{{ $plan->is_popular ? 'border: 3px solid #007bff !important; position: relative;' : '' }}">
                    
                    @if($plan->is_popular)
                        <div class="badge badge-primary position-absolute" style="top: -12px; right: 20px;">
                            Most Popular
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h4 class="card-title mb-2">{{ $plan->name }}</h4>
                        <p class="text-muted small flex-grow-1">{{ $plan->description }}</p>

                        <div class="my-4">
                            <h2 class="mb-0">
                                <span class="text-dark">€{{ number_format($plan->price, 0) }}</span>
                                <span class="text-muted" style="font-size: 0.7em;">/month</span>
                            </h2>
                            @if($plan->price > 0)
                                <small class="text-muted">OR FREE for active BFB247 clients</small>
                            @endif
                        </div>

                        <div class="mb-4">
                            <div class="mb-3">
                                <small class="text-muted d-block"><strong>✓ {{ $plan->bookmakers_count }} Bookmakers</strong></small>
                                <small class="text-muted d-block"><strong>✓ {{ $plan->markets_count }} Markets</strong></small>
                                <small class="text-muted d-block"><strong>✓ {{ $plan->leagues_count }} Leagues</strong></small>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-4">
                            @foreach($plan->features as $feature)
                                <li class="mb-2">
                                    <i class="fas fa-check text-success"></i>
                                    <span class="small">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>

                        @if($userSubscription && $userSubscription->plan_id === $plan->id)
                            <button class="btn btn-secondary btn-block" disabled>
                                <i class="fas fa-check"></i> Current Plan
                            </button>
                        @elseif($plan->price == 0)
                            <form action="{{ route('subscribe', $plan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-block">
                                    Get Started
                                </button>
                            </form>
                        @else
                            <button class="btn btn-primary btn-block mb-2" data-toggle="modal" 
                                    data-target="#paymentModal" data-plan-id="{{ $plan->id }}" 
                                    data-plan-name="{{ $plan->name }}" data-plan-price="{{ $plan->price }}">
                                <i class="fas fa-credit-card"></i> Upgrade with Card
                            </button>
                            <form action="{{ route('paypal.checkout', $plan->id) }}" method="POST" class="d-inline w-100">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-block">
                                    <i class="fab fa-paypal"></i> Pay with PayPal
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title">
                    <span id="modalPlanName"></span> - €<span id="modalPlanPrice"></span>/month
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div id="card-element" class="form-control p-3" style="height: 40px; background: white;"></div>
                <div id="card-errors" class="text-danger mt-3"></div>
            </div>

            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="submit-btn" class="btn btn-primary">
                    <i class="fas fa-lock"></i> Pay Securely
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }

    .badge {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }
</style>

<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe('{{ env("STRIPE_PUBLIC_KEY") }}');
const elements = stripe.elements();
let cardElement = null;
let selectedPlanId = null;

$('#paymentModal').on('show.bs.modal', function(e) {
    const button = $(e.relatedTarget);
    selectedPlanId = button.data('plan-id');
    const planName = button.data('plan-name');
    const planPrice = button.data('plan-price');
    
    $('#modalPlanName').text(planName);
    $('#modalPlanPrice').text(planPrice);

    if (!cardElement) {
        cardElement = elements.create('card');
        cardElement.mount('#card-element');
        
        cardElement.addEventListener('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
    }
});

$('#submit-btn').on('click', async function(e) {
    e.preventDefault();
    
    const button = $(this);
    button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

    const { paymentMethod, error } = await stripe.createPaymentMethod({
        type: 'card',
        card: cardElement
    });

    if (error) {
        document.getElementById('card-errors').textContent = error.message;
        button.prop('disabled', false).html('<i class="fas fa-lock"></i> Pay Securely');
    } else {
        // Send to server
        fetch('{{ url("payment/stripe") }}/' + selectedPlanId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                payment_method_id: paymentMethod.id
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.client_secret) {
                window.location.href = '{{ url("payment/stripe/success") }}/' + selectedPlanId + '?payment_intent=' + data.client_secret;
            } else {
                document.getElementById('card-errors').textContent = data.error;
                button.prop('disabled', false).html('<i class="fas fa-lock"></i> Pay Securely');
            }
        })
        .catch(err => {
            document.getElementById('card-errors').textContent = 'An error occurred. Please try again.';
            button.prop('disabled', false).html('<i class="fas fa-lock"></i> Pay Securely');
        });
    }
});
</script>
@endsection