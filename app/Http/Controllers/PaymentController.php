<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function payment(PaymentRequest $request)
    {
        // Set your Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $paymentMethod = \Stripe\PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'number' => $request->input('card_number'),
                    'exp_month' => $request->input('expiration_month'),
                    'exp_year' => $request->input('expiration_year'),
                    'cvc' => $request->input('cvc'),
                ],
                'billing_details' => [
                    'name' => $request->input('full_name'),
                    'address' => [
                        'line1' => $request->input('address'),
                        'city' => $request->input('city'),
                        'postal_code' => $request->input('zip'),
                    ],
                ],
            ]);
            $order = Order::create([
                'payment_method_id' => $paymentMethod->id,
                'full_name' => $request->input('full_name'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'zip' => $request->input('zip'),
                'phone' => $request->input('phone'),
                'total_price' => $request->input('total_price')*100,
                'status' => 1,
                'user_id'=>auth()->id(),
            ]);
            $intent = PaymentIntent::create([
               'amount'=>$order->total_price,
                'currency'=>'usd',
                'payment_method_types'=>$paymentMethod->id,
                'confirmation_method'=>'manual',
                'confirm'=>true,
            ]);

            $orderStatus= $intent->status==='succeeded'?3:1;

            $order->update([
               'transaction_id'=>$intent->id,
                'status'=>$orderStatus,
            ]);

            return response()->json([
               'payment_intent'=>$intent->id,
                'client_secret'=>$intent->client_secret,
                'status'=>$intent->status,
            ]);


        } catch (\Stripe\Exception\CardException $e) {
            return response()->json(['error' => $e->getError()->message], 400);
        } catch (\Stripe\Exception\RateLimitException $e) {
            return response()->json(['error' => $e->getError()->message], 429);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return response()->json(['error' => $e->getError()->message], 400);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return response()->json(['error' => $e->getError()->message], 401);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return response()->json(['error' => $e->getError()->message], 502);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return response()->json(['error' => $e->getError()->message], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
