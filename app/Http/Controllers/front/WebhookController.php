<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Webhook;

class WebhookController extends Controller
{
    public function handleStripeWebhook(Request $request)
    {
        $endpoint_secret = config('stripe.stripe_webhook_secret') ?? env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Stripe Webhook Error: Invalid Payload', ['error' => $e->getMessage()]);
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Stripe Webhook Error: Invalid Signature', ['error' => $e->getMessage()]);
            return response('Invalid signature', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;
            // ... handle other event types if necessary
            default:
                Log::info('Received unknown event type ' . $event->type);
        }

        return response('Webhook Handled', 200);
    }

    protected function handleCheckoutSessionCompleted($session)
    {
        $order_number = $session->client_reference_id;
        $payment_id = $session->payment_intent ?? $session->id; // Use payment_intent or session ID
        $currency = $session->currency;

        if (!$order_number) {
            Log::error('Stripe Webhook Error: No client_reference_id found in session.');
            return;
        }

        // Update the order in the database
        $orderdata = DB::table('ci_orders')->where('order_number', $order_number)->first();

        if ($orderdata && $orderdata->payment_status != 'Success') {
            DB::table('ci_orders')->where('order_number', $order_number)->update([
                'payment_id' => $payment_id,
                'currency' => $currency,
                'payment_status' => 'Success'
            ]);

            // Call creditCouponWallet (since it's in checkoutcontroller, we might need to instantiate it or copy logic)
            // It's cleaner to instantiate the controller or just duplicate the short logic
            $checkoutController = new \App\Http\Controllers\front\checkoutcontroller();
            $checkoutController->creditCouponWallet($order_number);

            $item = DB::table('ci_order_item')->where('order_id', $order_number)->first();

            // Set session so mail sending functions work (they rely on session unfortunately)
            // Note: Since this is a webhook, Sessions might be isolated, meaning checkoutcontroller's 
            // session-dependent mailers might fail if they explicitly check Session::get('order_number').
            // Let's set it temporarily.
            session(['order_number' => $order_number]);

            // To be totally safe without refactoring their entire mail architecture:
            try {
                $checkoutController->send_success_mail_api();
                $checkoutController->send_vendor_lead_mail_api();
            } catch (\Exception $e) {
                Log::error('Stripe Webhook Mail Error', ['error' => $e->getMessage()]);
            }
        }
    }
}
