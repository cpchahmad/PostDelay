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
                        <h4 class="page-title m-0">Threshold</h4>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table_custom">
                            <thead>
                            <tr>
                                <th scope="col">Threshold</th>
                                <th scope="col">Value</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <form action="{{route('threshold.update')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$settings->id}}">
                                    <td>Minimum Days between order date and send-out date</td>
                                    <td><input required type="number" class="form-control" name="min_threshold_ship_out_date" value="{{$settings->min_threshold_ship_out_date}}"></td>
                                    <td><input type="submit" class="btn btn-success btn-sm" value="Save"></td>
                                </form>
                            </tr>
                            <tr>
                                <form action="{{route('threshold.update')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$settings->id}}">
                                    <td>Minimum number of days for before ship-out date to allow ship-out date modification</td>
                                    <td><input required type="number" class="form-control" name="min_threshold_for_modify_ship_out_date" value="{{$settings->min_threshold_for_modify_ship_out_date}}"></td>
                                    <td><input type="submit" class="btn btn-success btn-sm" value="Save"></td>
                                </form>
                            </tr>
                            <tr>
                                <form action="{{route('threshold.update')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$settings->id}}">
                                    <td>Minimum number of days in the future for modified ship-out date</td>
                                    <td><input required type="number" class="form-control" name="max_threshold_for_modify_ship_out_date" value="{{$settings->max_threshold_for_modify_ship_out_date}}"></td>
                                    <td><input type="submit" class="btn btn-success btn-sm" value="Save"></td>
                                </form>
                            </tr>
                            <tr>
                                <form action="{{route('threshold.update')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$settings->id}}">
                                    <td>Minimum number of days before ship-out date to allow cancellation</td>
                                    <td><input required type="number" class="form-control" name="min_threshold_in_cancellation" value="{{$settings->min_threshold_in_cancellation}}"></td>
                                    <td><input type="submit" class="btn btn-success btn-sm" value="Save"></td>
                                </form>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
