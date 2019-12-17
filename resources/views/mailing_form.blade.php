<!DOCTYPE html>
<html>
<head>
    <title>PostDelay</title>
    <link rel="stylesheet" type="text/css" href="/assets/notifications/styles.css">
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
    </style>
</head>
<body>
<div style="max-width: 767px;margin: auto;border: 1px solid black;border-radius: 84px;overflow: hidden;font-size: 0;padding: 25px;">
    <div class="content_area" style="width: 70%;display: inline-block;font-size: 16px;padding: 0 2.5%;">
        <div class="email_logo">
            <img src="https://cdn.shopify.com/s/files/1/0120/3106/6193/files/email_logo.jpg" style="width: 100%; max-width: 330px;margin-top: 80px">
        </div>
        <div class="email_content" style="font-size: 16px;line-height: 25px;font-family: Arial;">
            <p>Hi {{$customer->first_name}}, <br>Thank you for using PostDelay! <br> This form allows us to link this incoming shipment with your order </p>
            <p>Send your item, including this label, to: <br> PostDelay LLCBox <br>3492, Church Street Station <br>New York, NY, 10008, USA</p>
            <p>Order ID: <{{$order->order_name}}> <br>Order Date: {{$order->created_at}} <br>Mail Out Date : {{$order->ship_out_date}}  </p>

        </div>
    </div>
    <div class="men_icon_wrapper" style="width: 25%;display: inline-block;vertical-align: top;">
        <div class="men_icon">
            <img src="https://cdn.shopify.com/s/files/1/0120/3106/6193/files/icon_blue.png" style="width: 100%;height: auto;">
        </div>
    </div>
</div>

<div class="additiona_text" style="max-width: 767px;margin: auto;line-height: 25px;font-family: Arial;">
    <p></p>
</div>
</body>
</html>


