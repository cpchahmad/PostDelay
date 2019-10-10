<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <title>PostDelay</title>
</head>

<body>
<h3>Hi - {{$order->has_customer->first_name}}</h3>
<h5>THANKS FOR USING POSTDELAY</h5>
<br>
<p> Order-ID : {{$order->shopify_order_id}} </p>
<p> Ship-Out-Date : {{$order->ship_out_date}}</p>
<br>
<div class="row">
    <div class="col-md-6">
        <h6>Sender Details</h6>
        <br>
        <p> First Name : {{$order->has_sender->first_name}}</p>
        <p> Last Name : {{$order->has_sender->last_name}}</p>
        <p> Email  : {{$order->has_sender->email}}</p>
        <p> Business  : {{$order->has_sender->business}}</p>
        <p> Address1  : {{$order->has_sender->address1}}</p>
        <p> Address2  : {{$order->has_sender->address2}}</p>
        <p> City  : {{$order->has_sender->city}}</p>
        <p> State  : {{$order->has_sender->state}}</p>
        <p> Country  : {{$order->has_sender->country}}</p>
        <p> Phone  : {{$order->has_sender->phone}}</p>

    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h6>Recipient Details</h6>
        <br>
        <p> First Name : {{$order->has_recepient->first_name}}</p>
        <p> Last Name : {{$order->has_recepient->last_name}}</p>
        <p> Email  : {{$order->has_recepient->email}}</p>
        <p> Business  : {{$order->has_recepient->business}}</p>
        <p> Address1  : {{$order->has_recepient->address1}}</p>
        <p> Address2  : {{$order->has_recepient->address2}}</p>
        <p> City  : {{$order->has_recepient->city}}</p>
        <p> State  : {{$order->has_recepient->state}}</p>
        <p> Country  : {{$order->has_recepient->country}}</p>
        <p> Phone  : {{$order->has_recepient->phone}}</p>
    </div>
</div>

<hr>
<p> Please return the upper portion in your shipment of your item to postdelay
It allows us to link your incoming item with your order
</p>
<p>Mail Youe Item to <br> POSTDELAY LLC <br> BOX 15000 <br> Brooklyn, New-York <br> 11215, USA</p>
</body>
</html>
