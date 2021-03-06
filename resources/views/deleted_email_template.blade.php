<!DOCTYPE html>
<html>
<head>
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
            <p>Hello <b>{{$customer->first_name}}</b>,<br> Your PostDelay account has been deleted.</p>

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

</body>
</html>
