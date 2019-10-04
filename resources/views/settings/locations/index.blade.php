@extends('layout.admin')
@section('content')

    <script>
        document.getElementById('navbar-custom').style.display = "block";
    </script>

    <div class="row" >
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Locations</h4>
                    </div>
                    <div class="col-md-4">
                        <button class="float-right d-none d-md-block btn btn-success btn-lg waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-center"> Add Location </button>
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
                                <th scope="col">Location</th>
                                <th scope="col">Contact Number</th>
                                <th scope="col">Shop</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($locations as $index => $location)
                                <tr id="location_row_{{$location->id}}">

                                    <td>{{$index + 1}}</td>
                                    <td>
                                        {{$location->address1.' '.$location->address2.' , '.$location->city.' , '.$location->state.' , '.$location->country.','.$location->postcode}}
                                    </td>
                                    <td>
                                        {{$location->phone}}
                                    </td>
                                    <td>
                                        {{$location->has_shop->shop_name}}
                                    </td>

                                    <td>
                                        <button onclick="window.location.href='{{route('show_edit_form',$location->id)}}'" class=" btn btn-primary waves-effect waves-light btn-sm">Edit</button>
                                        <button data-id="{{$location->id}}" class="location_delete_button btn btn-danger waves-effect waves-light btn-sm">Delete</button>
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

    <div class="col-sm-6 col-md-3 m-t-30">
        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0">Add Location</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('add_location')}}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Shop</label>
                                <div class="col-sm-10">
                                    <select name="shop_id" class="form-control">
                                        @foreach($shops as $shop)
                                            <option value="{{$shop->id}}">{{strtoupper(explode('.',$shop->shop_name)[0]) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="address1">Address1</label>
                                    <input id="address1" class="form-control" name="address1" type="text" value="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="address2">Address2</label>
                                    <input id="address2" class="form-control" name="address2" type="text" value="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="city">City</label>
                                    <input id="city" class="form-control" name="city" type="text" value="">
                                </div>
                                <div class="col-md-4">
                                    <label for="state">State</label>
                                    <input id="state" class="form-control" name="state" type="text" value="">
                                </div>
                                <div class="col-md-4">
                                    <label for="country">Country</label>
                                    <input id="country" class="form-control" name="country" type="text" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="postcode">Zip</label>
                                    <input id="postcode" class="form-control" name="postcode" type="number" value="">
                                </div>
                                <div class="col-md-6">
                                <label for="phone">Phone</label>
                                <input id="phone" class="form-control" name="phone" type="number" value="">
                            </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">Save</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>

@endsection

