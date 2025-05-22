<?php

namespace App\Http\Controllers;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class PaymentController extends Controller
{
    public function pricing_vote_pay()
    {
        $user = User::find(auth()->id());
        $referenceNumber = 'REF' . time() . $user->id;
    
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'authorization' => 'Basic ' . base64_encode(env('PAYMONGO_SECRET_KEY') . ':'),
            'content-type' => 'application/json',
        ])->post('https://api.paymongo.com/v1/links', [
            'data' => [
                'attributes' => [
                    'amount' => 10000,
                    'description' => 'YOU CAN GET 10 VOTES FOR 100 PESOS',
                    'remarks' => 'Payment for Basic Plan',
                    'reference_number' => $referenceNumber
                ]
            ]
        ]);
    
        if ($response->successful()) {
            $paymentLink = $response->json()['data']['attributes']['checkout_url'];
            
            // ⁡⁣⁣⁢𝘚𝘵𝘰𝘳𝘦 𝘵𝘩𝘦 𝘳𝘦𝘧𝘦𝘳𝘦𝘯𝘤𝘦 𝘯𝘶𝘮𝘣𝘦𝘳 𝘢𝘯𝘥 𝘢𝘥𝘥 10 𝘷𝘰𝘵𝘦𝘴 𝘪𝘮𝘮𝘦𝘥𝘪𝘢𝘵𝘦𝘭𝘺⁡
            $user->payment_reference = $referenceNumber;
            $user->remaining_votes += 10;
            $user->save();
            
            // Log the action
            Log::info("Added 10 votes to user {$user->id} for test payment with reference {$referenceNumber}");
            
            return redirect()->away($paymentLink);
        } else {
            return back()->with('error', 'Unable to create payment link. Please try again.');
        }
    }
    
    public function test_payment_success()
    {
        $user = User::find(auth()->id());
        $user->remaining_votes = ($user->remaining_votes ?? 0) + 10;
        $user->save();
        
        return redirect()->route('vote_contestants')->with('success', 'Payment successful! You now have 10 additional votes.');
    }

    // ⁡⁣⁣⁢𝘈𝘥𝘥 𝘵𝘩𝘪𝘴 𝘯𝘦𝘸 𝘮𝘦𝘵𝘩𝘰𝘥 𝘵𝘰 𝘩𝘢𝘯𝘥𝘭𝘦 𝘗𝘢𝘺𝘮𝘰𝘯𝘨𝘰 𝘸𝘦𝘣𝘩𝘰𝘰𝘬⁡
    public function handlePaymongoWebhook(Request $request)
    {
        Log::info('Webhook received: ' . json_encode($request->all()));

        $payload = $request->all();

        // ⁡⁣⁣⁢𝘊𝘩𝘦𝘤𝘬 𝘪𝘧 𝘵𝘩𝘦 𝘱𝘢𝘺𝘮𝘦𝘯𝘵 𝘸𝘢𝘴 𝘴𝘶𝘤𝘤𝘦𝘴𝘴𝘧𝘶𝘭⁡
        if ($payload['data']['attributes']['type'] === 'payment.paid') {
            $referenceNumber = $payload['data']['attributes']['data']['attributes']['reference_number'];
            
            DB::beginTransaction();
            try {
                $user = User::where('payment_reference', $referenceNumber)->lockForUpdate()->first();

                if ($user) {
                    $user->remaining_votes += 10;
                    $user->save();

                    Log::info("Added 10 votes to user {$user->id} for payment with reference {$referenceNumber}");
                    DB::commit();
                    return response()->json(['success' => true]);
                } else {
                    Log::warning("User not found for payment with reference {$referenceNumber}");
                    DB::rollBack();
                }
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Error processing payment: " . $e->getMessage());
            }
        }

        return response()->json(['success' => false, 'message' => 'Payment not successful or invalid event type']);
    }

}
