@extends('layout.admin')
@section('content')
    <div class="row single_order" style="margin-top:-60px;" >
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Update Orders <a class="btn btn-primary" style="margin-left: 20px" href="{{route('download_pdf')}}?order={{$order->shopify_order_id}}">Download Order PDF</a></h4>
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
                            <select id="change_order_status" data-order-id="{{$order->id}}" class="form-control" style="color: {{ $order->has_status->color  }};">
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
                                <a class="nav-link " data-toggle="tab" href="#outbound" role="tab">
                                    <span class="d-none d-md-block">Outbound Tracking</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#invoice" role="tab">
                                    <span class="d-none d-md-block">Invoice Details</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#key-notes" role="tab">
                                    <span class="d-none d-md-block">Important Dates</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
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
                            @if($order->status_id == 15)

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#extra_charge" role="tab">
                                    <span class="d-none d-md-block">Set Additional Price Charges</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                </a>
                            </li>

                                @endif


                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            @if($order->status_id == 15)
                            <div class="tab-pane p-3" id="extra_charge" role="tabpanel">
                                <h6>Additional Price Charges</h6>
                                <form action="{{route('update_order_extra_charges')}}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$order->id}}" name="id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Additional cost would be to ship</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" name="additional_cost_to_ship" step="any" type="number" value="{{$order->additional_cost_to_ship}}" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Additional cost would be to return</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" name="additional_cost_to_return" step="any" type="number" value="{{$order->additional_cost_to_return}}" >
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
                            @endif
                            <div class="tab-pane p-3" id="outbound" role="tabpanel">
                                <h6>Outbound Tracking Details</h6>
                                <form action="{{route('update_tracking')}}" method="get">
                                    <input type="hidden" value="{{$order->id}}" name="id">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Outbound Tracking ID</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="outbound_tracking_id" type="text" value="{{$order->outbound_tracking_id}}" >
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
                                                    <input class="form-control" name="state" type="text" value="{{$order->has_sender->state}}" >
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
                                                    <input  name="country"  type="text" value="{{$order->has_sender->country}}" class="form-control">
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
                                                <div class="col-sm-2">
                                                    <input class="form-control btn btn-primary" type="submit" value="Save" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="tab-pane  p-3" id="billing" role="tabpanel">
                                <h6>Billing Details</h6>
                                <form action="{{route('order_update_billing_details')}}" method="get">
                                    <input type="hidden" name="id" value="{{$order->has_billing->id}}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">First Name</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_billing->first_name}}" name="first_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Last Name</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_billing->last_name}}" name="last_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Business</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_billing->business}}" name="business">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Address 1</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_billing->address1}}" name="address1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Address 2</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_billing->address2}}" name="address2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">City</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_billing->city}}" name="city">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">State</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_billing->state}}" name="state">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Zip Code</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_billing->postcode}}" name="postcode">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Country</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_billing->country}}" name="country">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Phone</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_billing->phone}}" name="phone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <input class="form-control btn btn-primary" type="submit" value="Save">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="tab-pane  p-3" id="shipment" role="tabpanel">
                                <h6>Shipment Details</h6>
                                <div class="row">
                                    @if($order->has_package_detail->type != null)
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
                                    @endif
                                    @if($order->has_package_detail->postcard_size != null && in_array($order->has_package_detail->type,['POSTCARD']))
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Postcard Size</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" disabled="true">
                                                        <option>{{$order->has_package_detail->postcard_size}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->has_package_detail->special_holding != null && in_array($order->has_package_detail->type,['LETTER']))


                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Special Holding</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_package_detail->special_holding}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->has_package_detail->shape != null && in_array($order->has_package_detail->type,['LARGE PACKAGE']))


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
                                    @endif
                                    @if($order->has_package_detail->unit_of_measures_weight != null && !in_array($order->has_package_detail->type,['POSTCARD']))

                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Unit of Measure</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" disabled="true">
                                                        <option>{{$order->has_package_detail->unit_of_measures_weight}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->has_package_detail->pounds != null && !in_array($order->has_package_detail->type,['POSTCARD']))


                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Pounds </label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_package_detail->pounds}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->has_package_detail->ounches != null && !in_array($order->has_package_detail->type,['POSTCARD']))


                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Ounces</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_package_detail->ounches}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->has_package_detail->weight != null && !in_array($order->has_package_detail->type,['POSTCARD']))


                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Weight (kg)</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_package_detail->weight}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->has_package_detail->height != null && !in_array($order->has_package_detail->type,['POSTCARD','LETTER','LARGE ENVELOPE','PACKAGE']))

                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Height</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_package_detail->height}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->has_package_detail->length != null && !in_array($order->has_package_detail->type,['POSTCARD','LETTER','LARGE ENVELOPE','PACKAGE']))

                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Length</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_package_detail->length}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->has_package_detail->width != null && !in_array($order->has_package_detail->type,['POSTCARD','LETTER','LARGE ENVELOPE','PACKAGE']))

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Width</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_package_detail->width}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->has_package_detail->girth != null && !in_array($order->has_package_detail->type,['POSTCARD','LETTER','LARGE ENVELOPE','PACKAGE']))

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Girth</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="{{$order->has_package_detail->girth}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($order->payment_gateway != null)

                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Payement Method</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" disabled="true">
                                                        <option>{{$order->payment_gateway}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>@endif
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
                                    <?php
                                    $items = json_decode($order->items, true);
                                    //                                    dd($items);
                                    ?>
                                    @foreach($items as $item)
                                        <div class="col-md-6">
                                            <p>{{ $item['title'] }}</p>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <p>${{ number_format($item['price'], 2) }} USD</p>
                                        </div>
                                    @endforeach
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
                                        @if(!in_array($order->status_id, [6,7,8,9,10,11,12,13,14]))
                                            <p><button type="button" class="btn btn-secondary waves-effect">Cancel Order</button></p>
                                        @endif
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
                                                <label class="col-sm-12 col-form-label">Received Post by Post Delay</label>
                                                <div class="col-sm-12 d-flex">
                                                    <input  class="form-control" name="received_post_date" type="date"
                                                            @if($order->has_key_dates != null)  @if($order->has_key_dates->received_post_date != null)  value="{{\Carbon\Carbon::parse($order->has_key_dates->received_post_date)->format('Y-m-d')}}" @endif @else value='' @endif>
                                                    <a href="{{route('clear_received_post_date')}}?order_id={{$order->id}}" class="btn btn-danger" style="margin-left: 10px"> Clear </a>
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
                                                <label for="example-text-input" class="col-sm-12 col-form-label">@if(in_array($order->status_id,['9' ,'17','21','23','24']))Return Date @else Delivery Date @endif</label>
                                                <div class="col-sm-12 d-flex">
                                                    <input name="completion_date" class="form-control" type="date"
                                                           @if($order->has_key_dates != null)  @if($order->has_key_dates->completion_date != null) value="{{\Carbon\Carbon::parse($order->has_key_dates->completion_date)->format('Y-m-d')}}" @endif @else value='' @endif >
                                                    <a href="{{route('clear_completion_date')}}?order_id={{$order->id}}" class="btn btn-danger" style="margin-left: 10px"> Clear </a>
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
                            <div class="tab-pane p-3" id="messages" role="tabpanel">
                                <form class="row" action="{{route('order.modify.date')}}" method="post">
                                    @csrf
                                        <input type="hidden" name="order_id" value="{{$order->id}}">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Future Ship Date</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="date" value="{{\Carbon\Carbon::parse($order->ship_out_date)->format('Y-m-d')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Modify Future Ship Date</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" name="ship_out_date" min="{{now()->addDays((int)$settings->max_threshold_for_modify_ship_out_date)->format('Y-m-d')}}" max="{{now()->addDays(365)->format('Y-m-d')}}" type="date" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-secondary waves-effect">Modify</button>
                                        </div>
                                    </form>

                                <div class="row" style="margin-top: 20px">
                                    <h6>Modification Date Logs</h6>
                                    @if(count($order->has_logs) > 0)
                                        <table class="table table-hover table_custom">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Modification Date</th>
                                                <th scope="col">Previous Date </th>
                                                <th scope="col">New Date </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order->has_logs()->orderBy('created_at','DESC')->get() as $index => $log)
                                                <tr>
                                                    <th>{{$index+1}}</th>
                                                    <td>
                                                        {{date_create($log->modification_date)->format('Y-m-d h:i a')}}
                                                    </td>
                                                    <td>
                                                        {{date_create($log->previous_date)->format('Y-m-d')}}
                                                    </td>
                                                    <td>
                                                        {{date_create($log->new_date)->format('Y-m-d')}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p class="text-center">
                                            No Modification Logs Founds
                                        </p>
                                    @endif
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
