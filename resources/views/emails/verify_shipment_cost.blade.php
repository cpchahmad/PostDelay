<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PostDelay</title>
    <style>
        .section{
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            border-top-width: 1px;
            border-top-color: #e5e5e5;
            border-top-style: solid;
        }
        .section__cell{
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            padding: 40px 0
        }
        .container{
            width: 560px;
            text-align: left;
            border-spacing: 0;
            border-collapse: collapse;
            margin: 0 auto
        }
        td{
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
        }
        h3{
            font-weight: normal;
            font-size: 20px;
            margin: 0 0 25px;
        }
        .row{
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
        }
        .order-list__item{
            width: 100%;
        }
        .order-list__item__cell{
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            padding-bottom: 15px
        }
        .order-list__product-description-cell{
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            width: 100%;
        }
        .order-list__item-title{
            font-size: 16px;
            font-weight: 600;
            line-height: 1.4;
            color: #555;
        }
        .order-list__item-variant{
            font-size: 14px;
            color: #999;
        }
        .order-list__item-discount-allocation{
            font-size: 14px;
            display: block;
            line-height: 1.4;
            color: #555;
            margin: 5px 0 0;

        }
        .order-list__price-cell{
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            white-space: nowrap;
        }
        .order-list__item-original-price{
            font-size: 14px;
            display: block;
            text-align: right;
            color: #999;
        }
        .discount-tag-icon{
            vertical-align: middle;
            margin-right: 6px;
        }
        .order-list__item-discount-allocation span {
            font-size: 14px;
            margin-left: -4px;
            color: #999;
        }
        .subtotal-lines {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            margin-top: 15px;
            border-top-width: 1px;
            border-top-color: #e5e5e5;
            border-top-style: solid;
        }
        .subtotal-spacer{
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
        }
        .subtotal-table{
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .subtotal-table--total{
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            margin-top: 20px;
            border-top-width: 2px;
            border-top-color: #e5e5e5;
            border-top-style: solid;
        }
        .subtotal-line__title{
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            padding: 20px 0 0
        }
        .subtotal-line__title p {
            color: #777;
            line-height: 1.2em;
            font-size: 16px;
            margin: 0;
        }

        .subtotal-line__title p span{
            font-size: 16px
        }
        .subtotal-line__value{
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            padding: 20px 0 0;
            text-align: right;
        }
        .subtotal-line__value strong{
            font-size: 24px;
            color: #555;
        }
        .total-discount{
            color: #777;
            line-height: 1.1;
            font-size: 16px;
            margin: 10px 0 0
        }
        .total-discount--amount{
            font-size: 16px;
            color: #555;
        }
        .customer-info__item{
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            padding-bottom: 40px;
            width: 50%;
        }
        h4{
            font-weight: 500;
            font-size: 16px;
            color: #555;
            margin: 0 0 5px;
        }
        .customer-info__item p{
            color: #777;
            line-height: 150%;
            font-size: 16px;
            margin: 0;
        }
        .footer{
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            border-top-width: 1px;
            border-top-color: #e5e5e5;
            border-top-style: solid;
        }
        .footer__cell{
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            padding: 35px 0;
        }
        .disclaimer__subtext{
            color: #999;
            line-height: 150%;
            font-size: 14px;
            margin: 0;
        }
        .order-list__item__cell table{
            border-spacing: 0;
            border-collapse: collapse;
        }

        .main_button{
            text-align: center;
            display: block;
            background: #0000FF;
            color: white !important;
            text-transform: uppercase;
            text-decoration: none;
            font-weight: bold;
            font-size: 20px;
            margin: 0;
            padding: 10px 20px;
            line-height: 1;
            height: 43px;
            letter-spacing: 0px;
            border-radius: 12px;
            margin-top: 25px;
            cursor: pointer
        }

        @media only screen and (max-width: 768px) {
            .main_button{
                text-align: center !important;
                display: block !important;
                background: #0000FF !important;
                color: white !important;
                text-transform: uppercase !important;
                text-decoration: none !important;
                font-weight: bold !important;
                font-size: 13px !important;
                margin: 0 !important;
                height: 27px !important;
                border-radius: 12px !important;
                cursor: pointer !important;
            }
        }
    </style>
</head>
<body>
<div style="
    max-width: 767px;
    margin: auto;
    overflow: hidden;
    font-size: 0;
    padding: 25px;
">
    <div class="content_area" style="
    width: 70%;
    display: inline-block;
    font-size: 16px;
    padding: 0 2.5%;
">
        <div class="email_logo">
            <img src="{{ asset('email_logo.jpg') }}" style="
    width: 100%; max-width: 330px; ">
        </div>
        <div class="email_content" style="
    font-size: 16px;
    line-height: 25px;
    font-family: Arial;
">
            <p>
                Order {{$order->order_name}}

            </p>
            <p>Hello <b>Admin</b>. Please Verify The Shipment Cost Of Order! </p>
            <p>
                Status: <span style="color:{{$order->has_status->color}} ">{{$order->has_status->name}}</span>
            </p>

        </div>

        <div class="email_btn">
            <a href="{{route('order_update',$order->id)}}" class="main_button">Manage Order</a>
        </div>

    </div>
    <div class="men_icon_wrapper" style="
    width: 25%;
    display: inline-block;
    vertical-align: top;
">
        <div class="men_icon">
            <img src="{{ asset('icon_blue.png') }}" style="width: 100%;height: auto;">
        </div>
    </div>
</div>
<div class="additiona_text" style="
    max-width: 767px;
    margin: auto;
    line-height: 25px;
    font-family: Arial;
">
    <table class="row section">
        <tr>
            <td class="section__cell">
                <center>
                    <table class="container">
                        <tr>
                            <td>
                                <h3>Order Summary</h3>
                            </td>
                        </tr>
                    </table>
                    <table class="container">
                        <tr>
                            <td>
                                <table class="row">
                                    <tr>
                                        <td class="customer-info__item">
                                            <h4>Future Ship-Out-Date</h4>
                                            <p>{{\Carbon\Carbon::parse($order->ship_out_date)->format('Y-m-d')}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        @if($order->has_recepient != null)
                                            <td class="customer-info__item">
                                                <h4>Shipping address</h4>
                                                <p>{{$order->has_recepient->firstname}} {{$order->has_recepient->last_name}}</p>
                                                <p>{{$order->has_recepient->business}}</p>
                                                <p>{{$order->has_recepient->address1}}</p>
                                                <p>{{$order->has_recepient->address2}}</p>
                                                <p>{{$order->has_recepient->city}}, {{$order->has_recepient->state}} {{$order->has_recepient->postcode}}</p>
                                                <p>{{$order->has_recepient->country}}</p>
                                            </td>
                                        @endif

                                        @if($order->has_billing != null)
                                            <td class="customer-info__item">
                                                <h4>Billing address</h4>
                                                <p>{{$order->has_billing->firstname}} {{$order->has_billing->last_name}}</p>
                                                <p>{{$order->has_billing->business}}</p>
                                                <p>{{$order->has_billing->address1}}</p>
                                                <p>{{$order->has_billing->address2}}</p>
                                                <p>{{$order->has_billing->city}} {{$order->has_billing->state}} {{$order->has_billing->postcode}}</p>
                                                <p>{{$order->has_billing->country}}</p>
                                            </td>
                                        @endif

                                    </tr>
                                </table>
                                <table class="row">
                                    <tr>
                                        @if($order->shipping_method_title != null)
                                            <td class="customer-info__item">
                                                <h4>Shipping method</h4>
                                                <p>{{$order->shipping_method_title}}</p>
                                            </td>
                                        @endif
                                        @if($order->payment_gateway != null)
                                            <td class="customer-info__item">
                                                <h4>Payment method</h4>
                                                <p class="customer-info__item-content">
                                                    {{$order->payment_gateway}} - ${{number_format($order->order_total,2)}} USD
                                                </p>
                                            </td>
                                        @endif
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </table>
                </center>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
