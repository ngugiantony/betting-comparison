<?php
namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class SubscriptionController extends Controller
{
    // STRIPE PAYMENT
    public function stripeCheckout(Request $request, PricingPlan $plan)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $amount = $plan->price * 100; // Convert to cents

        try {
            $intent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'eur',
                'metadata' => [
                    'plan_id' => $plan->id,
                    'user_id' => auth()->id()
                ]
            ]);

            return response()->json([
                'client_secret' => $intent->client_secret
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function stripeSuccess(Request $request, PricingPlan $plan)
    {
        $user = auth()->user();

        // Cancel existing subscriptions
        $user->subscriptions()
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        // Create new subscription
        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'active',
            'started_at' => now(),
            'ends_at' => now()->addMonth(),
            'stripe_id' => $request->payment_intent
        ]);

        return redirect('dashboard')->with('success', 'Subscription activated!');
    }

    // PAYPAL PAYMENT
    public function paypalCheckout(Request $request, PricingPlan $plan)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        try {
            $response = $provider->createOrder([
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => 'EUR',
                            'value' => $plan->price
                        ],
                        'description' => "{$plan->name} Plan - Monthly"
                    ]
                ],
                'return_url' => route('paypal.return', $plan),
                'cancel_url' => route('paypal.cancel')
            ]);

            if (isset($response['id'])) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect($link['href']);
                    }
                }
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function paypalReturn(Request $request, PricingPlan $plan)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $token = $request->query('token');

        try {
            $response = $provider->capturePaymentOrder($token);

            if ($response['status'] == 'COMPLETED') {
                $user = auth()->user();

                $user->subscriptions()
                    ->where('status', 'active')
                    ->update(['status' => 'cancelled']);

                Subscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'status' => 'active',
                    'started_at' => now(),
                    'ends_at' => now()->addMonth(),
                    'paypal_id' => $response['id']
                ]);

                return redirect('dashboard')->with('success', 'Subscription activated!');
            }
        } catch (\Exception $e) {
            return redirect('pricing')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function paypalCancel()
    {
        return redirect('pricing')->withErrors(['error' => 'Payment cancelled']);
    }

    public function cancel(Subscription $subscription)
    {
        if ($subscription->user_id !== auth()->id()) {
            abort(403);
        }

        $subscription->cancel();
        return back()->with('success', 'Subscription cancelled');
    }
}
