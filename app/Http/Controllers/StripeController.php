<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Session;

class StripeController extends Controller
{
    public function showCheckout()
    {
        return view('stripe.checkout');
    }

    public function processPayment(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $charge = Charge::create([
                "amount" => $request->amount * 100, // Convert amount to cents
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Payment from Laravel 8"
            ]);

            Session::flash('success', 'Payment successful!');
            return back();
        } catch (\Exception $e) {
            Session::flash('error', 'Error: ' . $e->getMessage());
            return back();
        }
    }
}
