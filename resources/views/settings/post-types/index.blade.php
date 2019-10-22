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
                        <h4 class="page-title m-0">Post Types</h4>
                    </div>
                    <div class="col-md-4">
                        <button class="float-right d-none d-md-block btn btn-success btn-lg waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-center"> Add Type </button>
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
                                <th scope="col">Type </th>
                                <th scope="col">Commision Type</th>
                                <th scope="col">Commision</th>
                                <th scope="col">Weight (grams)</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($types as $index => $type)
                                <tr id="type_row_{{$type->id}}">

                                    <td>{{$index + 1}}</td>
                                    <td>
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <input class="form-control type-input" data-id="{{$type->id}}" type="text" value="{{$type->name}}">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <select class="form-control" name="commision_type">
                                            <option value="fixed">Fixed</option>
                                            <option valie="percentage">Percentage</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" name="commision_type" data-id="{{$type->id}}" type="text" value="">
                                    </td>
                                    <td>
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <input class="form-control weight-input" data-id="{{$type->id}}" type="number" value="{{$type->weight}}">
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <button data-id="{{$type->id}}" class="type_delete_button btn btn-danger waves-effect waves-light btn-sm">Delete</button>
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
                        <h5 class="modal-title mt-0">Add Post-Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('add_type')}}" method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="type_name">Name</label>
                                    <input id="type_name" class="form-control" name="name" type="text" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="weight">Default Weight</label>
                                    <input id="weight" class="form-control" name="weight" type="number" value="">
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
