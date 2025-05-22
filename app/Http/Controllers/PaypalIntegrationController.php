<?php

namespace App\Http\Controllers;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PaypalTransaction;
class PaypalIntegrationController extends Controller
{


    public function paypal_integration(Request $request)
    {

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();


        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal_integration_success'),
                "cancel_url" => route('paypal_integration_cancel')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "PHP",
                        "value" => '50'
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('paypal_integration_cancel')->with('error', 'Something went wrong');
        }
    }

    public function paypal_integration_success(Request $request)
    {
        $user = User::find(auth()->id());
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
    
        if (!$request->has('token')) {
            return redirect()->route('paypal_integration_cancel')->with('error', 'Token is missing');
        }
    
        $response = $provider->capturePaymentOrder($request->token);
    
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $paymentDetails = $response['purchase_units'][0]['payments']['captures'][0];
            $grossAmount = $paymentDetails['amount']['value'];
            
            // Get PayPal fee from response or calculate if not available
            $paypalFee = $paymentDetails['seller_receivable_breakdown']['paypal_fee']['value'] 
                ?? ($grossAmount * 0.535); // 53.5% fee based on your example (26.75/50.00)
    
            PaypalTransaction::create([
                'user_id' => auth()->id(),
                'transaction_id' => $response['id'],
                'payer_email' => $response['payer']['email_address'] ?? null,
                'payer_name' => $response['payer']['name']['given_name'] ?? null,
                'amount' => $grossAmount,
                'paypal_fee' => $paypalFee,
                'currency' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? 'PHP',
                'status' => $response['status'],
                'paypal_created_at' => $response['create_time'] ?? now(),
            ]);
    
            $user->increment('remaining_votes', 10);
            session()->flash('payment_success', true);
            return redirect()->route('pricing_vote')->with('success', 'Payment successful');
        } else {
            return redirect()->route('paypal_integration_cancel')->with('error', 'Payment cancelled');
        }
    }

    public function paypal_integration_cancel()
    {
        return redirect()->route('paypal_integration_cancel')->with('error', 'Payment cancelled');
    }
}
