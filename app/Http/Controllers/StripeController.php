<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function subscribe(Request $request)
    {
        $user = $request->user();

        $paymentMethod = $request->payment_method;

        $user->newSubscription('default', 'price_1TMpPhAZZ9OET5JovNjyO025') // ID du plan Stripe
            ->create($paymentMethod);

        return response()->json(['message' => 'Abonnement actif']);
    }

    public function checkout(Request $request)
    {
        $user = $request->user();

        if ($user->subscribed('default')) {
            return redirect('/dashboard')
                ->with('message', 'Vous êtes déjà abonné !');
        }

        return $user
            ->newSubscription('default', 'price_1TMpPhAZZ9OET5JovNjyO025')
            ->checkout([
                'success_url' => route('dashboard').'?success=1',
                'cancel_url' => route('dashboard').'?cancel=1',
            ]);
    }
}
