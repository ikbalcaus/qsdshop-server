<!DOCTYPE html>
<html>
<head>
    <title>Product Back in Stock</title>
</head>
<body>
    <h1>Product Back in Stock</h1>
    <p>Dear {{ $userName }},</p>
    <p>We are pleased to inform you that the product "{{ $productName }}" you were interested in is back in stock on our website.</p>
    <p>You can purchase it at the following link: <a href="{{ $productLink }}">{{ $productLink }}</a></p>
    <p>Thank you for your interest!</p>
</body>
</html>
