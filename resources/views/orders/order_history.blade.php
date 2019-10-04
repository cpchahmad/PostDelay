@extends('layout.admin')
@section('content')
    <div class="row" style="margin-top:-60px;">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Order History</h4>
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
            <div class="card mb-0">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0 mt-0 font-14">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="text-dark collapsed">
                            Collapsible Group Item #1
                        </a>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table_custom">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Order Name</th>
{{--                                <th scope="col">Customer Email</th>--}}
                                <th scope="col">Order Placement Date</th>
                                <th scope="col">Price</th>
                                <th scope="col">Status</th>
                                <th scope="col">Updated At</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($logs as $index => $log)
                                <tr>
                                    <th>{{$index+1}}</th>
                                    <th scope="row"> <a href="{{route('order_update',$log->has_order->id)}}">{{$log->has_order->order_name}}</a></th>
{{--                                    <td>{{$log->has_order->has_customer->email}}</td>--}}
                                    <td> {{\Carbon\Carbon::parse($log->has_order->created_at)->format('F j ,Y')}}</td>
                                    <td> ${{$log->has_order->order_total}}</td>
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
@endsection
