@extends('layout.admin')
@section('content')
    <div class="row single_order" style="margin-top:-60px;" >
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Update Orders</h4>
                    </div>
                    <div class="col-md-4" style="display: none">
                        <div class="float-right d-none d-md-block">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti-settings mr-1"></i> Settings
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row custom_card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="vertical_adjustment">
                            <h4>Order Details</h4>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="vertical_adjustment vertical_adjustment_status">
                            <h4>Order Status</h4>
                            <select id="change_order_status" data-order-id="{{$order->id}}" class="form-control">
                                @foreach($status as $stats)
                                    <option @if($order->status_id == $stats->id) selected @endif value="{{$stats->id}}" >{{$stats->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 20px">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#sender" role="tab">
                                    <span class="d-none d-md-block">Sender Details</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#recipients" role="tab">
                                    <span class="d-none d-md-block">Recipients Details</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#billing" role="tab">
                                    <span class="d-none d-md-block">Billing Details</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#shipment" role="tab">
                                    <span class="d-none d-md-block">Shipment Details</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#invoice" role="tab">
                                    <span class="d-none d-md-block">Invoice Details</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#key-notes" role="tab">
                                    <span class="d-none d-md-block">Key Notes</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#shipment-to-postdelay" role="tab">
                                    <span class="d-none d-md-block">Shipment to PostDelay</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                </a>
                            </li>
                            {{--                                    <li class="nav-item">--}}
                            {{--                                        <a class="nav-link " data-toggle="tab" href="#additional-fee" role="tab">--}}
                            {{--                                            <span class="d-none d-md-block">Additional Fee</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>--}}
                            {{--                                        </a>--}}
                            {{--                                    </li>--}}
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                                    <span class="d-none d-md-block">Ship Out Date</span><span class="d-block d-md-none"><i class="mdi mdi-email h5"></i></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#home" role="tab">
                                    <span class="d-none d-md-block">Status History</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                    <span class="d-none d-md-block">Additional Fees</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                </a>
                            </li>


                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active p-3" id="sender" role="tabpanel">

                                <h6>Sender Details</h6>
                                <form action="{{route('update_order_sender_details')}}" method="get">
                                    <input type="hidden" value="{{$order->has_sender->id}}" name="id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">First Name</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="first_name" type="text" value="{{$order->has_sender->first_name}}" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Last Name</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="last_name" type="text" value="{{$order->has_sender->last_name}}" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Business</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="business" type="text" value="{{$order->has_sender->business}}" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Address 1</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="address1" type="text" value="{{$order->has_sender->address1}}" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Address 2</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="address2" type="text" value="{{$order->has_sender->address2}}" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">City</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="city" type="text" value="{{$order->has_sender->city}}" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">State</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control AddressProvinceNew" name="state" >

                                                    </select>
{{--                                                    <input class="form-control" name="state" type="text" value="{{$order->has_sender->state}}" >--}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Zip Code</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="postcode" type="text" value="{{$order->has_sender->postcode}}" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Country</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control AddressCountryNew" name="country"
                                                            data-country-select="{{$order->has_sender->country}}" data-province-select="{{$order->has_sender->state}}">
                                                        @include('customers.inc.countries')
                                                    </select>
{{--                                                    <input  name="country"  type="text" value="{{$order->has_sender->country}}">--}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Phone</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="phone" type="text" value="{{$order->has_sender->phone}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <input class="form-control btn btn-primary " type="submit" value="Save">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="tab-pane  p-3" id="recipients" role="tabpanel">
                                <h6>Receipt Details</h6>
                                <form action="{{route('update_order_recipient_details')}}" method="get">
                                    <input type="hidden" value="{{$order->has_recepient->id}}" name="id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">First Name</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="first_name" type="text" value="{{$order->has_recepient->first_name}}" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Last Name</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_recepient->last_name}}" name="last_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Business</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_recepient->business}}" name="business">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Address 1</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_recepient->address1}}" name="address1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Address 2</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_recepient->address2}}" name="address2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">City</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_recepient->city}}" name="city">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">State</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_recepient->state}}" name="state">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Zip Code</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_recepient->postcode}}" name="postcode">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Country</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_recepient->country}}" name="country">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Phone</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_recepient->phone}}" name="phone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Phone</label>
                                                <div class="col-sm-2">
                                                    <input class="form-control btn btn-primary" type="submit" value="Save" >
                                                </div>
                                            </div>
                                        </div
                                    </div>
                                </form>

                            </div>
                            <div class="tab-pane  p-3" id="billing" role="tabpanel">
                                <h6>Billing Details</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">First Name</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->first_name}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Last Name</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->last_name}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Business</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->business}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Address 1</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->address1}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Address 2</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->address2}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">City</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->city}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">State</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->state}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Zip Code</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->postcode}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Country</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->country}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Phone</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->phone}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane  p-3" id="shipment" role="tabpanel">
                                <h6>Shipment Details</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Type</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" disabled="true">
                                                    <option>{{$order->has_package_detail->type}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Special Holding</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_package_detail->special_holding}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Shape</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" disabled="true">
                                                    <option>{{$order->has_package_detail->shape}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Unit of Measure</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" disabled="true">
                                                    <option>{{$order->has_package_detail->scale}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Weight</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_package_detail->weight}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Height</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_package_detail->height}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Length</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_package_detail->length}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Width</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_package_detail->width}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Girth</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_package_detail->girth}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Payement Method</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" disabled="true">
                                                    <option>{{$order->payment_gateway}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane  p-3" id="invoice" role="tabpanel">
                                <h6>Invoice Details</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Order ID</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->shopify_order_id}}" disabled="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p>{{$order->shipping_method_title}}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p></p>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <p>${{$order->shipping_method_price}} USD</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>Post Delay Fee</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p></p>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <p>${{$order->order_total - $order->shipping_method_price}}.00 USD</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>Tax</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p></p>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <p>$0.00</p>
                                    </div>

                                    <div class="horizental_separator"></div>
                                    <div class="horizental_separator"></div>

                                    <div class="col-md-4">
                                        <p>Total</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p></p>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <p>${{number_format($order->order_total,2)}} USD</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><button type="button" class="btn btn-secondary waves-effect">Cancel Order</button></p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane  p-3" id="key-notes" role="tabpanel">
                                <h6>Key Date</h6>
                                <form action="{{route('set_key_dates')}}" method="get">
                                    <div class="row">

                                        <input type="hidden" value="{{$order->id}}" name="order_id">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Order Date</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{\Carbon\Carbon::parse($order->created_at)->format('F j ,Y')}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label">Recieved Post by Post Delay</label>
                                                <div class="col-sm-12">
                                                    <input  class="form-control" name="received_post_date" type="date"
                                                            @if($order->has_key_dates != null) value="{{\Carbon\Carbon::parse($order->has_key_dates->received_post_date)->format('Y-m-d')}}" @else value='' @endif>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Ship out Date</label>
                                                <div class="col-sm-12">
                                                    <input disabled class="form-control" type="text" value="{{\Carbon\Carbon::parse($order->ship_out_date)->format('F j ,Y')}}"  >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Completion Date</label>
                                                <div class="col-sm-12">
                                                    <input name="completion_date" class="form-control" type="date"
                                                           @if($order->has_key_dates != null) value="{{\Carbon\Carbon::parse($order->has_key_dates->completion_date)->format('Y-m-d')}}" @else value='' @endif >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-secondary waves-effect">Save</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane  p-3" id="shipment-to-postdelay" role="tabpanel">
                                <h6>Your Shipment to Post delay</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label">Ship Date</label>
                                            <div class="col-sm-12">
                                                <input disabled class="form-control" type="text" value="{{$order->ship_to_postdelay_date}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Ship Method</label>
                                            <div class="col-sm-12">
                                                <input type="text"  class="form-control" name="fdas" value="{{$order->ship_method}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Track ID</label>
                                            <div class="col-sm-12">
                                                <input disabled class="form-control" type="text" value="{{$order->tracking_id}}" id="example-datetime-local-input">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{--                                    <div class="tab-pane  p-3" id="additional-fee" role="tabpanel">--}}
                            {{--                                        <h6>Additional Fee Details</h6>--}}
                            {{--                                        <div class="row">--}}
                            {{--                                            <div class="col-md-6">--}}
                            {{--                                                <div class="form-group row">--}}
                            {{--                                                    <label for="example-text-input" class="col-sm-12 col-form-label">Addational Fee details</label>--}}
                            {{--                                                    <div class="col-sm-12">--}}
                            {{--                                                        <input class="form-control" type="text" value="Further Details">--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="col-md-6">--}}
                            {{--                                                <div class="form-group row">--}}
                            {{--                                                    <label for="example-text-input" class="col-sm-12 col-form-label">Request Amount</label>--}}
                            {{--                                                    <div class="col-sm-12">--}}
                            {{--                                                        <input class="form-control" type="text" value="Amount">--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="col-md-12">--}}
                            {{--                                                <div class="form-group row">--}}
                            {{--                                                    <label for="example-text-input" class="col-sm-12 col-form-label">Request Date</label>--}}
                            {{--                                                    <div class="col-sm-12">--}}
                            {{--                                                        <input class="form-control" type="text" value="Date">--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}

                            {{--                                            <div class="col-md-6">--}}
                            {{--                                                <div class="form-group row">--}}
                            {{--                                                    <label for="example-text-input" class="col-sm-12 col-form-label">Payment Link</label>--}}
                            {{--                                                    <div class="col-sm-12">--}}
                            {{--                                                        <input class="form-control" type="text" value="Payment Link">--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="col-md-6">--}}
                            {{--                                                <div class="form-group row">--}}
                            {{--                                                    <label for="example-text-input" class="col-sm-12 col-form-label">Payment Receipt</label>--}}
                            {{--                                                    <div class="col-sm-12">--}}
                            {{--                                                        <input class="form-control" type="text" value="Payment Receipt">--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                            <div class="col-md-12">--}}
                            {{--                                                <button type="button" class="btn btn-secondary waves-effect">Save</button>--}}
                            {{--                                            </div>--}}

                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            <div class="tab-pane p-3" id="messages" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Future Ship Date</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="datetime-local" value="" id="example-datetime-local-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Modify Future Ship Date</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="datetime-local" value="" id="example-datetime-local-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-secondary waves-effect">Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane  p-3" id="home" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover table_custom">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Updated At</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($logs as $index => $log)
                                            <tr>
                                                <th>{{$index+1}}</th>
                                                <td>
                                                    {{$log->has_status->name}}
                                                </td>
                                                <td>
                                                    {{$log->change_at}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane p-3" id="profile" role="tabpanel">
                                <div class="table-responsive">
                                    @if(count($order->has_additional_payments) > 0)
                                        <table class="table table-hover table_custom">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Payment Name</th>
                                                <th scope="col">Payment</th>
                                                <th scope="col">Payment Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($order->has_additional_payments as $index => $payment)
                                                <tr>
                                                    <th>{{$index+1}}</th>
                                                    <td>
                                                        {{$payment->additional_payment_name}}
                                                    </td>
                                                    <td>
                                                        ${{number_format($payment->order_total,2)}} USD
                                                    </td>
                                                    <td> {{\Carbon\Carbon::parse($payment->created_at)->format('F j ,Y')}}</td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    @else
                                        <h5> No Additional Payments</h5>
                                    @endif
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
