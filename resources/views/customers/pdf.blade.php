<!DOCTYPE html>
<html>

@include('inc.header')

<body>
<h2>Hi - {{$order->has_customer->first_name}}</h2>
<h5>THANKS FOR USING POSTDELAY</h5>

<div class="row">
    <div class="col-md-6">
        <h6>Sender Details</h6>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">First Name</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->first_name}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Last Name</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->last_name}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Business</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender-> business}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Address 1</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->address1}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Address 2</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->address2}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">City</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->city}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">State</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->state}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Post code</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->postcode}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Country</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->country}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Phone</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->phone}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h6>Sender Details</h6>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">First Name</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->first_name}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Last Name</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->last_name}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Business</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender-> business}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Address 1</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->address1}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Address 2</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->address2}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">City</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->city}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">State</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->state}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Post code</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->postcode}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Country</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->country}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-12 col-form-label">Phone</label>
                    <div class="col-sm-12">
                        <input class="form-control" type="text" value="{{$order->has_sender->phone}}"id="example-text-input" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>
<p> Please return the upper portion in your shipment of your item to postdelay
It allows us to link your incoming item with your order
</p>
<p>Mail Youe Item to <br> POSTDELAY LLC <br> BOX 15000 <br> Brooklyn, New-York <br> 11215, USA</p>
</body>
</html>
