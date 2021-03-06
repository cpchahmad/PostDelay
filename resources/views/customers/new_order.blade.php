<form id="get_shipping_rates" class="place_order_form" action="/get_shipping_rates" method="GET">
    <input type="hidden" id="modification" value="empty">
    <input type="hidden" value="{{$customer_id}}" name="customer_id">
    <input type="hidden" id="shopify_product_id" name="product_id" value="">
    <div class="page-double-left equ">
        <div class="Form-wraper">
            <div class="Form-contaner">
                <div class="Form-content-header">
                    <h1 class="Form-content-header-Head">Address Details  {{--<a href="/account/addresses?view=new" style="margin-left:10px;padding:10px 10px;line-height: 1" class="Same-button" >Add New Address</a>--}} </h1>
                </div>
                <div class="Form-field-contaner">
                    <div class="Form-content-detail">
                        <div class="Form-content-name">
                            <p> Sender Details  <a href="/account/addresses?view=new&&type=Sender" style="margin-left:10px;padding:10px 10px;line-height: 1" class="Same-button" >Add Sender Address</a>  </p>

                            <select class="addresses_select modify" id="sender_address_select"  name="sender-addresses" >
                                <option value="---">Select Sender Address</option>
                                @foreach($addresses as $address)
                                    @if($address->address_type == "Sender")
                                        <option @if($sender_address != null) @if($sender_address->id  == $address->id) selected @endif @endif  value="{{$address->id}}">{{$address->first_name.' '.$address->last_name.', '. $address->address1.' , '.$address->address2.', '.$address->city.', '.$address->state.', '.$address->country.', '.$address->postcode}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="custom_fields_half associate">
                            <div class="custom_Request_fields_half">
                                <label for="AddressCountryNew">Country</label>
                                <select required class="AddressCountryNew modify country_select" name="sender_country" @if($sender_address != null) data-country-select="{{ $sender_address->country }}"  data-province-select="{{$sender_address->state}}" @else data-country-select="United States" @endif >
                                    @include('customers.inc.countries')
                                </select>
                            </div>
                        </div>

                        <div class="Get-name">
                            <div class="custom_fields_half">
                                <div class="custom_Request_fields_half  Get-name-left">
                                    <label for="FirstName">First Name</label>
                                    <input class="modify" type="text" required="" name="sender_first_name"  @if($sender_address != null) value="{{$sender_address->first_name}}" @endif placeholder="">
                                </div>
                            </div>
                            <div class="custom_fields_half">
                                <div class="custom_Request_fields_half Get-name-right">
                                    <label for="LastName">Last Name</label>
                                    <input class="modify" type="text" required="" name="sender_last_name"  @if($sender_address != null) value="{{$sender_address->last_name}}" @endif placeholder="">
                                </div>
                            </div>
                        </div>

                        {{--                    <div class="custom_fields_half" style="display: none;">--}}
                        {{--                        <div class="custom_Request_fields_half">--}}
                        {{--                            <label for="Business">Business</label>--}}
                        {{--                            <input class="modify" type="text"  name="sender_business"  @if($sender_address != null) value="{{$sender_address->business}}" @endif placeholder="">--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                        <div class="custom_fields_half full_width_iput">
                            <div class="custom_Request_fields_half">
                                <label for="Address1">Street Address</label>
                                <input type="hidden" value="sender">
                                <input  type="text" id="sender_address_autocomplete"  class="autocomplete modify" @if($sender_address != null) value="{{$sender_address->address1}}" @endif placeholder="Street and number, P.O. box, c/o.">
                                <input class="modify" type="hidden" required="" name="sender_address1"  @if($sender_address != null) value="{{$sender_address->address1}}" @endif placeholder="Street and number, P.O. box, c/o.">
                                {{--<label for="Address2">Address2</label>--}}
                                <input class="modify" style="margin-bottom:25px;margin-top:10px;" type="text"  name="sender_address2"  @if($sender_address != null) value="{{$sender_address->address2}}" @endif placeholder="Apartment, suite, unit, building, floor, etc.">
                            </div>
                        </div>

                        <div class="Complete-address">
                            <div id="city_div" class="custom_fields_half full_width_iput">
                                <div class="custom_Request_fields_half">
                                    <label for="City">City</label>
                                    <input class="modify" type="text" required="" name="sender_city"  @if($sender_address != null) value="{{$sender_address->city}}" @endif placeholder="">
                                </div>
                            </div>
                            <div id="province_div" class="custom_fields_half full_width_iput">
                                <div class="custom_Request_fields_half adj">
                                    <label for="AddressProvinceNew">Province or State</label>
                                    {{--                                <select  class="AddressProvinceNew2 modify" name="sender_state" autocomplete="address-level1">--}}
                                    {{--                               @include('customers.inc.usa_states')--}}
                                    {{--                                </select>--}}
                                    <input type="text" class="AddressProvinceNew2" name="sender_state" id="administrative_area_level_1" autocomplete="address-level1">

                                </div>
                            </div>

                            <div id="postal_div" class="custom_fields_half full_width_iput">
                                <div class="custom_Request_fields_half">
                                    <label for="PosteCode">Zip Code</label>
                                    <input class="modify" type="text" required="" name="sender_postecode"  @if($sender_address != null) value="{{$sender_address->postcode}}" @endif placeholder="">
                                </div>
                            </div>

                        </div>


                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half Get-contect-right">
                                <label for="Phone">Phone</label>
                                <input class="modify" type="text"  name="sender_phone" id="Phone" @if($sender_address != null) value="{{$sender_address->phone}}" @endif placeholder="">
                            </div>
                        </div>


                    </div>


                </div>
                <div class="Form-field-contaner">
                    <div class="Form-content-detail">
                        <div class="Form-content-name">
                            <p>Billing Details
                                <a href="/account/addresses?view=new&&type=Billing" style="margin-left:10px;padding:10px 10px;line-height: 1" class="Same-button" >Add Billing Address</a></p>

                            <select class="addresses_select modify" id="billing_address_select" name="billing-addresses">
                                <option value="---">Select Billing Address</option>
                                @foreach($addresses as $address)
                                    @if($address->address_type == "Billing")
                                        <option @if($billing_address != null) @if($billing_address->id  == $address->id) selected @endif @endif  value="{{$address->id}}">{{$address->first_name.' '.$address->last_name.', '.$address->address1.' , '.$address->address2.', '.$address->city.', '.$address->state.', '.$address->country.', '.$address->postcode}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="custom_fields_half associate">
                            <div class="custom_Request_fields_half">
                                <label for="AddressCountryNew">Country</label>
                                <select required class="AddressCountryNew modify"  name="billing_country" @if($billing_address != null) data-country-select="{{ $billing_address->country }}"  data-province-select="{{$billing_address->state}}" @else data-country-select="United States" @endif >
                                    @include('customers.inc.countries')
                                </select>
                            </div>
                        </div>

                        <div class="Get-name">
                            <div class="custom_fields_half">
                                <div class="custom_Request_fields_half  Get-name-left">
                                    <label for="FirstName">First Name</label>
                                    <input class="modify" type="text" required="" name="billing_first_name"  @if($billing_address != null) value="{{$billing_address->first_name}}" @endif placeholder="">
                                </div>
                            </div>
                            <div class="custom_fields_half">
                                <div class="custom_Request_fields_half Get-name-right">
                                    <label for="LastName">Last Name</label>
                                    <input class="modify" type="text" required="" name="billing_last_name"  @if($billing_address != null) value="{{$billing_address->last_name}}" @endif placeholder="">
                                </div>
                            </div>
                        </div>

                        {{--                    <div class="custom_fields_half" style="display:none;">--}}
                        {{--                        <div class="custom_Request_fields_half">--}}
                        {{--                            <label for="Business">Business</label>--}}
                        {{--                            <input  type="text"  name="billing_business"  @if($billing_address != null) value="{{$billing_address->business}}" @endif placeholder="">--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                        <div class="custom_fields_half full_width_iput" >
                            <div class="custom_Request_fields_half">
                                <label for="Address1">Street Address</label>
                                <input type="hidden" value="billing">
                                <input type="text" id="billing_address_autocomplte" class="autocomplete modify" @if($billing_address != null) value="{{$billing_address->address1}}" @endif placeholder="Street and number, P.O. box, c/o.">

                                <input class="modify" type="hidden" required="" name="billing_address1"  @if($billing_address != null) value="{{$billing_address->address1}}" @endif placeholder="Street and number, P.O. box, c/o.">
                                <input class="modify" style="margin-bottom: 25px;margin-top:10px;" type="text"  name="billing_address2"  @if($billing_address != null) value="{{$billing_address->address2}}" @endif placeholder="Apartment, suite, unit, building, floor, etc.">
                            </div>
                        </div>


                        <div class="Complete-address">
                            <div id="city_div" class="custom_fields_half full_width_iput">
                                <div class="custom_Request_fields_half">
                                    <label for="City">City</label>
                                    <input class="modify" type="text" required="" name="billing_city"  @if($billing_address != null) value="{{$billing_address->city}}" @endif placeholder="">
                                </div>
                            </div>
                            <div id="province_div" class="custom_fields_half full_width_iput">
                                <div class="custom_Request_fields_half adj">
                                    <label for="AddressProvinceNew">Province or State</label>
                                    {{--                                <select  class="AddressProvinceNew2 modify" name="billing_state" autocomplete="address-level1">--}}
                                    {{--                                    @include('customers.inc.usa_states')--}}
                                    {{--                                </select>--}}
                                    <input type="text" class="AddressProvinceNew2" name="billing_state" id="administrative_area_level_1" autocomplete="address-level1">

                                </div>
                            </div>

                            <div id="postal_div" class="custom_fields_half full_width_iput">
                                <div class="custom_Request_fields_half">
                                    <label for="PosteCode">Zip Code</label>
                                    <input class="modify" type="text" required="" name="billing_postecode"  @if($billing_address != null) value="{{$billing_address->postcode}}" @endif placeholder="">
                                </div>
                            </div>

                        </div>



                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half Get-contect-right">
                                <label for="Phone">Phone</label>
                                <input class="modify" type="text"  name="billing_phone" id="Phone" @if($billing_address != null) value="{{$billing_address->email}}" @endif placeholder="">
                            </div>
                        </div>

                    </div>


                </div>

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
                                    <input type="hidden" class="caclulated_amount" data-price="{{$fee->price}}" name="new_postdelay_fee" value="{{ number_format($fee->price,2) }}">
                                    <p class="invoice-Money ">Calculated when you select shippping method</p>
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
        </div>
    </div>
    <div class="page-double-right equ">
        <div class="Form-wraper" style="margin-top: 36px">
            <div class="Form-contaner">

                <div class="Form-field-contaner">
                    <div class="Form-content-detail">
                        <div class="Form-content-name">
                            <p>Recipient Details
                                <i class="tooltip far fa-question-circle"> <span style="width: 320px;padding: 10px" class="tooltiptext">
                                       PostDelay can ship to USA, Canada, and Mexico. We accept sender addresses and billing addresses from any country.
                                             </span></i>
                                <a href="/account/addresses?view=new&&type=Recipients" style="margin-left:10px;padding:10px 10px;line-height: 1" class="Same-button" >Add Recipient Address</a> </p>
                            <select class="addresses_select modify" id="receipent_address_select" name="receipent-addresses" >
                                <option value="---">Select Recipient Address</option>
                                @foreach($addresses as $address)
                                    @if($address->address_type == "Recipients")
                                        <option @if($recipient_address != null) @if($recipient_address->id  == $address->id) selected @endif @endif value="{{$address->id}}">{{$address->first_name.' '.$address->last_name.', '. $address->address1.' , '.$address->address2.', '.$address->city.', '.$address->state.', '.$address->country.', '.$address->postcode}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="custom_fields_half associate">
                            <div class="custom_Request_fields_half">
                                <label for="AddressCountryNew">Country</label>
                                <select required class="AddressCountryNew modify" name="receipent_country" @if($recipient_address != null) data-country-select="{{ $recipient_address->country }}"  data-province-select="{{$recipient_address->state}}" @else data-country-select="United States" @endif >
                                    @include('customers.inc.reciepient_countries')
                                </select>
                            </div>
                        </div>


                        <div class="Get-name">
                            <div class="custom_fields_half">
                                <div class="custom_Request_fields_half  Get-name-left">
                                    <label for="FirstName">First Name</label>
                                    <input class="modify" type="text" required="" name="receipent_first_name"  @if($recipient_address != null) value="{{$recipient_address->first_name}}" @endif placeholder="">
                                </div>
                            </div>
                            <div class="custom_fields_half">
                                <div class="custom_Request_fields_half Get-name-right">
                                    <label for="LastName">Last Name</label>
                                    <input class="modify" type="text" required="" name="receipent_last_name"  @if($recipient_address != null) value="{{$recipient_address->last_name}}" @endif placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="custom_fields_half full_width_iput">
                            <div class="custom_Request_fields_half">
                                <label for="Address1">Street Address</label>
                                <input type="hidden" value="r">
                                <input type="text" id="recipient_address_autocomplte"  class="autocomplete modify" @if($recipient_address != null) value="{{$recipient_address->address1}}" @endif placeholder="Street and number, P.O. box, c/o.">
                                <input class="modify" type="hidden" required="" name="receipent_address1"  @if($recipient_address != null) value="{{$recipient_address->address1}}" @endif placeholder="Street and number, P.O. box, c/o.">
                                <input class="modify" style="margin-bottom:25px;margin-top:10px;" type="text"  name="receipent_address2"  @if($recipient_address != null) value="{{$recipient_address->address2}}" @endif placeholder="Apartment, suite, unit, building, floor, etc.">
                            </div>
                        </div>

                        <div class="Complete-address">
                            <div id="city_div" class="custom_fields_half full_width_iput">
                                <div class="custom_Request_fields_half">
                                    <label for="City">City</label>
                                    <input class="modify" type="text" required="" name="receipent_city"  @if($recipient_address != null) value="{{$recipient_address->city}}" @endif placeholder="">
                                </div>
                            </div>
                            <div id="province_div" class="custom_fields_half full_width_iput">
                                <div class="custom_Request_fields_half adj">
                                    <label for="AddressProvinceNew">Province or State</label>
                                    <input type="text" class="AddressProvinceNew2" name="receipent_state" id="administrative_area_level_1" autocomplete="address-level1">
                                </div>
                            </div>


                            <div id="postal_div" class="custom_fields_half full_width_iput">
                                <div class="custom_Request_fields_half">
                                    <label for="PosteCode">Zip Code</label>
                                    <input class="modify" type="text" required="" name="receipent_postecode"  @if($recipient_address != null) value="{{$recipient_address->postcode}}" @endif placeholder="">
                                </div>
                            </div>

                        </div>



                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half Get-contect-right">
                                <label for="Phone">Phone</label>
                                <input class="modify" type="text"  name="receipent_phone" id="phone" @if($recipient_address != null) value="{{$recipient_address->phone}}" @endif placeholder="">
                            </div>
                        </div>


                    </div>

                </div>
                <div class="Form-field-contaner shipment_details">
                    <div class="Form-content-detail">
                        <div class="Form-content-name">
                            <p>Shipment Details</p>
                        </div>

                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half  ">
                                <label for="TypeSelect">Type <i class="tooltip far fa-question-circle"> <span style="width: 320px;padding: 10px" class="tooltiptext">
                                            <span class="link-to-open" style="color: white;border-bottom: 1px solid black" data-href="{{asset('image1.jpg')}}"> Click to understand shipment types. </span> </span></i> </label>
                                <select class="modify" required id="TypeSelect" name="post_type">
                                    @foreach($types as $type)
                                        <option data-weight="{{ $type->weight }}" data-commission="{{ $type->commision_type }}" data-commission-type="{{ $type->commision }}" value="{{$type->name}}">{{ucwords(strtolower($type->name))}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="custom_fields_half" id="postcard_size">
                            <div class="custom_Request_fields_half">
                                <label for="Special-Holding">Size
                                    <i class="tooltip far fa-question-circle"> <span style="width: 500px;padding: 10px" class="tooltiptext">
                                            <ul>
                                                <li>Maximum size for regular postcard: 6 inches long by 4-1/4 inches high by .016 inch thick</li>
                                                <li>Maximum size for large postcard: 11-1/2 inches long by 6-1/8 inches high by 1/4 inch thick</li>
                                            </ul>
                                        </span>
                                    </i>
                                </label>
                                <select class="modify" id="postcard_size_select" name="postcard_size" >
                                    <option value="regular">Regular</option>
                                    <option value="large">Large</option>
                                </select>
                            </div>
                        </div>
                        <div class="custom_fields_half" id="special_handling">
                            <div class="custom_Request_fields_half">
                                <label for="Special-Holding">Special Handling <i class="tooltip far fa-question-circle"> <span style="width: 320px;padding: 10px" class="tooltiptext">
                                            <span class="link-to-open" style="color: white;border-bottom: 1px solid black" data-href="https://postdelay.myshopify.com/pages/when-is-special-handling-required"> Click here to understand when special handling is required. </span> </span></i>
                                </label>
                                <select class="modify" id="Special-Holding" name="special_holding" >
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>

                            </div>
                        </div>

                        <div class="custom_fields_half" id="shape_input">
                            <div class="custom_Request_fields_half  ">
                                <label for="Shape">Shape
                                    <i class="tooltip far fa-question-circle"> <span style="width: 320px;padding: 10px" class="tooltiptext">
                                            <span class="link-to-open" style="color: white;border-bottom: 1px solid black" data-href="{{asset('image2.jpg')}}"> Click to understand measurements for large packages. </span> </span></i>
                                </label>
                                <select class="modify" name="shape" >
                                    @foreach($shapes as $shape)
                                        <option value="{{$shape->name}}">{{$shape->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="custom_fields_half" style="display: none">
                            <div class="custom_Request_fields_half">
                                <label for="Shape">Unit of Measure</label>
                                <select class="modify" name="unit_of_measures">
                                    @foreach($scales as $scale)
                                        <option value="{{$scale->name}}">{{$scale->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="custom_fields_half" id="measures_input">
                            <div class="custom_Request_fields_half">
                                <label for="unit_of_measures_weight">Unit of Measure </label>
                                <select class="modify" name="unit_of_measures_weight">
                                    <option value="Standard">Standard</option>
                                    <option value="Metric">Metric</option>
                                </select>
                            </div>
                        </div>
                        <div class="custom_fields_half hide" id="weight_input" >
                            <div class="custom_Request_fields_half">
                                <label for="Weight">Kilograms<i class="tooltip far fa-question-circle"> <span style="padding: 10px" class="tooltiptext"></span></i></label>
                                <input class="modify" required type="number" step="any" name="weight"  value="" placeholder="">
                            </div>
                        </div>
                        <div class="tow-field-Row">
                            <div class="custom_fields_half" id="pounds_input" >
                                <div class="custom_Request_fields_half tow-field-Row-left">
                                    <label for="width">Pounds <i class="tooltip far fa-question-circle"> <span style="padding: 10px" class="tooltiptext"></span></i></label>
                                    <input class="modify" type="number" required="" step="any" name="pounds"  value="" placeholder="">
                                </div>
                            </div>
                            <div class="custom_fields_half " id="ounches_input" >
                                <div class="custom_Request_fields_half tow-field-Row-right">
                                    <label for="Girth">Ounces <i class="tooltip far fa-question-circle"> <span style="padding: 10px" class="tooltiptext"></span></i></label>
                                    <input class="modify" type="number" required  name="ounches" step="any"  value="" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="tow-field-Row">
                            <div class="custom_fields_half" id="height_input">
                                <div class="custom_Request_fields_half adj">
                                    <label for="Height">Height <i class="tooltip far fa-question-circle"> <span style="padding: 10px" class="tooltiptext"></span></i></label>
                                    <input class="modify" type="number" required step="any" name="height"  value="" placeholder="">
                                </div>
                            </div>
                            <div class="custom_fields_half" id="length_input">
                                <div class="custom_Request_fields_half">
                                    <label for="length">Length <i class="tooltip far fa-question-circle"> <span style="padding: 10px" class="tooltiptext"></span></i></label>
                                    <input class="modify" type="number" required="" step="any" name="length" value="" placeholder="" >
                                </div>
                            </div>
                        </div>

                        <div class="tow-field-Row" >
                            <div class="custom_fields_half" id="width_input">
                                <div class="custom_Request_fields_half tow-field-Row-left">
                                    <label for="width">Width <i class="tooltip far fa-question-circle"> <span style="padding: 10px" class="tooltiptext"></span></i></label>
                                    <input class="modify" type="number" required="" step="any" name="width"  value="" placeholder="">
                                </div>
                            </div>
                            <div class="custom_fields_half" id="girth_input">
                                <div class="custom_Request_fields_half tow-field-Row-right">
                                    <label for="Girth">Girth  <i class="tooltip far fa-question-circle"> <span style="padding: 10px" class="tooltiptext"></span></i></label>
                                    <input class="modify" type="number" required  name="girth" step="any"  value="" placeholder="">
                                </div>
                            </div>
                        </div>


                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half  ">
                                <label for="Shape">Send to your recipient on
                                    <i class="tooltip far fa-question-circle">
                                        <span style="width: 320px;padding: 10px" class="tooltiptext">This is the date that PostDelay will send the item to your recipient; it is not the day that the item will be received by the recipient. Choose a date far enough in advance that you item can be received and processed by PostDelay before the mail-out date. The minimum time between placing an order and the mail-out date is {{$settings->min_threshold_ship_out_date}} days.
                                             <span class="link-to-open" style="color: white;border-bottom: 1px solid black" data-href="https://postdelay.myshopify.com/pages/how-do-i-select-a-ship-out-date"> Click to understand U.S. Postal Service shipping times.</span></span></i></label>
                                <input class="modify" type="date" required="" name="ship_out_date" data-letters="{{(int)$settings->max_days_storage_for_letters_postcards}}"  data-packages="{{(int)$settings->max_days_storage_for_packages}}" value="" placeholder="" min="{{now()->addDays((int)$settings->min_threshold_ship_out_date)->format('Y-m-d')}}" max="{{now()->addDays((int)$settings->max_days_storage_for_letters_postcards)->format('Y-m-d')}}">
                            </div>
                        </div>

                        <input type="submit" class="Same-button qoute_button not-modified" value="GET QUOTE">
                    </div>

                </div>
                <div class="Form-field-contaner" style="display: none">
                    <div class="Form-content-detail">
                        <div class="three-field-Row" >
                            <div class="custom_fields_half">
                                <div class="custom_Request_fields_half tow-field-Row-left ">
                                    <label for="Order ID">Card Number</label>
                                    <input type="text"  name="card_no"  value="" placeholder="">
                                </div>
                            </div>
                            <div class="custom_fields_half">
                                <div class="custom_Request_fields_half tow-field-Row-right">
                                    <label for="Order ID">Card Expiry</label>
                                    <input type="text"  name="card_expires"  value="" placeholder="">
                                </div>
                            </div>
                            <div class="custom_fields_half">
                                <div class="custom_Request_fields_half tow-field-Row-right">
                                    <label for="Order ID">Card CVV</label>
                                    <input type="text"  name="card_cvv"  value="" placeholder="">
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
