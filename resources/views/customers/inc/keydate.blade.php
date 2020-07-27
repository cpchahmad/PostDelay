
<div class="Form-content-name">
    <p>Important Dates</p>
    <div class="icon_wrapper">
        <i class="fa fa-chevron-right"></i>
    </div>
</div>

<div class="Form-content-detail" style="display: none">


    <div class="custom_fields_half">
        <div class="custom_Request_fields_half ">
            <label for="Order ID"> @if(in_array($order->status_id,['9' ,'17','21','23','24'])) Return Tracking ID @else Mailing Tracking ID  @endif
                <i class="tooltip far fa-question-circle">
            <span style="width: 320px;padding: 10px" class="tooltiptext">
                When your mailing is sent to the recipient on the ship-out date, the tracking ID will appear here
            </span></i>
            </label>
            <input disabled type="text"  name="account[first_name]" id="FirstName" value="{{$order->outbound_tracking_id}}" placeholder="">
        </div>
    </div>


    <div class="custom_fields_half">
        <div class="custom_Request_fields_half ">
            <label for="Order ID">Order Date</label>
            <input disabled type="text"  name="account[first_name]" id="FirstName" value="{{\Carbon\Carbon::parse($order->created_at)->format('F j ,Y')}}" placeholder="">
        </div>
    </div>



    <div class="custom_fields_half">
        <div class="custom_Request_fields_half ">
            <label for="Order ID">Receipt by PostDelay</label>
            <input disabled type="text"  name="account[first_name]" id="FirstName" @if($order->has_key_dates != null) @if($order->has_key_dates->received_post_date != null) value="{{\Carbon\Carbon::parse($order->has_key_dates->received_post_date)->format('F j ,Y')}}" @endif @else value="" @endif placeholder="">
        </div>
    </div>
    @if(strtotime(now()) < strtotime(\Carbon\Carbon::parse($order->created_at)->addDays($settings->min_threshold_for_modify_ship_out_date)))
        <div class="custom_fields_half">
            <div class="custom_Request_fields_half ">
                <label for="Order ID">Ship Out Date</label>
                <input disabled type="text"  name="account[first_name]" id="FirstName" value="{{\Carbon\Carbon::parse($order->ship_out_date)->format('F j ,Y')}}" placeholder="">
            </div>
        </div>
    @else
        <form style="margin-top: 10px;margin-bottom: 10px" id="modify_ship_out_date_form" action="" method="get">
            <input type="hidden" name="order_id" value="{{$order->id}}">
            <div class="custom_fields_half">
                <div class="custom_Request_fields_half ">
                    <label for="Order ID">Ship Out Date</label>
                    <input  required type="date"  name="ship_out_date"  min="{{now()->addDays((int)$settings->max_threshold_for_modify_ship_out_date)->format('Y-m-d')}}" max="{{now()->addDays(365)->format('Y-m-d')}}"  value="{{\Carbon\Carbon::parse($order->ship_out_date)->format('Y-m-d')}}" placeholder="">
                </div>
            </div>
            <input type="submit" class="Same-button" value="Modify Date">
        </form>

    @endif
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half ">
            <label for="Order ID">@if(in_array($order->status_id,['9' ,'17','21','23','24'])) Return Date @else Delivery Date @endif
                <i class="tooltip far fa-question-circle">
            <span style="width: 320px;padding: 10px" class="tooltiptext">
                <a target="_blank" style="color: white" href="https://www.usps.com/ship/"> Click to understand U.S. Postal Service shipping times.</a>
            </span></i>

            </label>
            <input disabled type="text"  name="account[first_name]" id="FirstName" @if($order->has_key_dates != null) @if($order->has_key_dates->completion_date != null) value="{{\Carbon\Carbon::parse($order->has_key_dates->completion_date)->format('F j ,Y')}}" @endif  @else value="" @endif placeholder="">
        </div>
    </div>
</div>

@if(strtotime(now()) < strtotime(Carbon\Carbon::parse($order->created_at)->addDays($settings->min_threshold_in_cancellation)))
    <div id="cancellation" data-show="0"></div>
@else
    <div id="cancellation" data-show="1"></div>
@endif
