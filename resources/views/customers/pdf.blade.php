<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <title>PostDelay</title>
</head>

<body>
<h2>Hi - {{$order->has_customer->first_name}}</h2>
<h5>THANKS FOR USING POSTDELAY</h5>

<div class="row">
    <div class="col-md-12">
        <h6>Sender Details</h6>
            <table>
                <thead><tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Business</th>
                    <th>Address1</th>
                    <th>Address2</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip Code</th>
                    <th>Country</th>
                    <th>Phone</th>
                </tr></thead>
                <tbody>
                <tr>
                    <td>{{$order->has_sender->first_name}}</td>
                    <td>{{$order->has_sender->last_name}}</td>
                    <td>{{$order->has_sender->email}}</td>
                    <td>{{$order->has_sender->business}}</td>
                    <td>{{$order->has_sender->address1}}</td>
                    <td>{{$order->has_sender->address2}}</td>
                    <td>{{$order->has_sender->city}}</td>
                    <td>{{$order->has_sender->state}}</td>
                    <td>{{$order->has_sender->postcode}}</td>
                    <td>{{$order->has_sender->country}}</td>
                    <td>{{$order->has_sender->phone}}</td>

                </tr>
                </tbody>
            </table>
    </div>
</div>

<hr>
<p> Please return the upper portion in your shipment of your item to postdelay
It allows us to link your incoming item with your order
</p>
<p>Mail Youe Item to <br> POSTDELAY LLC <br> BOX 15000 <br> Brooklyn, New-York <br> 11215, USA</p>
</body>
</html>
