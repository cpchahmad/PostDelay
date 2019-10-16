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
                        <h4 class="page-title m-0">Post Delay Fee</h4>
                    </div>
                    <div class="col-md-4">
                        <button class="float-right d-none d-md-block btn btn-success btn-lg waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-center"> Add Fee </button>
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
                                <th scope="col">Name </th>
                                <th scope="cole">Type</th>
                                <th scope="col">Price</th>
                                <th scope="col">Default</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fees as $index => $fee)
                                <tr id="fee_row_{{$fee->id}}">

                                    <td>{{$index + 1}}</td>
                                    <td>
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <input class="form-control fee_name-input" data-id="{{$fee->id}}" type="text" value="{{$fee->name}}">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <select data-id="{{$fee->id}}"  class="form-control fee_type-select" >
                                                    <option @if($fee->type == 'primary') selected @endif value="primary">Primary</option>
                                                    <option @if($fee->type == 'additional') selected @endif value="additional">Additional</option>
                                                    <option @if($fee->type == 'request_form') selected @endif value="request_form">Request Form</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <input class="form-control fee_price-input" data-id="{{$fee->id}}" type="text" value="{{$fee->price}}">
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                      @if($fee->default == 0)
                                          <p>no</p>
                                          @else
                                        <p>yes</p>
                                        @endif
                                    </td>

                                    <td>
                                        <button data-type="{{$fee->type}}" data-id="{{$fee->id}}" class="make_default_fee_button btn btn-info waves-effect waves-light btn-sm">Make Default</button>
                                        <button data-id="{{$fee->id}}" class="fee_delete_button btn btn-danger waves-effect waves-light btn-sm">Delete</button>
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
                        <h5 class="modal-title mt-0">Add Post Delay Fee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('add_fee')}}" method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="fee_name">Name</label>
                                    <input id="fee_name" class="form-control" name="name" type="text" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="fee_name">Type</label>
                                    <select class="form-control" name="type" id="">
                                        <option value="primary">Primary</option>
                                        <option value="additional">Additional</option>
                                        <option value="request_form">Request Form</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="default" value="1">

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="fee_price">Price</label>
                                    <input id="fee_name" class="form-control" name="price" type="number" value="">
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
