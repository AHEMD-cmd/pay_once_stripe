<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __invoke(Request $request)
    {

        if (!session()->has('payment_intent_id')) {
            $paymentIntent = app('stripe')->paymentIntents->create([
                'amount' => 10000,
                'currency' => 'usd',
                'setup_future_usage' => 'on_session',
                'metadata' => [
                    'user_id' => (string) Auth::id()
                ]
            ]);

            session()->put('payment_intent_id', $paymentIntent->id);
        } else {

            $paymentIntent = app('stripe')->paymentIntents->retrieve(session()->get('payment_intent_id'));
        
        }

        return view('payments.index', [
            'paymentIntent' => $paymentIntent
        ]);

    }
}
