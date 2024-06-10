<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function payment(PaymentRequest $request)
    {
        // Set your Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $token = $request->input('token');
            $message= "Order details: \n Full name: ".$request->input('full_name')."
                                      \n Email: ".$request->input('email')."
                                      \n Phone: ".$request->input('phone');
            $intent=Charge::create([
                'amount'=>$request->input('total_price')*100,
                'currency'=>'usd',
                'source'=>$token,
                'description'=>$message
            ]);
            if ($intent->status !== 'succeeded') {
                throw new \Exception('Payment failed. Please try again.');
            }
            $order = Order::create([
                'full_name' => $request->input('full_name'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'zip' => $request->input('zip'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'total_price' => $request->input('total_price'),
                'user_id' => optional(auth()->id())->id,
                'status' =>1,
                'transaction_id' => $intent->id,
            ]);
            Mail::to($order->email)->queue(new OrderConfirmation($order));
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
