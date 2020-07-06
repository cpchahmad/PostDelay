<h1 style="margin-bottom: 5px" class="Form-content-header-Head2">Order Status
@if(in_array($order->status_id,[10,15,19]))
        <i class="tooltip far fa-question-circle">
            <span style="width: 320px;padding: 10px" class="tooltiptext">
                <a target="_blank" style="color: white" href="https://postdelay.myshopify.com/pages/faq"> Click here to understand your options.</a>
            </span></i>
    @endif
</h1>
<div class="status_box">
    <span style="background: {{ $order->has_status->color }};"></span>
<p style="@if($order->has_status->color )color:{{ $order->has_status->color }}@else black @endif; font-size: 14px">{{$order->has_status->name}}</p>
</div>
