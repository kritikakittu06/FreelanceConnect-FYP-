<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Str;
use Omnipay\Omnipay;


class PaymentController extends Controller
{

    public function __construct()
    {
//        $this->gateway = Omnipay::create('PayPal_Rest'); // Correct gateway name
//        $this->gateway->initialize([
//            'clientId' => env('PAYPAL_CLIENT_ID'), // Use env variables
//            'secret'   => env('PAYPAL_SECRET'),
//            'testMode' => true, // Set to false for live transactions
//        ]);
    }

    public function pay(Request $request)
    {
        try {
            $response = $this->gateway->purchase([
                'amount'    => $request->amount,
                'currency'  => env('PAYPAL_CURRENCY', 'USD'), // Default to USD if not set
                'returnUrl' => route('payment.success'), // Ensure these routes exist
                'cancelUrl' => route('payment.cancel'),
            ])->send(); // ✅ Must call `send()`

           if ($response-> isRedirect()){
            $response->redirect();
           }
           else{
                return  $response ->getMessage();
           }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function success(Request $request)
    {
        try {
            $response = $this->gateway->completePurchase([
                'payer_id' => $request->PayerID,
                'payment_id' => $request->paymentId,
                'token' => $request->token,
                'amount' => $request->amount,
                'currency' => env('PAYPAL_CURRENCY', 'USD'),
            ])->send();

            if ($response->isSuccessful()) {
                return 'Payment was successful!';
            } else {
                return 'Payment was not successful!';
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function cancel()
    {
        return 'User decline the payment!';
    }

    public function error(){
        return 'User decline the payment!';
    }
}
