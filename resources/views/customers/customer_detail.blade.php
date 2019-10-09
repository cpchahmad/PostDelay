<form id="update_customer_details_form" action="/customer/update" method="get">

    <input type="hidden" name="customer_id" value="{{$customer->shopify_customer_id}}">
    <input type="hidden" name="shop" value="{{ $customer->has_shop->shop_name }}">
    <div class="Get-name">
        <div class="custom_fields_half">
            <div class="custom_Request_fields_half  Get-name-left">
                <label for="FirstName">First Name</label>
                <input type="text" required="" name="first_name" id="FirstName" value="{{$customer->first_name}}" placeholder="">
            </div>
        </div>
        <div class="custom_fields_half">
            <div class="custom_Request_fields_half Get-name-right">
                <label for="LastName">Last Name</label>
                <input type="text" required="" name="last_name" id="LastName" value="{{$customer->last_name}}" placeholder="">
            </div>
        </div>
    </div>

    <div class="custom_fields_half">
        <div class="custom_Request_fields_half">
            <label for="Business">Business</label>
            <input type="text"  name="business" id="Business" value="{{$customer->business}}" placeholder="">
        </div>
    </div>
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half">
            <label for="Address1">Address1</label>
            <input type="text" required="" name="address1" id="Address1" value="{{$customer->address1}}" placeholder="">
        </div>
    </div>
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half">
            <label for="Address2">Address2</label>
            <input type="text"   id="Address2" value="{{$customer->address2}}" placeholder="">
        </div>
    </div>

    <div class="custom_fields_half associate">
        <div class="custom_Request_fields_half">
        <label for="AddressCountryNew" >Country</label>
        <select required class="AddressCountryNew" name="country" @if($customer != null) data-country-select="{{ $customer->country }}"  data-province-select="{{$customer->state}}" @endif>
            @include('customers.inc.countries')
        </select>
    </div>
    </div>
    <div class="Complete-address">
        <div id="city_div" class="custom_fields_half">
            <div class="custom_Request_fields_half">
                <label for="City">City</label>
                <input type="text" required="" name="city" id="City" value="{{$customer->city}}" placeholder="">
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
                <input type="text" required="" name="postecode" id="PosteCode" value="{{$customer->postcode}}" placeholder="">
            </div>
        </div>

    </div>
    <div class="tow-field-Row">
        <div class="custom_fields_half">
            <div class="custom_Request_fields_half  Get-contect-left">
                <label for="Email">Email</label>
                <input readonly type="email"  name="email" id="Email" value="{{$customer->email}}" placeholder="">
            </div>
        </div>
        <div class="custom_fields_half">
            <div class="custom_Request_fields_half Get-contect-right">
                <label for="Phone">Phone</label>
                <input type="text" required="" name="phone" id="Phone" value="{{ $customer->phone }}" placeholder="">
            </div>
        </div>
    </div>

    <div class="tow-field-Row">
        <div class="custom_Button-contaner">
            <input type="submit" class="Same-button" value="SAVE">
        </div>

        <div class="custom_Button-contaner ">
            <a  id="change-password" style="cursor: pointer" class="Same-button" >CHANGE PASSWORD</a>
        </div>


        <div class="custom_Button-contaner cng-btn">
            <a style="cursor: pointer" class="Same-button" >DELETE ACCOUNT</a>
        </div>

    </div>
    <div class="form-message form-message--success hide" id="RecoverPasswordStatus" tabindex="-1">

    </div>

</form>

<div class="add-rem-address ">
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half  ">
            <label for="billing_address">Saved Billing Address</label>
            <select class="" name="billing_address" id="billing_address" >
                @foreach($addresses as $address)
                    @if($address->address_type == "Billing")
                        <option @if($address->default == 1) selected @endif value="{{$address->id}}"> {{$address->address1}} @if($address->default == 1) (Default) @endif </option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="tow-field-Row">
        <div class="custom_Button-contaner">
            <a id="billing_address_button" style="cursor: pointer" class="Same-button" >ADD</a>
        </div>

        <div class="custom_Button-contaner cng-btn">
            <a id="billing_address_remove_button"   style="cursor: pointer" class="Same-button" >REMOVE</a>
        </div>
    </div>
</div>
<div class="add-rem-address ">
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half  ">
            <label for="recipients_address">Saved Recipient Address</label>
            <select class="" name="recipients_address" id="recipients_address" >
                @foreach($addresses as $address)
                    @if($address->address_type == "Recipients")
                        <option @if($address->default == 1) selected @endif value="{{$address->id}}"> {{$address->address1}} @if($address->default == 1) (Default) @endif </option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="tow-field-Row">
        <div class="custom_Button-contaner">
            <a id="recipients_address_button"  style="cursor: pointer" class="Same-button" >ADD</a>
        </div>

        <div class="custom_Button-contaner cng-btn">
            <a id="recipients_address_remove_button"  style="cursor: pointer" class="Same-button" >REMOVE</a>
        </div>
    </div>
</div>
<div class="add-rem-address ">
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half  ">
            <label for="sender_address">Saved Sender Address</label>
            <select class="" name="sender_address" id="sender_address">
                @foreach($addresses as $address)
                    @if($address->address_type == "Sender")
                        <option @if($address->default == 1) selected @endif value="{{$address->id}}"> {{$address->address1}} @if($address->default == 1) (Default) @endif </option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="tow-field-Row">
        <div class="custom_Button-contaner">
            <a id="sender_address_button"  style="cursor: pointer" class="Same-button" >ADD</a>
        </div>

        <div class="custom_Button-contaner cng-btn">
            <a id="sender_address_remove_button"   style="cursor: pointer" class="Same-button" >REMOVE</a>
        </div>
    </div>
</div>
