<div class="tow-field-Row" >
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half tow-field-Row-left ">
            <label for="Order ID">Ship Date</label>
            <input type="date" required="" name="ship-date" @if($order->status_id == 2) disabled @endif @if($order->ship_to_postdelay_date != null)  value="{{\Carbon\Carbon::parse($order->ship_to_postdelay_date)->format('Y-m-d')}}" @else value="" @endif placeholder="" min="{{now()->format('Y-m-d')}}" max="{{\Carbon\Carbon::parse($order->ship_out_date)->format('Y-m-d')}}">
        </div>
    </div>
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half tow-field-Row-right">
            <label for="Order ID">Ship Method</label>
            <input type="text" required="" name="ship-method" @if($order->status_id == 2) disabled @endif value="{{$order->ship_method}}" placeholder="">
        </div>
    </div>
</div>
<div class="custom_fields_half">
    <div class="custom_Request_fields_half ">
        <label for="Order ID">Tracking Id</label>
        <input type="text" required="" name="tracking_id" @if($order->status_id == 2) disabled @endif  value="{{$order->tracking_id}}" placeholder="">
    </div>
</div>
@if($order->status_id == 2)
    <input type="button" class="Same-button" value="Save" disabled>
    @else
<input type="submit" class="Same-button" value="Save">
    @endif
