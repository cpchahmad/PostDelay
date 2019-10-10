<form id="address_update_form" action="/update/address" method="GET">

    <input type="hidden" name="shopify_customer_id" value="{{$address->shopify_customer_id}}">
    <input type="hidden" name="shop" value="{{$address->has_Shop->shop_name}}">
    <input type="hidden" name="address_id" value="{{$address->id}}">

    <div class="custom_fields_half">
        <div class="custom_Request_fields_half " style="display: inline-block">
            <label for="FirstName">Address Type</label>
            <input style="display: inline-block;width: 50%" type="text" disabled required="" name="address_type" id="FirstName" value="{{$address->address_type}}" placeholder="">
            <span id="set_all_addresses_button" data-address-id="{{$address->id}}" style="cursor:pointer;display: inline-block;width: 49.2%"  class="Same-button" >Set all addresses to this</span>

        </div>
    </div>
    <div class="Get-name">
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half  ">
            <label for="FirstName">First Name</label>
            <input type="text" required="" name="first_name" id="FirstName" value="{{$address->first_name}}" placeholder="">
        </div>
    </div>


    <div class="custom_fields_half">
        <div class="custom_Request_fields_half ">
            <label for="LastName">Last Name</label>
            <input type="text" required="" name="last_name" id="LastName" value="{{$address->last_name}}" placeholder="">
        </div>
    </div>
    </div>

    <div class="Get-name">
        <div class="custom_fields_half">
            <div class="custom_Request_fields_half">
                <label for="Email">Email Address</label>
                <input type="email" required="" name="email" id="Email" value="{{$address->email}}" placeholder="">
            </div>
        </div>

        <div class="custom_fields_half">
            <div class="custom_Request_fields_half ">
                <label for="Phone">Phone Number</label>
                <input type="text" required="" name="phone" id="Phone" value="{{$address->phone}}" placeholder="">
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

    <div class="custom_fields_half associate">
        <div class="custom_Request_fields_half">
            <label for="AddressCountryNew">Country</label>
            <select required class="AddressCountryNew" name="country" @if($address != null) data-country-select="{{ $address->country }}"  data-province-select="{{$address->state}}" @endif>
                @include('customers.inc.countries')
            </select>
        </div>
    </div>

    <div class="Complete-address">
        <div id="city_div" class="custom_fields_half">
            <div class="custom_Request_fields_half">
                <label for="City">City</label>
                <input type="text" required="" name="city" id="City" value="{{$address->city}}" placeholder="">
            </div>
        </div>
        <div id="province_div" class="custom_fields_half hide associate">
            <div class="custom_Request_fields_half adj">
                <label for="AddressProvinceNew">State</label>
                <select class="AddressProvinceNew" name="state" autocomplete="address-level1"></select>
            </div>
        </div>

        <div id="postal_div" class="custom_fields_half">
            <div class="custom_Request_fields_half">
                <label for="PosteCode">Postal Code</label>
                <input type="text" required="" name="postcode" id="PosteCode" value="{{$address->postcode}}" placeholder="">
            </div>
        </div>

    </div>

    <div class="custom_Button-contaner">
        <input type="submit" class="Same-button" value="Update">
        <input id="remove_address_button" data-address-id="{{$address->id}}" style="cursor:pointer" type="button" class="Same-button" value="Delete">
    </div>


</form>
