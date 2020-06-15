<form id="re-calculate-form" action="{{route('app.calculate_shipping')}}" method="get">
    <input type="hidden" name="receipent_country" value="{{$sender['country']}}">
    <input type="hidden" name="receipent_first_name" value="{{$sender['first_name']}}">
    <input type="hidden" name="receipent_last_name" value="{{$sender['last_name']}}">
    <input type="hidden" name="receipent_address1" value="{{$sender['address1']}}">
    <input type="hidden" name="receipent_address2" value="{{$sender['address2']}}">
    <input type="hidden" name="receipent_city" value="{{$sender['city']}}">
    <input type="hidden"   name="receipent_state" value="{{$sender['state']}}">
    <input type="hidden" name="receipent_postecode" value="{{$sender['postcode']}}">

    <input type="hidden" name="post_type" value="{{$order->has_package_detail->type}}">
    <input type="hidden" name="postcard_size" value="{{$order->has_package_detail->postcard_size}}">
    <input type="hidden" name="special_holding" value="{{$order->has_package_detail->special_holding}}">
    <input type="hidden" name="shape" value="{{$order->has_package_detail->shape}}">
    <input type="hidden" name="unit_of_measures" value="{{$order->has_package_detail->scale}}">
    <input type="hidden" name="unit_of_measures_weight" value="{{$order->has_package_detail->unit_of_measures_weight}}">
    <input type="hidden" name="weight" value="{{$order->has_package_detail->weight}}">
    <input type="hidden" name="pounds" value="{{$order->has_package_detail->pounds}}">
    <input type="hidden" name="ounches" value="{{$order->has_package_detail->ounches}}">
    <input type="hidden" name="weight" value="{{$order->has_package_detail->weight}}">
    <input type="hidden" name="height" value="{{$order->has_package_detail->height}}">
    <input type="hidden" name="width" value="{{$order->has_package_detail->width}}">
    <input type="hidden" name="length" value="{{$order->has_package_detail->length}}">
    <input type="hidden" name="girth" value="{{$order->has_package_detail->girth}}">
    <input type="hidden" name="ship_out_date" value="{{$order->ship_out_date}}">
</form>
