<div class="Get-name">
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half  Get-name-left">
            <label for="FirstName">First Name</label>
            <input disabled type="text"  name="account[first_name]" id="FirstName" value="{{$order->has_sender->first_name}}" placeholder="">
        </div>
    </div>
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half Get-name-right">
            <label for="LastName">Last Name</label>
            <input disabled type="text"  name="account[last_name]" id="LastName" value="{{$order->has_sender->last_name}}" placeholder="">
        </div>
    </div>
</div>

<div class="custom_fields_half">
    <div class="custom_Request_fields_half">
        <label for="Business">Business</label>
        <input disabled type="text"  name="account[business]" id="Business" value="{{$order->has_sender->business}}" placeholder="">
    </div>
</div>
<div class="custom_fields_half">
    <div class="custom_Request_fields_half">
        <label for="Address1">Address1</label>
        <input disabled type="text"  name="account[address1]" id="Address1" value="{{$order->has_sender->address1}}" placeholder="">
    </div>
</div>
<div class="custom_fields_half">
    <div class="custom_Request_fields_half">
        <label for="Address2">Address2</label>
        <input disabled type="text"  name="account[address2]" id="Address2" value="{{$order->has_sender->address2}}" placeholder="">
    </div>
</div>

<div class="Complete-address">
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half">
            <label for="City">City</label>
            <input disabled type="text"  name="account[city]" id="City" value="{{$order->has_sender->city}}" placeholder="">
        </div>
    </div>
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half adj">
            <label for="State">State</label>
            <input disabled type="text"  name="account[state]" id="State" value="{{$order->has_sender->state}}" placeholder="">
        </div>
    </div>
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half">
            <label for="PosteCode">Zip Code</label>
            <input disabled type="text"  name="account[postecode]" id="PosteCode" value="{{$order->has_sender->postcode}}" placeholder="">
        </div>
    </div>

</div>
<div class="custom_fields_half">
    <div class="custom_Request_fields_half">
        <label for="Country">Country</label>
        <input disabled type="text"  name="account[country]" id="Country" value="{{$order->has_sender->country}}" placeholder="">
    </div>
</div>

<div class="custom_fields_half">
    <div class="custom_Request_fields_half Get-contect-right">
        <label for="Phone">Phone</label>
        <input disabled type="text"  name="account[phone]" id="Phone" value="{{$order->has_sender->phone}}" placeholder="">
    </div>
</div>
