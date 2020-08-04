<style>
    /* The container */
    .container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 14px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
        border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container input:checked ~ .checkmark {
        background-color:#263a40;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .container .checkmark:after {
        top: 7px;
        left: 7px;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: white;
    }
</style>

<form action="{{route('response_from_user')}}" method="post" style="margin-top: 20px">
    <div class="status_wrapper">


    </div>
    <input type="hidden" name="order-id" value="{{$order->shopify_order_id}}">
    @if(in_array($order->status_id , [7]))
        <label class="container">{{$settings->status_7_option_1}}
            <input required type="radio" name="response" value="9">
            <span class="checkmark"></span>
        </label>
        <label class="container">{{$settings->status_7_option_2}}
            <input required type="radio" name="response" value="8">
            <span class="checkmark"></span>
        </label>
        <label class="container">{{$settings->status_7_option_3}}
            <input required type="radio" name="response" value="3">
            <span class="checkmark"></span>
        </label>

    @endif

    @if(in_array($order->status_id , [10]))
        <label class="container">Return my shipment
            <input required type="radio" name="response" value="12">
            <span class="checkmark"></span>
        </label>
        <label class="container">Dispose my shipment
            <input required type="radio" name="response" value="11">
            <span class="checkmark"></span>
        </label>
    @endif

    @if(in_array($order->status_id , [15]))
        <label class="container">{{$settings->status_15_option_1}} - ${{number_format($order->additional_cost_to_ship,2)}}
            <input required type="radio" name="response" value="16">
            <span class="checkmark"></span>
        </label>
        <label class="container">{{$settings->status_15_option_2}} - ${{number_format($order->additional_cost_to_return,2)}}
            <input required type="radio" name="response" value="17">
            <span class="checkmark"></span>
        </label>
        <label class="container">{{$settings->status_15_option_3}}
            <input required type="radio" name="response" value="18">
            <span class="checkmark"></span>
        </label>
    @endif

    @if(in_array($order->status_id , [19]))
        <label class="container">{{$settings->status_19_option_1}}
            <input required type="radio" name="response" value="20">
            <span class="checkmark"></span>
        </label>
        <label class="container">{{$settings->status_19_option_2}}
            <input required type="radio" name="response" value="21">
            <span class="checkmark"></span>
        </label>
        <label class="container">{{$settings->status_19_option_3}}
            <input required type="radio" name="response" value="22">
            <span class="checkmark"></span>
        </label>
    @endif
    <input style="margin-top: 10px" id="send_response_button" class="Same-button" type="submit" value="Proceed">
</form>
