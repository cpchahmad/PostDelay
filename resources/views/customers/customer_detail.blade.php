<form id="update_customer_details_form" action="/customer/update" method="get">

    <input type="hidden" name="customer_id" value="{{$customer->shopify_customer_id}}">
    <input type="hidden" name="shop" value="{{ $customer->has_shop->shopify_domain }}">



        <div class="custom_fields_half associate">
            <div class="custom_Request_fields_half">
                <label for="AddressCountryNew" >Country</label>
                <select required class="AddressCountryNew" name="country" @if($customer != null) data-country-select="{{ $customer->country }}"  data-province-select="{{$customer->state}}" @endif>
                    @include('customers.inc.countries')
                </select>
            </div>
        </div>


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

            <div class="full_width_iput">
                <div class="custom_Request_fields_half">
                    <label for="Address1">Street Adress</label>
                    <input type="text" required=""  id="autocomplete" value="{{ $customer->address1 }}" placeholder="Street and number, P.O.box C/O">
                    <input  type="hidden" name="address1" id="street_number" value="{{ $customer->address1 }}" placeholder="Apartment, suite, building etc.">
                    <input style="margin-top: 25px;
    margin-bottom: 45px;" type="text" name="address2" id="route" value="{{ $customer->address2 }}" placeholder="Apartment, suite, building etc.">
                </div>
            </div>


            <div class="Complete-address">
                <div class="">
                    <div class="custom_fields_half full_width_iput ">
                        <label for="City">City</label>
                        <input type="text" required="" name="city" id="locality" value="{{ $customer->city }}" placeholder="">
                    </div>
                </div>
                <div id="" class="custom_fields_half full_width_iput">
                    <div class="custom_Request_fields_half adj">
                        <label for="AddressProvinceNew">Province or State</label>
                        <select id="administrative_area_level_1" class="AddressProvinceNew2" name="province" autocomplete="address-level1">
                            @include('customers.inc.usa_states')
                        </select>
                    </div>
                </div>
                <div id="postal_div" class="custom_fields_half full_width_iput">
                    <div class="custom_Request_fields_half">
                        <label for="PosteCode">Zip Code</label>
                        <input type="text"  name="postecode" id="postal_code" value="{{ $customer->postcode }}" placeholder="">
                    </div>
                </div>

            </div>
            <div class="tow-field-Row">
                    <div class="full_width_iput full_width_iput">
                        <div class="custom_fields_half full_width_iput Get-contect-left">
                            <label for="Email">Email</label>
                            <input readonly type="email"  name="email" id="Email" value="{{$customer->email}}" placeholder="">
                        </div>
                    </div>
                    <div class="custom_fields_half full_width_iput">
                        <div class="custom_Request_fields_half Get-contect-right">
                            <label for="Phone">Phone</label>
                            <input type="text" required="" name="phone" id="Phone" value="{{ $customer->phone }}" placeholder="">
                        </div>
                    </div>

            </div>

            <div id="email-status"></div>

            <div class="custom_fields_half" style="display:none;">
                <div class="custom_Request_fields_half">
                    <label for="Business">Business</label>
                    <input type="text" name="business" id="Business" value="" placeholder="">
                </div>
            </div>




        <div class="Form-content-detail2">
            <div class="receve-mail promotions ">
                <div class="receve-mail-text">
                    <p class="" >Please send me emails regarding PostDelay promotions</p>
                </div>
                <div class="receve-mail-box promotions-mail">
                    <input class="" checked type="checkbox" name="receve-mail" value="receve-mail"><br>
                </div>
            </div>
            <div class="tow-field-Row">
                <div class="custom_Button-contaner">
                    <input type="submit" class="Same-button" value="SAVE">
                </div>

                <div class="custom_Button-contaner ">
                    <a  id="change-password" style="cursor: pointer" class="Same-button" >CHANGE PASSWORD</a>
                </div>


                <div class="custom_Button-contaner ">
                    <a style="cursor: pointer" id="customer_delete_account" data-id="{{$customer->shopify_customer_id}}" class="Same-button" >DELETE ACCOUNT</a>
                </div>

            </div>
            <div class="form-message form-message--success hide" id="RecoverPasswordStatus" tabindex="-1">

            </div>
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
            <a {{--id="billing_address_button"--}} href="/account/addresses?view=new&&type=Billing" style="cursor: pointer" class="Same-button" >ADD</a>
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
            <a {{--id="recipients_address_button"--}} href="/account/addresses?view=new&&type=Recipients"  style="cursor: pointer" class="Same-button" >ADD</a>
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

            <a {{--id="sender_address_button"--}} href="/account/addresses?view=new&&type=Sender" style="cursor: pointer" class="Same-button" >ADD</a>
        </div>

        <div class="custom_Button-contaner cng-btn">
            <a id="sender_address_remove_button"   style="cursor: pointer" class="Same-button" >REMOVE</a>
        </div>
    </div>
</div>
