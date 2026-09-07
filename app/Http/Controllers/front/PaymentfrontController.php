<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Email;
use App\Models\Admin\City;
use App\Models\Admin\Service;
use App\Models\Admin\Subservice;
use App\Models\Admin\UserPermission;
use Illuminate\Support\Facades\Hash;
use App\Models\front\Frontloginregister;
use DB;
use Illuminate\Support\Facades\Response;
use Helper;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;
use Str;
use Illuminate\Support\Facades\URL;

use Stripe\Stripe;

class PaymentfrontController extends Controller
{

    function paymentstripe($id)
    {

        $inquiry_id_decode = base64_decode($id);
        $accept_inquiry = DB::table('erp_enquiry')->where('id', $inquiry_id_decode)->first();
        // $amount_decode = round($accept_inquiry->grand_total);
        $amount_decode = round($accept_inquiry->grand_total);

        if ($accept_inquiry->payment_status === 'paid') {
            abort(404);
            //return redirect()->route('quotepayment.already')
            //->with('message', 'This inquiry is already paid.');
        }

        $customerName = $accept_inquiry->client_name;
        $customerEmail = $accept_inquiry->client_email;

        Stripe::setApiKey(env('STRIPE_SK'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'aed',
                    'product_data' => [
                        'name' => 'Quotation Payment',
                    ],
                    'unit_amount' => $amount_decode * 100, // amount in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('quotepayment.success')
                . '?id=' . $id
                . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('quotepayment.cancel'),
        ]);

        return redirect($session->url);
        //echo $response_url;exit;
    }
    function paymentsuccess(Request $request)
    {

        Stripe::setApiKey(env('STRIPE_SK'));

        $inquiry_id_decode = base64_decode($request->get('id'));

        $session = \Stripe\Checkout\Session::retrieve($request->get('session_id'));
        $paymentIntentId = $session->payment_intent;

        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

        DB::table('erp_enquiry')
            ->where('id', $inquiry_id_decode)
            ->update([
                'payment_status' => 'paid',
                'stripe_session_id' => $session->id,
                'stripe_payment_intent' => $paymentIntentId,
                'amount' => $paymentIntent->amount_received / 100,
                'currency' => $paymentIntent->currency,
                'status' => $paymentIntent->status,
            ]);

        return view('front.quotepayment.success', compact('session'));
    }

    function paymentcancel()
    {
        return view('front.quotepayment.cancel');
    }
    function paymentalready()
    {
        return view('front.quotepayment.success');
    }

    function paymentstorageorder($id)
    {

        $order_id_decode = base64_decode($id);

        $orderdata = DB::table('ci_orders')->where('order_id', $order_id_decode)->first();

        $user_data = DB::table('frontloginregisters')->where('id', $orderdata->user_id)->first();

        // $accept_inquiry = DB::table('erp_enquiry')->where('id', $inquiry_id_decode)->first();
        // // $amount_decode = round($accept_inquiry->grand_total);
        $amount_decode = $orderdata->order_total;

        if ($orderdata->payment_status === 'paid') {
            abort(404);
            //return redirect()->route('quotepayment.already')
            //->with('message', 'This inquiry is already paid.');
        }

        $customerName = $user_data->name;
        $customerEmail = $user_data->email;

        Stripe::setApiKey(env('STRIPE_SK'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'aed',
                    'product_data' => [
                        'name' => 'Storage order Payment',
                    ],
                    'unit_amount' => $amount_decode * 100, // amount in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('paymentstorageorder.success')
                . '?id=' . $id
                . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('paymentstorageorder.cancel'),
        ]);

        return redirect($session->url);
        //echo $response_url;exit;
    }

    function paymentstorageorder_success(Request $request)
    {

        Stripe::setApiKey(env('STRIPE_SK'));

        $order_id_decode = base64_decode($request->get('id'));

        $orderdata = DB::table('ci_orders')->where('order_id', $order_id_decode)->first();
        $order_items = DB::table('ci_order_item')->where('order_id', $order_id_decode)->get();
        // Assume first item contains storage details
        $storage_item = $order_items->first();

        $session = \Stripe\Checkout\Session::retrieve($request->get('session_id'));
        $paymentIntentId = $session->payment_intent;

        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

        DB::table('ci_orders')
            ->where('order_id', $order_id_decode)
            ->update([
                'payment_status' => 'paid',
                //'stripe_session_id' => $session->id,
                'payment_id' => $paymentIntentId,
                // 'amount' => $paymentIntent->amount_received / 100,
                // 'currency' => $paymentIntent->currency,
                // 'status' => $paymentIntent->status,
            ]);

        DB::table('package_order_amount_attr')
            ->insert([
                'order_id' => $orderdata->format_order_id,
                'vendor_id' => $orderdata->vendor_id,
                'service_id' => $storage_item->service_id,
                'order_total' => $orderdata->order_total,
                'vatcharge' => $orderdata->vatcharge,
                'booking_percentage' => $storage_item->subservice_booking_percentage,
                'add_amount' => $orderdata->order_total,
                'date' => $orderdata->moving_date,
                'order_date' => $orderdata->moving_date,
                'collect_by' => 'Vendorscity',
                'payment_type' => 'Online',
                'added_date' => date('Y-m-d'),
            ]);

        return view('front.quotepayment.success', compact('session'));
    }

    function paymentstorageorder_cancel()
    {
        return view('front.quotepayment.cancel');
    }
}
