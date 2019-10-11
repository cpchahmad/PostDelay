<!DOCTYPE html>
<html>
<head>
    <title>PostDelay</title>
</head>
<body>


<p>Hi, {{$customer->first_name}}</p>
<p>
  Your Order (ID-{{$order->shopify_order_id}}) Status has been changed to {{$order->has_status->name}}.
</p>

<strong>Thank you Sir. :)</strong>

</body>
</html>
