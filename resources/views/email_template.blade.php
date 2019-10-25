<!DOCTYPE html>
<html>
<head>
    <title>PostDelay</title>
</head>
<body>
<div style="
    max-width: 767px;
    margin: auto;
    border: 1px solid black;
    border-radius: 84px;
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
            <p>Hello <b>{{$customer->name}}</b>, {{$order->has_status->message}}</p>
            <p>

            </p>
        </div>
        <div class="email_btn">
            <a href="" style="
    text-align: center;
    display: block;
    background: #0000FF;
    color: white;
    text-transform: uppercase;
    text-decoration: none;
    font-weight: bold;
    font-size: 20px;
    margin: 0;
    padding: 0;
    line-height: 53px;
    height: 45px;
    letter-spacing: 3px;
    border-radius: 12px;
    margin-top: 25px;
">{{$order->has_status->button_text}}</a>
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

    <p>{{$order->has_status->description}}</p>
</div>
</body>
</html>
