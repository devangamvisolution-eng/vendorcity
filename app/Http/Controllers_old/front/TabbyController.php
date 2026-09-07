<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\TabbyService;
use Illuminate\Support\Facades\Log;

class TabbyController extends Controller
{
    protected $tabbyService;

    public function __construct(TabbyService $tabbyService)
    {
        $this->tabbyService = $tabbyService;
    }

    /**
     * Handle successful Tabby redirection
     */
    public function success(Request $request)
    {
        $paymentId = $request->query('payment_id');

        if (!$paymentId) {
            return redirect()->route('payment_fail')->with('error', 'Invalid Payment ID');
        }

        // Retrieve the payment from Tabby to ensure it is valid
        $paymentData = $this->tabbyService->retrievePayment($paymentId);

        if ($paymentData && isset($paymentData['status'])) {
            $status = $paymentData['status'];
            $orderId = $paymentData['order']['reference_id'] ?? null;

            if ($status === 'AUTHORIZED' || $status === 'CLOSED') {
                if ($orderId) {
                    DB::table('ci_orders')
                        ->where('order_id', $orderId)
                        ->update([
                            'payment_status' => 'Success',
                            'payment_provider' => 'TABBY',
                            'transaction_id' => $paymentData['id'],
                            'tabby_payment_id' => $paymentData['id'],
                            'payment_response' => json_encode($paymentData)
                        ]);
                }

                $Order = DB::table('ci_orders')->where('format_order_id', $orderId)->first();
                $OrderItem = DB::table('ci_order_item')->where('order_id', $Order->order_id)->first();
                //echo"<pre>";print_r($OrderItem);die;
                if ($OrderItem->service_id == 45) {
                    return redirect()->route('cleaning.thankyou_book_now');
                } elseif ($OrderItem->service_id == 48) {
                    return redirect()->route('saloon_spa.thankyou_book_now');
                } elseif ($OrderItem->service_id == 34) {
                    return redirect()->route('hanyman.thankyou_book_now');
                } elseif ($OrderItem->service_id == 47) {
                    return redirect()->route('pest_control.thankyou_book_now');
                } else {
                    return redirect('thankyou_book_now');
                }

                // Call the email success functions if needed, normally done here or via webhook
                // (Optional: Re-use mail methods from checkoutcontroller here if needed)

                //return redirect()->route('thank-you');
            }
        }

        // If not authorized/closed
        return redirect()->route('payment_fail')->with('error', 'Payment was not authorized.');
    }

    /**
     * Handle Tabby cancellation
     */
    public function cancel(Request $request)
    {
        return redirect()->route('payment_fail')->with('error', 'Payment was cancelled.');
    }

    /**
     * Handle Webhooks from Tabby
     */
    public function webhook(Request $request)
    {
        // TODO: Validate webhook signature if Tabby provides one in headers

        $payload = $request->all();
        Log::info('Tabby Webhook Received', ['payload' => $payload]);

        $paymentId = $payload['id'] ?? null;
        $status = $payload['status'] ?? null;
        $orderId = $payload['order']['reference_id'] ?? null;

        if ($paymentId && $status && $orderId) {

            $updateData = [
                'payment_response' => json_encode($payload),
                'transaction_id' => $paymentId,
                'tabby_payment_id' => $paymentId,
            ];

            if (in_array($status, ['AUTHORIZED', 'CLOSED'])) {
                $updateData['payment_status'] = 'Success';
            } elseif (in_array($status, ['REJECTED', 'EXPIRED'])) {
                $updateData['payment_status'] = 'FAILED';
            }

            DB::table('ci_orders')
                ->where('order_id', $orderId)
                ->update($updateData);

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'ignored'], 400);
    }

    /**
     * AJAX endpoint to fetch dynamic installment info based on cart amount
     */
    public function fetchInstallments(Request $request)
    {
        $amount = (float) $request->input('amount', 0);
        $currency = $request->input('currency', 'AED');

        // $buyer = [
        //     'name' => $request->input('name', 'Guest User'),
        //     'email' => $request->input('email', 'guest@example.com'),
        //     'phone' => $request->input('phone', '+971500000000'),
        // ];

        // $info = $this->tabbyService->getDisplayInformation($amount, $currency, $buyer);
        $buyer = [
            'name' => $request->input('name', 'Guest User'),
            'email' => $request->input('email', 'guest@example.com'),
            'phone' => $request->input('phone', '+971500000000'),
        ];

        echo "<pre>";
        print_r($buyer);
        exit;

        $info = $this->tabbyService->getDisplayInformation($amount, $currency, $buyer);

        return response()->json($info);
    }
}
