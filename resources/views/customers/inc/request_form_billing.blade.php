<select name="billing_address" id="request_billing_address_select">
    <option value="---"> --- </option>
    @foreach($addresses as $address)
        <option value="{{$address->id}}"> {{$address->address1.','.$address->country}} </option>
    @endforeach
</select>
