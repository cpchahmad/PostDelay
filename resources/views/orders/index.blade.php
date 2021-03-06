@extends('layout.admin')
@section('content')
    <div class="row" style="margin-top:-60px;">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Orders</h4>
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
            <div class="card">
                <div class="card-body">
                    @if(count($orders) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table_custom">
                            <thead>
                            <tr>
                                <th scope="col">Order Name</th>
                                <th scope="col">Customer Email</th>
                                <th scope="col">Order Placement Date</th>
                                <th scope="col">Price</th>
                                <th scope="col">Current Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <th scope="row"> <a href="{{route('order_update',$order->id)}}">{{$order->order_name}}</a></th>
                                <td>{{$order->has_customer->email}}</td>
                                <td> {{\Carbon\Carbon::parse($order->created_at)->format('F j ,Y')}}</td>
                                <td> ${{$order->order_total}}</td>
                                <td style="color:{{ $order->has_status->color  }};width: 300px">
                                    {{$order->has_status->name}}
                                </td>
                               <td>
{{--                                   <a href="{{route('order_history',$order->id)}}">--}}
{{--                                       <button type="submit" class="btn btn-info waves-effect waves-light btn-sm">View Status Log</button>--}}
{{--                                   </a>--}}
                                   <a class="btn btn-warning waves-effect waves-light btn-sm" href="{{route('order_update',$order->id)}}">
                                   View
                                   </a>
                                   <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light btn-sm" onclick="$(this).next().submit();">Delete</a>
                                   <form action="{{route('delete_order')}}" method="get" style="display: none;">
                                       <input type="hidden" value="{{$order->id}}" name="id">
                                       <input type="submit" class="form-control btn btn-danger waves-effect waves-light btn-sm" value="Delete">
                                   </form>
                               </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div class="text-center">
                            <i class="fas fa-user-alt-slash" style="font-size:25px; marin:15px 0;"></i>
                            <h6>No Record Found.</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
