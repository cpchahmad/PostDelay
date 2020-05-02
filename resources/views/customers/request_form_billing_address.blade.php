<div class="custom_fields_half">
    <div class="custom_Request_fields_half">

        <label for="AddressCountryNew">Country</label>
        <select required class="AddressCountryNew country_select" name="country" @if($address != null) data-country-select="{{ $address->country }}"  data-province-select="{{$address->state}}" @endif>
                @include('customers.inc.countries')
        </select>
    </div>
    <div id="country-status"></div>
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
<div class="custom_fields_half full_width_iput">
    <div class="custom_Request_fields_half">
        <label for="Address1">Address1</label>
        <input type="text" id="autocomplete" class="autocomplete" required="" name="address1"  value="{{$address->address1}}" placeholder="">
        <input type="hidden" value="{{$address->address2}}" placeholder="">
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
            <input type="text"  name="state" id="administrative_area_level_1" value="{{$address->state}}" placeholder="">
        </div>
    </div>

    <div id="postal_div" class="custom_fields_third">
        <div class="custom_Request_fields_half">
            <label for="PosteCode">Zip Code</label>
            <input type="text" required="" name="postcode" id="PosteCode" value="{{$address->postcode}}" placeholder="">
        </div>
    </div>
</div>
@if($response != null)
<div id="additional_payment_section">
    <div class="Form-field-contaner shipping_calculations" style="display:none;">
        <div class="Form-content-name" >
            <p>Shipping Quotes</p>
        </div>
        <div class="Form-content-detail">
            <div class="order-Invoice">
                <div class="order-id-field" >

                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half ">
                            <label for="Type">Original Shipping rate for testing only</label>
                            <select id="shipping_method_selects2">
                            </select>

                        </div>
                    </div>
                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half ">
                            <label for="Type">Shipping Methods</label>
                            <select id="shipping_method_select" name="shipping_method">
                            </select>
                        </div>
                    </div>
                </div>

                <div class="order-invoice-detail" >
                    <div class="order-invoice-product">
                        <p class="invoice-text ">Shipment Cost</p>
                    </div>
                    <div class="order-invoice-price">
                        <input type="hidden" name="new_shipping_price" class="caclulated_amount">
                        <p class="invoice-Money dropdown-rates">Select from Dropdown</p>
                    </div>
                </div>

                <div class="order-invoice-detail" >
                    <div class="order-invoice-product">
                        <p class="invoice-text " >PostDelay Cost</p>
                    </div>
                    <div class="order-invoice-price">
                        <input type="hidden" class="caclulated_amount" name="new_postdelay_fee" value="{{ number_format($fee->price,2) }}">
                        <p class="invoice-Money ">${{ number_format($fee->price,2) }}</p>
                    </div>
                </div>

                <div class="order-invoice-detail" style="display: none;">
                    <div class="order-invoice-tex">
                        <p class="invoice-text"  >Tax</p>
                    </div>
                    <div class="order-invoice-Tax-money">
                        <input type="hidden" class="caclulated_amount" name="new_tax_fee" value="0">
                        <p class="invoice-Money " style="text-align:right">Calculated on Checkout Page</p>
                    </div>
                </div>



            </div>

            <div class="order-Invoice-total">

                <div class="order-invoice-detail total" >
                    <div class="order-total-text">
                        <p class="invoice-text" style="text-align: left">Total</p>
                    </div>
                    <div class="order-total-money">
                        <input type="hidden" class="" name="new_total_fee" value="{{ number_format($fee->price,2) }}">
                        <p class="invoice-Money total" style="text-align: right">${{ number_format($fee->price,2) }}</p>
                    </div>
                </div>

            </div>
            <div class="">
                <input type="submit" value="PLACE ORDER" class="Same-button final_submit_button">
            </div>

        </div>
    </div>
</div>
@endif





