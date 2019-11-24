<div class="custom_fields_half associate">
    <div class="custom_Request_fields_half">
        <label for="AddressCountryNew" >Country</label>
        <select required class="AddressCountryNew2" name="country" @if($address->country != null) data-country-select="{{ $address->country }}"  data-province-select="{{$address->state}}" @endif>
            @include('customers.inc.countries')
        </select>
    </div>
</div>

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


<div class="custom_fields_half" style="display: none;">
    <div class="custom_Request_fields_half">
        <label for="Business">Business</label>
        <input type="text"  name="business" id="Business" value="{{$address->business}}" placeholder="">
    </div>
</div>

<div class="custom_fields_half">
    <div class="custom_Request_fields_half">
        <label for="Address1">Address1</label>
        <input type="text" required="" name="address1" id="Address1" value="{{$address->address1}}" placeholder="">
        <input style="margin-top: 0;" type="text"  name="address2" id="Address2" value="{{$address->address2}}" placeholder="">
    </div>
</div>

<div class="Complete-address">
    <div id="city_div" class="custom_fields_half full_width_iput">
        <div class="custom_Request_fields_half">
            <label for="City">City</label>
            <input type="text" required="" name="city" id="City" value="{{$address->city}}" placeholder="">
        </div>
    </div>
    <div id="province_div" class="custom_fields_half associate full_width_iput">
        <div class="custom_Request_fields_half adj">
            <label for="AddressProvinceNew">Province or State</label>
            <select class="AddressProvinceNew2" name="province" autocomplete="address-level1">
                @include('customers.inc.usa_states')
            </select>
        </div>
    </div>

    <div id="postal_div" class="custom_fields_half full_width_iput">
        <div class="custom_Request_fields_half">
            <label for="PosteCode">Zip Code</label>
            <input type="text" required="" name="postcode" id="PosteCode" value="{{$address->postcode}}" placeholder="">
        </div>
    </div>

</div>




