<form id="place_order_form" action="/place/order" method="GET">

    <input type="hidden" value="{{$customer_id}}" name="customer_id">
<div class="page-double-left equ">
    <div class="Form-wraper">
        <div class="Form-contaner">
            <div class="Form-content-header">
                <h1 class="Form-content-header-Head">Address Details  <a href="/account/addresses?view=new" style="margin-left:10px;padding:10px 10px" class="Same-button" >Add New Address</a> </h1>
            </div>
            <div class="Form-field-contaner">
                <div class="Form-content-name">
                    <p> Sender Details </p>
                    <select class="addresses_select" id="sender_address_select"  name="sender-addresses" >
                        <option value="---">Select Sender Address</option>
                        @foreach($addresses as $address)
                            @if($address->address_type == "Sender")
                                <option @if($sender_address != null) @if($sender_address->id  == $address->id) selected @endif @endif  value="{{$address->id}}">{{$address->address1.' , '.$address->country}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="Form-content-detail">

                    <div class="Get-name">
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half  Get-name-left">
                                <label for="FirstName">First Name</label>
                                <input type="text" required="" name="sender_first_name" id="FirstName" @if($sender_address != null) value="{{$sender_address->first_name}}" @endif placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half Get-name-right">
                                <label for="LastName">Last Name</label>
                                <input type="text" required="" name="sender_last_name" id="LastName" @if($sender_address != null) value="{{$sender_address->last_name}}" @endif placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Business">Business</label>
                            <input type="text"  name="sender_business" id="Business" @if($sender_address != null) value="{{$sender_address->business}}" @endif placeholder="">
                        </div>
                    </div>
                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Address1">Address1</label>
                            <input type="text" required="" name="sender_address1" id="Address1" @if($sender_address != null) value="{{$sender_address->address1}}" @endif placeholder="">
                        </div>
                    </div>
                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Address2">Address2</label>
                            <input type="text"  name="sender_address2" id="Address2" @if($sender_address != null) value="{{$sender_address->address2}}" @endif placeholder="">
                        </div>
                    </div>

                    <div class="custom_fields_half associate">
                        <div class="custom_Request_fields_half">
                            <label for="AddressCountryNew">Country</label>
                            <select required class="AddressCountryNew" name="sender_country" @if($sender_address != null) data-country-select="{{ $sender_address->country }}"  data-province-select="{{$sender_address->state}}" @endif >
                                @include('customers.inc.countries')
                            </select>
                        </div>
                    </div>

                    <div class="Complete-address">
                        <div id="city_div" class="custom_fields_half">
                            <div class="custom_Request_fields_half">
                                <label for="City">City</label>
                                <input type="text" required="" name="sender_city" id="City" @if($sender_address != null) value="{{$sender_address->city}}" @endif placeholder="">
                            </div>
                        </div>
                        <div id="province_div" class="custom_fields_half hide associate">
                            <div class="custom_Request_fields_half adj">
                                <label for="AddressProvinceNew">State</label>
                                <select class="AddressProvinceNew" name="sender_state" autocomplete="address-level1"></select>
                            </div>
                        </div>

                        <div id="postal_div" class="custom_fields_half">
                            <div class="custom_Request_fields_half">
                                <label for="PosteCode">Zip Code</label>
                                <input type="text" required="" name="sender_postecode" id="PosteCode" @if($sender_address != null) value="{{$sender_address->postcode}}" @endif placeholder="">
                            </div>
                        </div>

                    </div>

                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half Get-contect-right">
                            <label for="Phone">Phone</label>
                            <input type="text" required="" name="sender_phone" id="Phone" @if($sender_address != null) value="{{$sender_address->phone}}" @endif placeholder="">
                        </div>
                    </div>


                </div>


            </div>
            <div class="Form-field-contaner">

                <div class="Form-content-name">
                    <p>Billing Details</p>

                    <select class="addresses_select" id="billing_address_select" name="billing-addresses" >
                        <option value="---">Select Billing Address</option>
                        @foreach($addresses as $address)
                            @if($address->address_type == "Billing")
                                <option @if($billing_address != null) @if($billing_address->id  == $address->id) selected @endif @endif  value="{{$address->id}}">{{$address->address1.' , '.$address->country}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="Form-content-detail">

                    <div class="Get-name">
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half  Get-name-left">
                                <label for="FirstName">First Name</label>
                                <input type="text" required="" name="billing_first_name" id="FirstName" @if($billing_address != null) value="{{$billing_address->first_name}}" @endif placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half Get-name-right">
                                <label for="LastName">Last Name</label>
                                <input type="text" required="" name="billing_last_name" id="LastName" @if($billing_address != null) value="{{$billing_address->last_name}}" @endif placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Business">Business</label>
                            <input type="text"  name="billing_business" id="Business" @if($billing_address != null) value="{{$billing_address->business}}" @endif placeholder="">
                        </div>
                    </div>
                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Address1">Address1</label>
                            <input type="text" required="" name="billing_address1" id="Address1" @if($billing_address != null) value="{{$billing_address->address1}}" @endif placeholder="">
                        </div>
                    </div>
                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Address2">Address2</label>
                            <input type="text"  name="billing_address2" id="Address2" @if($billing_address != null) value="{{$billing_address->address2}}" @endif placeholder="">
                        </div>
                    </div>

                    <div class="custom_fields_half associate">
                        <div class="custom_Request_fields_half">
                            <label for="AddressCountryNew">Country</label>
                            <select required class="AddressCountryNew" name="billing_country" @if($billing_address != null) data-country-select="{{ $billing_address->country }}"  data-province-select="{{$billing_address->state}}" @endif >
                                @include('customers.inc.countries')
                            </select>
                        </div>
                    </div>


                    <div class="Complete-address">
                        <div id="city_div" class="custom_fields_half">
                            <div class="custom_Request_fields_half">
                                <label for="City">City</label>
                                <input type="text" required="" name="billing_city" id="City" @if($billing_address != null) value="{{$billing_address->city}}" @endif placeholder="">
                            </div>
                        </div>
                        <div id="province_div" class="custom_fields_half hide associate ">
                            <div class="custom_Request_fields_half adj">
                                <label for="AddressProvinceNew">State</label>
                                <select class="AddressProvinceNew" name="billing_state" autocomplete="address-level1"></select>
                            </div>
                        </div>

                        <div id="postal_div" class="custom_fields_half">
                            <div class="custom_Request_fields_half">
                                <label for="PosteCode">Postal Code</label>
                                <input type="text" required="" name="billing_postecode" id="PosteCode" @if($billing_address != null) value="{{$billing_address->postcode}}" @endif placeholder="">
                            </div>
                        </div>

                    </div>



                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half Get-contect-right">
                            <label for="Phone">Email</label>
                            <input type="text" required="" name="billing_email" id="Phone" @if($billing_address != null) value="{{$billing_address->email}}" @endif placeholder="">
                        </div>
                    </div>

                </div>


            </div>

            <div class="Form-field-contaner" style="display:none">
                <div class="Form-content-name" >
                    <p>Shipping Quotes</p>
                </div>

                <div class="Form-content-detail">

                    <div class="order-Invoice">

                        <div class="order-id-field" >
                            <div class="custom_fields_half">
                                <div class="custom_Request_fields_half ">
                                    <label for="Type">Shipping Methods</label>
                                    <select id="shipping_method_select" name="shipping_method" form="Type">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="order-invoice-detail" >
                            <div class="order-invoice-product">
                                <p class="invoice-text "> Shipment Cost</p>
                            </div>
                            <div class="order-invoice-price">
                                <p class="invoice-Money ">$150</p>
                            </div>
                        </div>

                        <div class="order-invoice-detail" >
                            <div class="order-invoice-product">
                                <p class="invoice-text " >PostDelay Cost</p>
                            </div>
                            <div class="order-invoice-price">
                                <p class="invoice-Money ">$50</p>
                            </div>
                        </div>

                        <div class="order-invoice-detail" >
                            <div class="order-invoice-tex">
                                <p class="invoice-text"  >Tax</p>
                            </div>
                            <div class="order-invoice-Tax-money">
                                <p class="invoice-Money" style="text-align:right">$50</p>
                            </div>
                        </div>



                    </div>

                    <div class="order-Invoice-total">

                        <div class="order-invoice-detail total" >
                            <div class="order-total-text">
                                <p class="invoice-text" style="text-align: left">Total</p>
                            </div>
                            <div class="order-total-money">
                                <p class="invoice-Money total" style="text-align: right">$210</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="page-double-right equ">
    <div class="Form-wraper" style="margin-top: 45px">
        <div class="Form-contaner">

            <div class="Form-field-contaner">
                <div class="Form-content-name">
                    <p>Receipent Details</p>
                    <select class="addresses_select" id="receipent_address_select" name="receipent-addresses" >
                        <option value="---">Select Receipent Address</option>
                        @foreach($addresses as $address)
                            @if($address->address_type == "Recipients")
                                <option @if($recipient_address != null) @if($recipient_address->id  == $address->id) selected @endif @endif value="{{$address->id}}">{{$address->address1.' , '.$address->country}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="Form-content-detail">

                    <div class="Get-name">
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half  Get-name-left">
                                <label for="FirstName">First Name</label>
                                <input type="text" required="" name="receipent_first_name" id="FirstName" @if($recipient_address != null) value="{{$recipient_address->first_name}}" @endif placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half Get-name-right">
                                <label for="LastName">Last Name</label>
                                <input type="text" required="" name="receipent_last_name" id="LastName" @if($recipient_address != null) value="{{$recipient_address->last_name}}" @endif placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Business">Business</label>
                            <input type="text" required="" name="receipent_business" id="Business" @if($recipient_address != null) value="{{$recipient_address->business}}" @endif placeholder="">
                        </div>
                    </div>
                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Address1">Address1</label>
                            <input type="text" required="" name="receipent_address1" id="Address1" @if($recipient_address != null) value="{{$recipient_address->address1}}" @endif placeholder="">
                        </div>
                    </div>
                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Address2">Address2</label>
                            <input type="text"  name="receipent_address2" id="Address2" @if($recipient_address != null) value="{{$recipient_address->address2}}" @endif placeholder="">
                        </div>
                    </div>

                    <div class="custom_fields_half associate">
                        <div class="custom_Request_fields_half">
                            <label for="AddressCountryNew">Country</label>
                            <select required class="AddressCountryNew" name="receipent_country" @if($recipient_address != null) data-country-select="{{ $recipient_address->country }}"  data-province-select="{{$recipient_address->state}}" @endif >
                                @include('customers.inc.countries')
                            </select>
                        </div>
                    </div>

                    <div class="Complete-address">
                        <div id="city_div" class="custom_fields_half">
                            <div class="custom_Request_fields_half">
                                <label for="City">City</label>
                                <input type="text" required="" name="receipent_city" id="City" @if($recipient_address != null) value="{{$recipient_address->city}}" @endif placeholder="">
                            </div>
                        </div>
                        <div id="province_div" class="custom_fields_half hide associate">
                            <div class="custom_Request_fields_half adj">
                                <label for="AddressProvinceNew">State</label>
                                <select class="AddressProvinceNew" name="receipent_state" autocomplete="address-level1"></select>
                            </div>
                        </div>


                        <div id="postal_div" class="custom_fields_half">
                            <div class="custom_Request_fields_half">
                                <label for="PosteCode">Postal Code</label>
                                <input type="text" required="" name="receipent_postecode" id="PosteCode" @if($recipient_address != null) value="{{$recipient_address->postcode}}" @endif placeholder="">
                            </div>
                        </div>

                    </div>

                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half Get-contect-right">
                            <label for="Phone">Phone</label>
                            <input type="text" required="" name="receipent_phone" id="phone" @if($recipient_address != null) value="{{$recipient_address->phone}}" @endif placeholder="">
                        </div>
                    </div>


                </div>

            </div>
            <div class="Form-field-contaner">
                <div class="Form-content-name">
                    <p>Shipment Details</p>
                </div>

                <div class="Form-content-detail">

                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half  ">
                            <label for="TypeSelect">Type</label>
                            <select required id="TypeSelect" name="post_type">
                                @foreach($types as $type)
                                    <option value="{{$type->name}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Special-Holding">Special Handling</label>
                            <select id="Special-Holding" name="special_holding" >
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>

                        </div>
                    </div>

                    <div class="custom_fields_half" id="shape_input">
                        <div class="custom_Request_fields_half  ">
                            <label for="Shape">Shape</label>
                            <select  name="shape" >
                                @foreach($shapes as $shape)
                                    <option value="{{$shape->name}}">{{$shape->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Shape">Unit of Measure</label>
                            <select name="unit_of_measures">
                               @foreach($scales as $scale)
                                    <option value="{{$scale->name}}">{{$scale->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="three-field-Row">
                        <div class="custom_fields_half" id="weight_input" >
                            <div class="custom_Request_fields_half">
                                <label for="Weight">Weight (grams)</label>
                                <input type="text" name="weight" id="City" value="" placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half" id="height_input">
                            <div class="custom_Request_fields_half adj">
                                <label for="Height">Height</label>
                                <input type="text" name="height" id="State" value="" placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half" id="length_input">
                            <div class="custom_Request_fields_half">
                                <label for="length">Length</label>
                                <input type="text" required="" name="length" id="PosteCode" value="" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="tow-field-Row" >
                        <div class="custom_fields_half" id="width_input">
                            <div class="custom_Request_fields_half tow-field-Row-left">
                                <label for="width">Width</label>
                                <input type="text" required="" name="width" id="Country" value="" placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half" id="girth_input">
                            <div class="custom_Request_fields_half tow-field-Row-right">
                                <label for="Girth">Girth</label>
                                <input type="text"  name="girth" id="Country" value="" placeholder="">
                            </div>
                        </div>
                    </div>


                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half  ">
                            <label for="Shape">Ship Out Date</label>
                            <input type="date" required="" name="ship_out_date" id="Country" value="" placeholder="">
                        </div>
                    </div>

                    <input type="submit" class="Same-button" value="Place Order">
                </div>

            </div>
            <div class="Form-field-contaner" style="display: none">
                <div class="Form-content-detail">
                    <div class="three-field-Row" >
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half tow-field-Row-left ">
                                <label for="Order ID">Card Number</label>
                                <input type="text"  name="card_no" id="FirstName" value="" placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half tow-field-Row-right">
                                <label for="Order ID">Card Expiry</label>
                                <input type="text"  name="card_expires" id="FirstName" value="" placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half tow-field-Row-right">
                                <label for="Order ID">Card CVV</label>
                                <input type="text"  name="card_cvv" id="FirstName" value="" placeholder="">
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="Same-button" value="Checkout">
                </div>
            </div>
        </div>
    </div>
</div>
</form>
