<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function process(Order $order)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $order->total_amount * 100, // Stripe utilise les centimes
                'currency' => 'eur',
                'metadata' => [
                    'order_id' => $order->id
                ]
            ]);

            return view('payments.process', [
                'clientSecret' => $paymentIntent->client_secret,
                'order' => $order
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'initialisation du paiement');
        }
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $request->getContent(),
                $sig_header,
                $endpoint_secret
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;
            $orderId = $paymentIntent->metadata->order_id;

            $order = Order::findOrFail($orderId);
            $order->update(['payment_status' => 'PAID']);

            Payment::create([
                'order_id' => $orderId,
                'amount' => $paymentIntent->amount / 100,
                'provider' => 'stripe',
                'status' => 'COMPLETED',
                'transaction_id' => $paymentIntent->id
            ]);
        }

        return response()->json(['status' => 'success']);
    }
}
