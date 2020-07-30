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
                        <h4 class="page-title m-0">App Messages</h4>
                    </div>
                </div>
            </div>

            <form action="{{route('app_messages.update')}}" method="post">
                @csrf
                <input type="hidden" name="setting_id" value="{{$settings->id}}">
                <div class="card">
                    <div class="card-body">
                        <h5>Shipment cancelled during shipment to PostDelay. Awaiting response from user.</h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless table_custom">
                                <thead>
                                <tr>
                                    <th scope="col">Responses</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Status 9</td>
                                    <td><input required type="text" class="form-control" name="status_7_option_1" value="{{$settings->status_7_option_1}}"></td>
                                </tr>

                                <tr>
                                    <td>Status 8</td>
                                    <td><input required type="text" class="form-control" name="status_7_option_2" value="{{$settings->status_7_option_2}}"></td>
                                </tr>
                                <tr>
                                    <td>Status 3</td>
                                    <td><input required type="text" class="form-control" name="status_7_option_3" value="{{$settings->status_7_option_3}}"></td>
                                </tr>


                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5>Shipment price has changed. Awaiting response from user.</h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless  table_custom">
                                <thead>
                                <tr>
                                    <th scope="col">Responses</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Status 16</td>
                                    <td><input required type="text" class="form-control" name="status_15_option_1" value="{{$settings->status_15_option_1}}"></td>
                                </tr>

                                <tr>
                                    <td>Status 17</td>
                                    <td><input required type="text" class="form-control" name="status_15_option_2" value="{{$settings->status_15_option_2}}"></td>
                                </tr>
                                <tr>
                                    <td>Status 18</td>
                                    <td><input required type="text" class="form-control" name="status_15_option_3" value="{{$settings->status_15_option_3}}"></td>
                                </tr>


                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5>Delivery failure. Awaiting response from user.</h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless table_custom">
                                <thead>
                                <tr>
                                    <th scope="col">Responses</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Status 20</td>
                                    <td><input required type="text" class="form-control" name="status_19_option_1" value="{{$settings->status_19_option_1}}"></td>
                                </tr>

                                <tr>
                                    <td>Status 21</td>
                                    <td><input required type="text" class="form-control" name="status_19_option_2" value="{{$settings->status_19_option_2}}"></td>
                                </tr>
                                <tr>
                                    <td>Status 22</td>
                                    <td><input required type="text" class="form-control" name="status_19_option_3" value="{{$settings->status_19_option_3}}"></td>
                                </tr>


                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="text-left mt-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
@endsection
