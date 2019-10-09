@extends('layout.admin')
@section('content')

    <div class="row" style="margin-top:-60px;">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Customers</h4>
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
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table_custom">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Total Orders</th>
                                <th scope="col">city</th>
                                <th scope="col"> Country</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                <tr>
                                    <th scope="row">{{$customer->first_name}}  {{$customer->last_name}} </th>
                                    <td>{{$customer->email}} </td>
                                    <td>{{count($customer->has_orders)}}</td>
                                    <td>{{$customer->city}} </td>
                                    <td>{{$customer->country}} </td>
                                    <td>{{$customer->phone}} </td>
                                    <td>
                                        <a href="{{route('single_customer',$customer->id)}}">
                                            <button type="submit" class="btn btn-warning waves-effect waves-light btn-sm">View</button>
                                        </a>
                                        <button type="button" class="btn btn-danger waves-effect waves-light btn-sm">Delete</button>
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
