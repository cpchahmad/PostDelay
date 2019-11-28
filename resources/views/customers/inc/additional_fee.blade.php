<div class="Form-content-name">
    <p>Additional Fee Detail</p>
</div>

@if(count($order->has_additional_payments) > 0)

    <div class="Form-content-detail ">

        <div class="ex-order-coloum1">
            <p class="ex-order-id" style="color: black">Fee Name</p>
        </div>
        <div class="ex-order-coloum1 adj">
            <p class="ex-order-id" style="max-width: fit-content;color: black">Amount</p>
        </div>
        <div class="ex-order-coloum1">
            <p class="ex-order-id" style="max-width: fit-content;color: black">Paid Date</p>
        </div>

    </div>

    @foreach($order->has_additional_payments as $index => $payment)
        @if($payment->checkout_completed == 1)
            <div class="Form-content-detail ">

                <div class="ex-order-coloum1">
                    <p class="ex-order-id">{{$payment->additional_payment_name}}</p>
                </div>
                <div class="ex-order-coloum1 adj">
                    <p class="ex-order-id" style="max-width: fit-content">${{number_format($payment->order_total,2)}} USD</p>
                </div>
                <div class="ex-order-coloum1">
                    <p class="ex-order-id" style="max-width: fit-content">{{\Carbon\Carbon::parse($payment->created_at)->format('F j ,Y')}}</p>
                </div>

            </div>
        @endif
    @endforeach
@else
    <div class="Form-content-detail">

        <div class="ex-order-coloum1" style="width: 100%">
            <p style="max-width: fit-content;text-align: left">No Additional Fee Paid</p>
        </div>
    </div>

@endif
@if(in_array($order->status_id,[15,19]) && $response != null)
    <div class="Form-content-detail ">
        <a style="cursor: pointer" onclick="window.location.href='https://postdelay.myshopify.com/account?view=additional-fee&&order-id={{$order->shopify_order_id}}&&response={{$response->response}}'" class="Same-button" > Pay Additional Fee For Further Process</a>

    </div>
@endif

<div class="Form-content-detail ">
    <a style="cursor: pointer" onclick="window.location.href='https://postdelay.myshopify.com/account?view=request-form&&order-id={{$order->shopify_order_id}}'" class="Same-button" >Request Paper Form</a>

</div>
