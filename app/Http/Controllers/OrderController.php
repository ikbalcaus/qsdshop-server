<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommonRequest;
use App\Http\Requests\OrderRequest;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function getOrders()
    {
        $orders = Order::all();
        return response()->json($orders);
    }
    public function getOrdersPerUser(CommonRequest $request ){
        $userId = $request->input('id');
        $user=User::find($userId);
        if (!$user){
            return response()->json(['message' => 'User not found.'], 404);
        }
        $orders= Order::where('user_id',$userId)->get();
        return response()->json($orders,200);
    }
    public function updateState(OrderRequest $request){
        $order = Order::find($request->input('id'));
        if(!$order){
            return response()->json(['message' => 'Order not found.'], 404);
        }
        $order->update([
            'status' => $request->input('status'),
            'comment' => $request->input('comment',$order->comment)
        ]);
        Mail::to($order->email)->send(new OrderStatusUpdated($order,$request->input('comment')));
        return response()->json($order,200);
    }
}
