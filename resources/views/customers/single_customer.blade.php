@extends('layout.admin')
@section('content')
    <div class="row" style="margin-top:-60px;">
        <div class="col-md-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Customer Details</h4>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#basic" role="tab">
                                <span class="d-none d-md-block">Basic Information</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#home" role="tab">
                                <span class="d-none d-md-block">Recipient Addresses</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                <span class="d-none d-md-block">Sender Addresses</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                                <span class="d-none d-md-block">Billing Addresses</span><span class="d-block d-md-none"><i class="mdi mdi-email h5"></i></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#settings" role="tab">
                                <span class="d-none d-md-block">Orders</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active p-3" id="basic" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover table_custom">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        {{--<th scope="col">Business</th>--}}
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Address1</th>
                                        <th scope="col">Address2</th>
                                        <th scope="col">City</th>
                                        <th scope="col">State</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">ZipCode</th>
                                        <td></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>{{$customer->first_name}} </td>
                                        <td>{{$customer->last_name}}</td>
                                        {{--<td>{{$customer->business}}</td>--}}
                                        <td>{{$customer->email}} </td>
                                        <td>{{$customer->phone}} </td>
                                        <td>{{$customer->address1}}</td>
                                        <td>{{$customer->address2}}</td>
                                        <td>{{$customer->city}}</td>
                                        <td>{{$customer->state}}</td>
                                        <td>{{$customer->country}}</td>
                                        <td>{{$customer->postcode}}</td>
                                        <th><button type="button" class="btn-sm btn-warning btn" data-toggle="modal" data-target="#customer_{{ $customer->id }}">Edit</button></th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            @include('inc.admin.customer_info_update')

                        </div>
                        <div class="tab-pane p-3" id="home" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover table_custom">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $count =1;
                                    @endphp
                                    @foreach($customer->has_addresses as $index => $address )
                                        @if($address->address_type == 'Recipients')
                                            <tr>
                                                <td>{{$count}}</td>
                                                <td>{{$address->address_type}} </td>
                                                <td>
                                                    {{$address->address1.' '.$address->address2.' , '.$address->city.' , '.$address->state.' , '.$address->country.','.$address->postcode}}
                                                </td>
                                                <td>{{$address->phone}} </td>
                                                <td>{{$address->email}} </td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#address_{{ $address->id }}">Edit</button>
                                                    <form action="{{route('address.delete')}}" method="get" style="display: inline-block;">
                                                        <input type="hidden" value="{{$address->id}}" name="address_id">
                                                        <button type="submit" class="btn btn-danger waves-effect waves-light btn-sm">Delete</button>
                                                    </form>



                                                                @include('inc.admin.address_update')



                                                </td>
                                            </tr>
                                            @php
                                                $count ++;
                                            @endphp
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane p-3" id="profile" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover table_custom">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $count =1;
                                    @endphp
                                    @foreach($customer->has_addresses as $index => $address )
                                        @if($address->address_type == 'Sender')
                                            <tr>
                                                <td>{{$count}}</td>
                                                <td>{{$address->address_type}} </td>
                                                <td>
                                                    {{$address->address1.' '.$address->address2.' , '.$address->city.' , '.$address->state.' , '.$address->country.','.$address->postcode}}
                                                </td>
                                                <td>{{$address->phone}} </td>
                                                <td>{{$address->email}} </td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#address_{{ $address->id }}">Edit</button>
                                                    <form action="{{route('address.delete')}}" method="get" style="display: inline-block;">
                                                        <input type="hidden" value="{{$address->id}}" name="address_id">
                                                        <button type="submit" class="btn btn-danger waves-effect waves-light btn-sm">Delete</button>
                                                    </form>
                                                    @include('inc.admin.address_update')
                                                </td>
                                            </tr>
                                            @php
                                                $count ++;
                                            @endphp
                                        @endif

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane p-3" id="messages" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover table_custom">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customer->has_addresses as $index => $address )
                                        @if($address->address_type == 'Billing')
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$address->address_type}} </td>
                                                <td>
                                                    {{$address->address1.' '.$address->address2.' , '.$address->city.' , '.$address->state.' , '.$address->country.','.$address->postcode}}
                                                </td>
                                                <td>{{$address->phone}} </td>
                                                <td>{{$address->email}} </td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#address_{{ $address->id }}">Edit</button>
                                                    <form action="{{route('address.delete')}}" method="get" style="display: inline-block;">
                                                        <input type="hidden" value="{{$address->id}}" name="address_id">
                                                        <button type="submit" class="btn btn-danger waves-effect waves-light btn-sm">Delete</button>
                                                    </form>
                                                    @include('inc.admin.address_update')
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane p-3" id="settings" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover table_custom">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Order Name</th>
                                        <th scope="col">Order Placement Date</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Current Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $count =1;
                                    @endphp
                                    @foreach($customer->has_orders as $index => $order)
                                        @if($order->checkout_completed == '1' && $order->additional_payment == '0')
                                            <tr>
                                                <td>{{$count}}</td>
                                                <th scope="row"> <a href="{{route('order_update',$order->id)}}">{{$order->order_name}}</a></th>
                                                <td> {{\Carbon\Carbon::parse($order->created_at)->format('F j ,Y')}}</td>
                                                <td> ${{$order->order_total}}</td>
                                                <td>
                                                    {{$order->has_status->name}}
                                                </td>
                                                <td>
                                                    <a href="{{route('order_update',$order->id)}}">
                                                        <button type="submit" class="btn btn-warning waves-effect waves-light btn-sm">View</button>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php
                                                $count ++;
                                            @endphp
                                        @endif

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
