<div class="Form-content-name">
    <p>Additional Fee Detail</p>
    <div class="icon_wrapper">
        <i class="fa fa-chevron-right"></i>
    </div>
</div>



<div class="Form-content-detail " style="display: none;">
    @if(count($order->has_additional_payments) > 0)
    <div class="ex-order-coloum1">
        <p class="ex-order-id" style="color: black">Fee Name</p>
    </div>
    <div class="ex-order-coloum1 adj">
        <p class="ex-order-id" style="max-width: fit-content;color: black">Amount</p>
    </div>
    <div class="ex-order-coloum1">
        <p class="ex-order-id" style="max-width: fit-content;color: black">Paid Date</p>
    </div>

    <div class="additional_payment">
        @foreach($order->has_additional_payments as $index => $payment)
            <div class="ex-order-coloum1">
                <p class="ex-order-id">{{$payment->additional_payment_name}}</p>
            </div>
            <div class="ex-order-coloum1 adj">
                <p class="ex-order-id" style="max-width: fit-content">${{number_format($payment->order_total,2)}} USD</p>
            </div>
            <div class="ex-order-coloum1">
                <p class="ex-order-id" style="max-width: fit-content">{{\Carbon\Carbon::parse($payment->created_at)->format('F j ,Y')}}</p>
            </div>
        @endforeach
    </div>

    @else
        <div class="ex-order-coloum1 no_additiona_fee" style="width: 100%">
        <p style="max-width: fit-content;text-align: left">No Additional Fee Paid</p>
    </div>
        @endif

    @if(!in_array($order->status_id,[1,2,3,4,5]))
            <a style="cursor: pointer" onclick="window.location.href='https://postdelay.myshopify.com/account?view=additional-fee&&order-id={{$order->shopify_order_id}}'" class="Same-button" > Pay Additional Fee For Further Process</a>

    @endif

        <a style="cursor: pointer;margin-top:10px;" onclick="window.location.href='https://postdelay.myshopify.com/account?view=request-form&&order-id={{$order->shopify_order_id}}'" class="Same-button" >Request Paper Form</a>

</div>
