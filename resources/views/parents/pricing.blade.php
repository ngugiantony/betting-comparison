@extends('parents.master')

@section('content')
<style>
    .pricing-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
        padding: 4rem 0;
    }
    
    .pricing-wrapper::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-20px, -20px); }
    }
    
    .pricing-header {
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
        z-index: 1;
    }
    
    .pricing-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 1rem;
    }
    
    .pricing-header p {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
        max-width: 600px;
        margin: 0 auto;
    }
    
    .pricing-card {
        background: rgba(255, 255, 255, 0.95);
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        transition: all 0.4s ease;
        overflow: visible;
        position: relative;
        height: 100%;
    }
    
    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
    }
    
    .pricing-card.popular {
        border: 3px solid #ffd700;
        transform: scale(1.05);
    }
    
    .pricing-card.popular:hover {
        transform: scale(1.05) translateY(-10px);
    }
    
    .popular-badge {
        position: absolute;
        top: -15px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #ffd700 0%, #ffa500 100%);
        color: #2d3748;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
        z-index: 10;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .plan-name {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }
    
    .plan-description {
        color: #718096;
        font-size: 0.95rem;
        line-height: 1.6;
        min-height: 60px;
    }
    
    .pricing-section {
        text-align: center;
        padding: 2rem 0;
        border-top: 2px solid #e2e8f0;
        border-bottom: 2px solid #e2e8f0;
        margin: 1.5rem 0;
    }
    
    .price-amount {
        font-size: 3rem;
        font-weight: 800;
        color: #667eea;
        line-height: 1;
    }
    
    .price-currency {
        font-size: 1.5rem;
        vertical-align: super;
    }
    
    .price-period {
        font-size: 1rem;
        color: #718096;
        font-weight: 500;
    }
    
    .free-note {
        display: block;
        margin-top: 0.75rem;
        font-size: 0.85rem;
        color: #667eea;
        font-weight: 600;
    }
    
    .plan-stats {
        display: flex;
        justify-content: space-around;
        margin: 1.5rem 0;
        padding: 1rem;
        background: #f7fafc;
        border-radius: 10px;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-number {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: #667eea;
    }
    
    .stat-label {
        display: block;
        font-size: 0.8rem;
        color: #718096;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .features-list {
        list-style: none;
        padding: 0;
        margin: 1.5rem 0;
    }
    
    .feature-item {
        padding: 0.75rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.95rem;
        color: #4a5568;
    }
    
    .feature-icon {
        width: 24px;
        height: 24px;
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
        flex-shrink: 0;
    }
    
    .btn-plan {
        width: 100%;
        padding: 1rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        border: none;
        margin-bottom: 0.75rem;
    }
    
    .btn-primary-plan {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-primary-plan:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }
    
    .btn-outline-plan {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
    }
    
    .btn-outline-plan:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-current {
        background: #e2e8f0;
        color: #718096;
        cursor: not-allowed;
    }
    
    .btn-free {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(72, 187, 120, 0.4);
    }
    
    .btn-free:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(72, 187, 120, 0.6);
    }
    
    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border: none;
    }
    
    .modal-header .close {
        color: white;
        opacity: 1;
        text-shadow: none;
    }
    
    .modal-body {
        padding: 2rem;
    }
    
    #card-element {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    
    #card-element:focus-within {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    #card-errors {
        margin-top: 1rem;
        font-size: 0.9rem;
    }
    
    .modal-footer {
        padding: 1.5rem;
        border: none;
        background: #f7fafc;
    }
    
    @media (max-width: 992px) {
        .pricing-card.popular {
            transform: scale(1);
        }
        
        .pricing-card.popular:hover {
            transform: translateY(-10px);
        }
    }
</style>

<div class="pricing-wrapper">
    <div class="container">
        <div class="pricing-header">
            <h1>Choose Your Plan</h1>
        </div>

        <div class="row">
            @foreach($plans as $plan)
                <div class="col-lg-4 mb-4">
                    <div class="pricing-card {{ $plan->is_popular ? 'popular' : '' }}">
                        
                        @if($plan->is_popular)
                            <div class="popular-badge">
                                ⭐ Most Popular
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h4 class="plan-name mt-2">{{ $plan->name }}</h4>
                            {{-- <p class="plan-description">{{ $plan->description }}</p> --}}

                            <div class="pricing-section mt-n4">
                                <div class="price-amount">
                                    <span class="price-currency">€</span>{{ number_format($plan->price, 0) }}
                                    <span class="price-period">/month</span>
                                </div>
                               
                            </div>

                            <div class="plan-stats">
                                <div class="stat-item">
                                    <span class="stat-number">{{ $plan->bookmakers_count }}</span>
                                    <span class="stat-label">Bookmakers</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">{{ $plan->markets_count }}</span>
                                    <span class="stat-label">Markets</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">{{ $plan->leagues_count }}</span>
                                    <span class="stat-label">Leagues</span>
                                </div>
                            </div>

                            <ul class="features-list">
                                @foreach($plan->features as $feature)
                                    <li class="feature-item">
                                        <div class="feature-icon">✓</div>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <div style="margin-top: auto;">
                                @if($userSubscription && $userSubscription->plan_id === $plan->id)
                                    <button class="btn btn-plan btn-current" disabled>
                                        <i class="fas fa-check"></i> Current Plan
                                    </button>
                                @elseif($plan->price == 0)
                                    <form action="{{ route('subscribe', $plan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-plan btn-free">
                                            Get Started Free
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-plan btn-primary-plan" data-toggle="modal" 
                                            data-target="#paymentModal" data-plan-id="{{ $plan->id }}" 
                                            data-plan-name="{{ $plan->name }}" data-plan-price="{{ $plan->price }}">
                                        <i class="fas fa-credit-card"></i> Upgrade with Card
                                    </button>
                                    <form action="{{ route('paypal.checkout', $plan->id) }}" method="POST" class="d-inline w-100">
                                        @csrf
                                        <button type="submit" class="btn btn-plan btn-outline-plan">
                                            <i class="fab fa-paypal"></i> Pay with PayPal
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-credit-card"></i>
                    <span id="modalPlanName"></span> - €<span id="modalPlanPrice"></span>/month
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div id="card-element"></div>
                <div id="card-errors" class="text-danger"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="submit-btn" class="btn btn-primary-plan">
                    <i class="fas fa-lock"></i> Pay Securely
                </button>
            </div>
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
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
        cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#2d3748',
                    '::placeholder': {
                        color: '#a0aec0'
                    }
                }
            }
        });
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