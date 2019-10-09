
<div class="Form-content-name">
    <p>Key Date</p>
</div>

<div class="Form-content-detail">

    <div class="Key-date-field" >
        <div class="custom_fields_half">
            <div class="custom_Request_fields_half ">
                <label for="Order ID">Order Date</label>
                <input disabled type="text"  name="account[first_name]" id="FirstName" value="{{\Carbon\Carbon::parse($order->created_at)->format('F j ,Y')}}" placeholder="">
            </div>
        </div>
    </div>

    <div class="custom_fields_half">
        <div class="custom_Request_fields_half ">
            <label for="Order ID">Receipt by PastDelay</label>
            <input disabled type="text"  name="account[first_name]" id="FirstName" @if($order->has_key_dates != null) value="{{\Carbon\Carbon::parse($order->has_key_dates->received_post_date)->format('F j ,Y')}}" @else value="" @endif placeholder="">
        </div>
    </div>
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half ">
            <label for="Order ID">Ship Out Date</label>
            <input disabled type="text"  name="account[first_name]" id="FirstName" value="{{\Carbon\Carbon::parse($order->ship_out_date)->format('F j ,Y')}}" placeholder="">
        </div>
    </div>
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half ">
            <label for="Order ID">Completion Date</label>
            <input disabled type="text"  name="account[first_name]" id="FirstName" @if($order->has_key_dates != null) value="{{\Carbon\Carbon::parse($order->has_key_dates->completion_date)->format('F j ,Y')}}"  @else value="" @endif placeholder="">
        </div>
