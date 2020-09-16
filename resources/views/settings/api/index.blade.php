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
                        <h4 class="page-title m-0">APIs</h4>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table_custom">
                            <thead>
                            <tr>
                                <th scope="col">Api</th>
                                <th scope="col">Value</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <form action="{{route('api_credentials.usps.update')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="setting_id" value="{{$settings->id}}">

                                <td>USPS Credentials</td>
                                <td><input required type="text" class="form-control" name="usps_username" value="{{$settings->usps_username}}"></td>
                                <td><input type="submit" class="btn btn-success btn-sm" value="Save"></td>
                                </form>
                            </tr>
                            <tr>
                                <td>Google Address AutoComplete Credentials</td>
                                <td><input readonly id="google-address-api"  type="text" class="form-control" value="{{ $settings->google_api }}"></td>
                                <td><button class="btn btn-sm btn-primary copy-credentials">Copy</button></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
