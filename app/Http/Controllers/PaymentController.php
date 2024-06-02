<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function payment(PaymentRequest $request)
    {
        // Set your Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            //bez ove linije 20, dodavati direktno sa inputa od requesta
            $data=$request->validated();

            $paymentMethod=\Stripe\PaymentMethod::create([
                'type'=>'card',
                'card'=>[
                    'number'=>$data['card_number'],
                    'exp_month'=>$data['expiration_month'],
                    'exp_year'=>$data['expiration_year'],
                    'cvc'=>$data['cvc'],
                ],
                'billing details'=>[
                    'name'=>$data['full_name'],
                    'address'=>[
                        'line1'=>$data['address'],
                        'city'=>$data['city'],
                        'postal_code'=>$data['zip'],
                    ],
                ],
            ]);
            $order=Order::create([
                'payment_method_id'=>$paymentMethod->id,
                'full_name'=>$data['full_name'],
                'address'=>$data['address'],
                'city'=>$data['city'],
                'zip'=>$data['zip'],
                'phone'=>$data['phone'],
                'total_price'=>$data['total_price'],
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
