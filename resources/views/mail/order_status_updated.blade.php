<!DOCTYPE html>
<html>
<head>
    <title>Order Status Updated</title>
</head>
<body>
<h1>Your Order Status Has Been Updated</h1>
<p>Hi {{ $order->full_name }},</p>
<p>Your order status has been updated to: <strong>@switch($order->status)
            @case(1)
                Pending
                @break
            @case(2)
                Processing
                @break
            @case(3)
                Delivered
                @break
            @case(4)
                Cancelled
                @break
            @default
                Unknown
        @endswitch</strong>.</p>
@if($comment)
    <p>Comment: {{ $comment }}</p>
@endif
<p>Order ID: {{ $order->id }}</p>
<p>Thank you for shopping with us!</p>
</body>
</html>
