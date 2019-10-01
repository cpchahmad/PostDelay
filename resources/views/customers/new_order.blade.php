<div class="page-double-left equ">
    <div class="Form-wraper">
        <div class="Form-contaner">
            <div class="Form-content-header">
                <h1 class="Form-content-header-Head">Address Details  <a href="/account/addresses?view=new" style="margin-left:10px;padding:10px 10px" class="Same-button" >Add New Address</a> </h1>
            </div>
            <div class="Form-field-contaner">
                <div class="Form-content-name">
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
                            <input type="text" required="" name="sender_business" id="Business" @if($sender_address != null) value="{{$sender_address->business}}" @endif placeholder="">
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
                            <input type="text" required="" name="sender_address2" id="Address2" @if($sender_address != null) value="{{$sender_address->address2}}" @endif placeholder="">
                        </div>
                    </div>

                    <div class="Complete-address">
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half">
                                <label for="City">City</label>
                                <input type="text" required="" name="sender_city" id="City" @if($sender_address != null) value="{{$sender_address->city}}" @endif placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half adj">
                                <label for="State">State</label>
                                <input type="text" required="" name="sender_state" id="State" @if($sender_address != null) value="{{$sender_address->state}}" @endif placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half">
                                <label for="PosteCode">Poste Code</label>
                                <input type="text" required="" name="sender_postecode" id="PosteCode" @if($sender_address != null) value="{{$sender_address->postecode}}" @endif placeholder="">
                            </div>
                        </div>

                    </div>
                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Country">Country</label>
                            <input type="text" required="" name="sender_country" id="Country" @if($sender_address != null) value="{{$sender_address->country}}"  @endif placeholder="">
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
                            <input type="text" required="" name="receipent_address2" id="Address2" @if($recipient_address != null) value="{{$recipient_address->address2}}" @endif placeholder="">
                        </div>
                    </div>

                    <div class="Complete-address">
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half">
                                <label for="City">City</label>
                                <input type="text" required="" name="receipent_city" id="City" @if($recipient_address != null) value="{{$recipient_address->city}}" @endif placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half adj">
                                <label for="State">State</label>
                                <input type="text" required="" name="receipent_state" id="State" @if($recipient_address != null) value="{{$recipient_address->state}}" @endif placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half">
                                <label for="PosteCode">Poste Code</label>
                                <input type="text" required="" name="receipent_postecode" id="PosteCode" @if($recipient_address != null) value="{{$recipient_address->postecode}}" @endif placeholder="">
                            </div>
                        </div>

                    </div>
                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Country">Country</label>
                            <input type="text" required="" name="receipent_country" id="Country" @if($recipient_address != null) value="{{$recipient_address->country}}"  @endif placeholder="">
                        </div>
                    </div>

                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half Get-contect-right">
                            <label for="Phone">Email</label>
                            <input type="text" required="" name="receipent_email" id="email" @if($recipient_address != null) value="{{$recipient_address->email}}" @endif placeholder="">
                        </div>
                    </div>


                </div>

            </div>
            <div class="Form-field-contaner">
                <div class="Form-content-name">
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
    <div class="Form-wraper">
        <div class="Form-contaner">
            <div class="Form-content-header">
                <h1 class="Form-content-header-Head">  <a class="Same-button" >Request Paper Form</a> </h1>
            </div>
            <div class="Form-field-contaner">
                <div class="Form-content-name">
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
                        <input type="text" required="" name="billing_business" id="Business" @if($billing_address != null) value="{{$billing_address->business}}" @endif placeholder="">
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
                        <input type="text" required="" name="billing_address2" id="Address2" @if($billing_address != null) value="{{$billing_address->address2}}" @endif placeholder="">
                    </div>
                </div>

                <div class="Complete-address">
                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="City">City</label>
                            <input type="text" required="" name="billing_city" id="City" @if($billing_address != null) value="{{$billing_address->city}}" @endif placeholder="">
                        </div>
                    </div>
                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half adj">
                            <label for="State">State</label>
                            <input type="text" required="" name="billing_state" id="State" @if($billing_address != null) value="{{$billing_address->state}}" @endif placeholder="">
                        </div>
                    </div>
                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="PosteCode">Poste Code</label>
                            <input type="text" required="" name="billing_postecode" id="PosteCode" @if($billing_address != null) value="{{$billing_address->postecode}}" @endif placeholder="">
                        </div>
                    </div>

                </div>
                <div class="custom_fields_half">
                    <div class="custom_Request_fields_half">
                        <label for="Country">Country</label>
                        <input type="text" required="" name="billing_country" id="Country" @if($billing_address != null) value="{{$billing_address->country}}"  @endif placeholder="">
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
            <div class="Form-field-contaner">
                <div class="Form-content-name">
                    <p>Shipment Details</p>
                </div>

                <div class="Form-content-detail">

                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half  ">
                            <label for="Type">Type</label>
                            <select name="post_type" form="Type">
                                <option value="postcard">Postcard</option>
                                <option value="letter">Letter</option>
                                <option value="large_envelope">Large Envelope</option>
                            </select>
                        </div>
                    </div>


                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half">
                            <label for="Special-Holding">Special Holding</label>
                            <input type="text" required="" name="special_holding" id="Business" value="" placeholder="">
                        </div>
                    </div>

                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half  ">
                            <label for="Shape">Shape</label>
                            <select name="shape" form="Type">
                                <option value="box">Box</option>
                                <option value="light_box">Light Box</option>
                            </select>
                        </div>
                    </div>

                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half  ">
                            <label for="Shape">Unit of Measure</label>
                            <select name="unit_of_measures" form="Type">
                                <option value="mm">milimetres</option>
                                <option value="cm">centimetres</option>
                                <option value="in">inches</option>
                                <option value="ft">feet</option>
                                <option value="m">metres </option>

                            </select>
                        </div>
                    </div>

                    <div class="three-field-Row">
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half">
                                <label for="Weight">Weight</label>
                                <input type="text" required="" name="weight" id="City" value="" placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half adj">
                                <label for="Height">Height</label>
                                <input type="text" required="" name="height" id="State" value="" placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half">
                                <label for="length">Length</label>
                                <input type="text" required="" name="length" id="PosteCode" value="" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="tow-field-Row">
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half tow-field-Row-left">
                                <label for="width">Width</label>
                                <input type="text" required="" name="width" id="Country" value="" placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half tow-field-Row-right">
                                <label for="Girth">Girth</label>
                                <input type="text" required="" name="girth" id="Country" value="" placeholder="">
                            </div>
                        </div>
                    </div>


                    <div class="custom_fields_half">
                        <div class="custom_Request_fields_half  ">
                            <label for="Shape">Ship Out Date</label>
                            <input type="date" required="" name="ship-out-date" id="Country" value="" placeholder="">
                        </div>
                    </div>

                    <input type="submit" class="Same-button" value="Get Quote">
                </div>


            </div>
            <div class="Form-field-contaner">
                <div class="Form-content-detail">
                    <div class="three-field-Row" >
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half tow-field-Row-left ">
                                <label for="Order ID">Card Number</label>
                                <input type="text" required="" name="card_no" id="FirstName" value="" placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half tow-field-Row-right">
                                <label for="Order ID">Card Expiry</label>
                                <input type="text" required="" name="card_expires" id="FirstName" value="" placeholder="">
                            </div>
                        </div>
                        <div class="custom_fields_half">
                            <div class="custom_Request_fields_half tow-field-Row-right">
                                <label for="Order ID">Card CVV</label>
                                <input type="text" required="" name="card_cvv" id="FirstName" value="" placeholder="">
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="Same-button" value="Checkout">
                </div>
            </div>
        </div>
    </div>
</div>

