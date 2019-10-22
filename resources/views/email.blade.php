<!DOCTYPE html>
<html>
<head>
    <title>PostDelay</title>
</head>
<body>


<p>Hi, {{$customer->first_name}}</p>
<p>
    Your Order (ID-{{$order->shopify_order_id}}) Status has been changed to "{{$order->has_status->name}}".
</p>
<h5> Order Status Summary </h5>
<p>


    @if($order->status_id == 1)
        The initial status for a new order. The order maintains this status until you tell us that you have shipped the item to PostDelay, or if you do not enter this information in the order details, it maintains this status until PostDelay has received your item.
    @endif

    @if($order->status_id == 2)
        If you choose to enter details about your shipment to PostDelay in the 'Order Details' page, this status will be set when you tell us you've sent your item to PostDelay.
    @endif

    @if($order->status_id == 3)
        Your item has been received by PostDelay and have been placed into storage, waiting for the future shipment date.
    @endif
    @if($order->status_id == 4)
        Your future shipment date has come! Your item has been sent to the recipient.
    @endif
    @if($order->status_id == 5)
        Based on the tracking information of PostDelay's outgoing shipment, your recipient has received the item.
    @endif
    @if($order->status_id == 6)
        Your order was cancelled before the item was shipped to PostDelay. Did you cancel by accident? Did you cancel but still ship your item? Contact Us.
    @endif
    @if($order->status_id == 7)
        You cancelled your order after you shipped the item to us, but before PostDelay received it. We are waiting to hear from you how you want to proceed.
    @endif
    @if($order->status_id == 8)
        You cancelled your order after you shipped the item to us, but before PostDelay received it. You instructed us that you did not want the item returned to you, and we have disposed of the item
    @endif
    @if($order->status_id == 9)
        You cancelled your order after you shipped the item to us, but before PostDelay received it. You instructed us that you want the item returned to you.
    @endif
    @if($order->status_id == 10)
        You cancelled your order after PostDelay received the item, but before it was shipped to the recipient. We are waiting to hear from you how you want to proceed.
    @endif
    @if($order->status_id == 11)
        You cancelled your order after PostDelay received the item, but before it was shipped to the recipient. You instructed us that you did not want the item returned to you, and we have disposed of the item
    @endif
    @if($order->status_id == 12)
        You cancelled your order after PostDelay received the item, but before it was shipped to the recipient. You instructed us that you want the item returned to you.
    @endif
    @if($order->status_id == 13)
        We have mailed the cancelled shipment back to you, along with tracking information for the return shipment.
    @endif
    @if($order->status_id == 14)
        Based on the tracking information of PostDelay's outgoing shipment, you have received your cancelled shipment back.
    @endif
    @if($order->status_id == 15)
        We check the price of mailing again a few days before shipment date. The price of shipping your package increased. We are waiting to hear from you how you want to proceed.
    @endif
    @if($order->status_id == 16)
        We check the price of mailing again a few days before shipment date. The price of shipping your package increased. You instructed us to ship the item to your recipient and you paid for this increase in shipping cost.
    @endif
    @if($order->status_id == 17)
        We check the price of mailing again a few days before shipment date. The price of shipping your package increased. You instructed us not to ship the item to your recipient and you paid the shipping cost to have the item returned to you
    @endif
    @if($order->status_id == 18)
        We check the price of mailing again a few days before shipment date. The price of shipping your package increased. You instructed us not to ship the item to you recipient and instructed us to dispose of the item.
    @endif
    @if($order->status_id == 19)
        After shipping your item to your recipient, the item was returned to PostDelay as undeliverable. We are waiting to hear from you how you want to proceed.
    @endif
    @if($order->status_id == 20)
        After shipping your item to your recipient, the item was returned to PostDelay as undeliverable. You instructed us to ship the item to your recipient again and you paid for additional shipping attempt.
    @endif
    @if($order->status_id == 21)
        After shipping your item to your recipient, the item was returned to PostDelay as undeliverable. You instructed us not toattempt redelivery to your recipient and you paid the shipping cost to have the item returned to you
    @endif
    @if($order->status_id == 22)
        After shipping your item to your recipient, the item was returned to PostDelay as undeliverable. You instructed us not to reattempt delivery, to not return the item to you, and to dispose of the item.
    @endif
    @if($order->status_id == 23)
        The item that was returned to PostDelay as undeliverable has been shipped to the user.
    @endif
    @if($order->status_id == 24)
        The item that was returned to PostDelay as undeliverable has been shipped to and received by the user.
    @endif

</p>


</body>
</html>
