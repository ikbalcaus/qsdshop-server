<!DOCTYPE html>
<html>

<head>
    <title>Order confirmation</title>
</head>
<body>

<h2>Order confirmation</h2>

<p>Dear {{$order->full_name}},</p>

<p>Thank you for your order!</p>

<h3>Order details:</h3>
<p>
    <strong>Order ID:</strong> {{ $order->id }}<br>
    <strong>Full Name:</strong> {{ $order->full_name }}<br>
    <strong>Email:</strong> {{ $order->email }}<br>
    <strong>Phone:</strong> {{ $order->phone }}<br>
    <strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->zip }}<br>
    <strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}<br>
</p>
{{--<div>
<p>Product: {{$order->orderProductSize->productSize->product->name}}</p>
<p>Brand: {{$order->orderProductSize->productSize->product->brands->name}}</p>
<p>Size: {{$order->orderProductSize->productSize->sizes->size}}</p>
<p>Price: {{$order->orderProductSize->productSize->product->price}}</p>
</div>--}}
<br>
<p>Thanks for shopping with us.</p>

</body>

</html>
