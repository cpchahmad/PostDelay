<select name="billing_address" id="request_billing_address_select">
    <option value="---"> Select From Save Addresses </option>
    @foreach($addresses as $address)
        <option value="{{$address->id}}"> {{$address->address1.', '.$address->address2.', '.$address->city.', '.$address->state.', '. $address->country.','.$address->postcode}} </option>
    @endforeach
</select>
