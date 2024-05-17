<!DOCTYPE html>
<html>

<head>
    <title>Order confirmation</title>
</head>
<body>

<h2>Order confirmation</h2>

<p>Dear {{$order->user->first_name}} {{$order->user->last_name}}</p>

<p>Thank you for your order!</p>

<h3>Order details:</h3>
<p>Email: {{$order->user->email}}<p>
<p>City: {{$order->city}}<p>
<p>Address: {{$order->address}}<p>
<p>Zip code: {{$order->zip}}<p>
<p>Phone: {{$order->phone}}<p>

<div>
<p>Product: {{$order->orderProductSize->productSize->product->name}}</p>
<p>Brand: {{$order->orderProductSize->productSize->product->brands->name}}</p>
<p>Size: {{$order->orderProductSize->productSize->sizes->size}}</p>
<p>Price: {{$order->orderProductSize->productSize->product->price}}</p>
</div>


<p>Thanks for shopping with us</p>

</body>

</html>
