<?php
namespace App\Http\Controllers;

use App\Models\PricingPlan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $plans = PricingPlan::orderBy('price')->get();
        $userSubscription = null;

        if (auth()->check()) {
            $userSubscription = auth()->user()->subscriptions()
                ->where('status', 'active')
                ->where('ends_at', '>', now())
                ->first();
        }

        return view('parents.pricing', compact('plans', 'userSubscription'));
    }

    public function subscribe(Request $request, PricingPlan $plan)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
      
        // Free plan - instant subscription
        if ($plan->price == 0) {
            Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'status' => 'active',
                'started_at' => now(),
                'ends_at' => now()->addMonth()
            ]);

            return redirect('dashboard')->with('success', 'Welcome to Free plan!');
        }

        // Paid plans - redirect to checkout
        return view('parents.subscription', compact('plan'));
    }
}