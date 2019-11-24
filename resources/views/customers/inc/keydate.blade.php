
<div class="Form-content-name">
    <p>Key Date</p>
    <div class="icon_wrapper">
        <i class="fa fa-chevron-right"></i>
    </div>
</div>

<div class="Form-content-detail" style="display: none;">

    <div class="Key-date-field" >
        <div class="custom_fields_half">
            <div class="custom_Request_fields_half ">
                <label for="Order ID">Order Date</label>
                <input disabled type="text"  value="{{\Carbon\Carbon::parse($order->created_at)->format('F j ,Y')}}" placeholder="">
            </div>
        </div>
    </div>


    @if($order->has_key_dates != null)
    @if($order->has_key_dates->received_post_date)
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half ">
            <label for="Order ID">Receipt by PastDelay</label>
            <input disabled type="text"  @if($order->has_key_dates != null) value="{{\Carbon\Carbon::parse($order->has_key_dates->received_post_date)->format('F j ,Y')}}" @else value="" @endif placeholder="">
        </div>
    </div>
    @endif
    @endif


    <div class="custom_fields_half">
        <div class="custom_Request_fields_half ">
            <label for="Order ID">Ship Out Date</label>
            <input disabled type="text" value="{{\Carbon\Carbon::parse($order->ship_out_date)->format('F j ,Y')}}" placeholder="">
        </div>
    </div>
    @if($order->has_key_dates != null)
        @if($order->has_key_dates->completion_date)
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half ">
            <label for="Order ID">Completion Date</label>
            <input disabled type="text"   @if($order->has_key_dates != null) value="{{\Carbon\Carbon::parse($order->has_key_dates->completion_date)->format('F j ,Y')}}"  @else value="" @endif placeholder="">
        </div>
    </div>
        @endif
        @endif
</div>