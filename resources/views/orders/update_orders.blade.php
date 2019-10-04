@extends('layout.admin')
@section('content')
    <div class="row" style="margin-top:-60px;">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Update Orders</h4>
                    </div>
                    <div class="col-md-4">
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
                <div class="row custom_line_height">

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
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
                        <div class="card">
                            <div class="card-body">
                                <h6>Receipt Details</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">First Name</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_recepient->first_name}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Last Name</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_recepient->last_name}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Business</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_recepient->business}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Address 1</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_recepient->address1}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Address 2</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_recepient->address2}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">City</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_recepient->city}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">State</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_recepient->state}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Post Code</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_recepient->postcode}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Country</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_recepient->country}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Phone</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_recepient->phone}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                        <div class="card">
                            <div class="card-body">
                                <h6>Invoice Details</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Order ID</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->shopify_order_id}}"id="example-text-input" disabled="true">
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
                                    <div class="col-md-4">
                                        <p><button type="button" class="btn btn-secondary waves-effect">Cancel Order</button></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>Total</p>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <p>${{number_format($order->order_total,2)}} USD</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6>Key Date</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Order Date</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{\Carbon\Carbon::parse($order->created_at)->format('F j ,Y')}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-datetime-local-input" class="col-sm-12 col-form-label">Recieved Post by Post Delay</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{\Carbon\Carbon::parse($order->ship_out_date)->format('F j ,Y')}}"id="example-datetime-local-input" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Ship out Date</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{\Carbon\Carbon::parse($order->ship_out_date)->format('F j ,Y')}}"id="example-text-input" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Completion Date</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{\Carbon\Carbon::parse($order->ship_out_date)->format('F j ,Y')}}"id="example-text-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-secondary waves-effect">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0 mt-0 font-14">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="text-dark collapsed">
                                           Order Status History
                                        </a>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
                                    <div class="card-body">
                                        <h6>Status History</h6>
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
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h6>Billing Details</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">First Name</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->first_name}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Last Name</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->last_name}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Business</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->business}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Address 1</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->address1}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Address 2</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->address2}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">City</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->city}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">State</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->state}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Post Code</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->postcode}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Country</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->country}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Phone</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_billing->phone}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
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
                                                <input class="form-control" type="text" value="{{$order->has_package_detail->special_holding}}"id="example-text-input" disabled>
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
                                                <input class="form-control" type="text" value="{{$order->has_package_detail->weight}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Height</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_package_detail->height}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Length</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_package_detail->length}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Width</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_package_detail->width}}"id="example-text-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Girth</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{$order->has_package_detail->girth}}"id="example-text-input" disabled>
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
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h6>Additional Fee Details</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Addational Fee details</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="Further Details"id="example-text-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Request Amount</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="Amount"id="example-text-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Request Date</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="Date"id="example-text-input">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Payment Link</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="Payment Link"id="example-text-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Payment Receipt</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="Payment Receipt"id="example-text-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-secondary waves-effect">Save</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6>Your Shipment to Post delay</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Ship Date</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Ship Method</label>
                                            <div class="col-sm-12">
                                                <select class="form-control">
                                                    <option>Select</option>
                                                    <option>Large select</option>
                                                    <option>Small select</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Track ID</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="Trackin" id="example-datetime-local-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-secondary waves-effect">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Future Ship Date</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Modify Future Ship Date</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-secondary waves-effect">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    @endsection
