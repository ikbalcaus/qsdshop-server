<!DOCTYPE html>
<html>
<head>
    <title>Order Status Changed</title>
</head>
<body>
<h1>Your Order Status Has Changed</h1>
<p>Dear {{ $order->user->name }},</p>
<p>Your order with ID {{ $order->id }} has changed status to: {{ $order->status }}</p>
<p>Comment: {{ $comment }}</p>
<p>Thank you for your patience.</p>
</body>
</html>
