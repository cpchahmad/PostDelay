<h1 style="margin-bottom: 5px" class="Form-content-header-Head2">Order Status</h1>
<div class="status_box">
    <span style="background: {{ $order->has_status->color }};"></span>
<p style="@if($order->has_status->color )color:{{ $order->has_status->color }}@else black @endif; font-size: 14px">{{$order->has_status->name}}</p>
</div>