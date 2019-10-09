<div class="custom_fields_half">
    <div class="custom_Request_fields_half  ">
        <label for="Type">Type</label>
        <select  disabled name="type-list" form="Type">
            <option value="Type-1">{{$order->has_package_detail->type}}</option>

        </select>
    </div>
</div>


<div class="custom_fields_half">
    <div class="custom_Request_fields_half">
        <label for="Special-Holding">Special Holding</label>
        <input disabled type="text"  name="account[business]" id="Business" value="{{$order->has_package_detail->special_holding}}" placeholder="">
    </div>
</div>

<div class="custom_fields_half">
    <div class="custom_Request_fields_half  ">
        <label for="Shape">Shape</label>
        <select disabled name="type-list" form="Type">
            <option value="Type-1"> {{$order->has_package_detail->shape}}</option>

        </select>
    </div>
</div>

<div class="custom_fields_half">
    <div class="custom_Request_fields_half  ">
        <label for="Shape">Unit of Measure</label>
        <select disabled name="type-list" form="Type">
            <option value="Type-1"> {{$order->has_package_detail->scale}}</option>

        </select>
    </div>
</div>

<div class="three-field-Row">
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half">
            <label for="Weight">Weight</label>
            <input disabled type="text"  name="account[city]" id="City" value="{{$order->has_package_detail->weight}}" placeholder="">
        </div>
    </div>
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half adj">
            <label for="Height">Height</label>
            <input disabled type="text"  name="account[state]" id="State" value="{{$order->has_package_detail->height}}" placeholder="">
        </div>
    </div>
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half">
            <label for="length">Length</label>
            <input disabled  type="text"  name="account[postecode]" id="PosteCode" value="{{$order->has_package_detail->length}}" placeholder="">
        </div>
    </div>
</div>

<div class="tow-field-Row">
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half tow-field-Row-left">
            <label for="width">Width</label>
            <input disabled type="text"  name="account[country]" id="Country" value="{{$order->has_package_detail->width}}" placeholder="">
        </div>
    </div>
    <div class="custom_fields_half">
        <div class="custom_Request_fields_half tow-field-Row-right">
            <label for="Girth">Girth</label>
            <input disabled type="text"  name="account[country]" id="Country" value="{{$order->has_package_detail->girth}}" placeholder="">
        </div>
    </div>
</div>


<div class="custom_fields_half">
    <div class="custom_Request_fields_half  ">
        <label for="Shape">Ship Out Date</label>
        <input disabled type="text" value="{{$order->ship_out_date}}">
    </div>
</div>
