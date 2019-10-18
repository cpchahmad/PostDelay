
<div class="Get-name">
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half  Get-name-left">
            <label for="FirstName">First Name</label>
            <input type="text" required="" name="first_name" id="FirstName" value="{{$address->first_name}}" placeholder="">
        </div>
    </div>
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half Get-name-right">
            <label for="LastName">Last Name</label>
            <input type="text" required="" name="last_name" id="LastName" value="{{$address->last_name}}" placeholder="">
        </div>
    </div>
</div>


<div class="custom_fields_half">
    <div class="custom_Request_fields_half">
        <label for="Business">Business</label>
        <input type="text"  name="business" id="Business" value="{{$address->business}}" placeholder="">
    </div>
</div>

<div class="custom_fields_half">
    <div class="custom_Request_fields_half">
        <label for="Address1">Address1</label>
        <input type="text" required="" name="address1" id="Address1" value="{{$address->address1}}" placeholder="">
    </div>
</div>

<div class="custom_fields_half">
    <div class="custom_Request_fields_half">
        <label for="Address2">Address2</label>
        <input type="text"  name="address2" id="Address2" value="{{$address->address2}}" placeholder="">
    </div>
</div>

<div class="Complete-address">
    <div id="city_div" class="custom_fields_third">
        <div class="custom_Request_fields_half">
            <label for="City">City</label>
            <input type="text" required="" name="city" id="City" value="{{$address->city}}" placeholder="">
        </div>
    </div>

    <div id="province_div" class="custom_fields_third ">
        <div class="custom_Request_fields_half adj">
            <label for="AddressProvinceNew">State</label>
            <input type="text"  name="state" id="State" value="{{$address->state}}" placeholder="">
        </div>
    </div>

    <div id="postal_div" class="custom_fields_third">
        <div class="custom_Request_fields_half">
            <label for="PosteCode">Zip Code</label>
            <input type="text" required="" name="postcode" id="PosteCode" value="{{$address->postcode}}" placeholder="">
        </div>
    </div>
</div>

<div class="custom_fields_half">
    <div class="custom_Request_fields_half">

        <label for="AddressCountryNew">Country</label>
        <input type="text" required="" name="country" id="City" value="{{$address->country}}" placeholder="">
    </div>
    <div id="country-status"></div>
</div>





