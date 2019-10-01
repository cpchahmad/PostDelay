<div class="Form-content-header ">
    <h1 class="Form-content-header-Head left-head">Existing Order</h1>
</div>

<div class="Form-content-name feature-three-in-row">
    <p>Order Number</p>
    <p>Order Status</p>
    <p>Edit Order</p>
</div>
@foreach($orders as $order)
<div class="Form-content-detail ">

    <div class="ex-order-coloum1">
        <p class="ex-order-id">{{$order->order_name}}</p>
        <p class="ex-order-date">{{date_format($order->created_at,'Y-m-d')}}</p>
    </div>
    <div class="ex-order-coloum1 adj">
        <p class="ex-order-id" style="max-width: fit-content">{{$order->has_status->name}}</p>
    </div>
    <div class="ex-order-coloum3">
        <input type="submit" onclick="window.location.href='account/orders/{{$order->token}}'" class="Same-button" value="View Order">
    </div>

</div>
@endforeach
