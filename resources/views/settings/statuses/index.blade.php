@extends('layout.admin')
@section('content')

    <script>
        document.getElementById('navbar-custom').style.display = "block";
    </script>

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Statuses</h4>
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
                                <th scope="col">Status </th>
                                <th scope="col">Email </th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($statuses as $index => $status)
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td>
                                        {{$status->name}}
                                    </td>
                                    <td>
                                        @if(in_array($status->id,[1,9,16,17,20,21]))
                                            <h3>
                                                <span class="badge badge-danger">Disabled</span>
                                            </h3>
                                        @else
                                            <h3>
                                                <span class="badge badge-success">Enabled</span>
                                            </h3>
                                        @endif
                                    </td>

                                    <td>
                                        <button onclick="window.location.href='{{route('statuses.edit_status',['id' =>$status->id ])}}'" class="btn btn-info waves-effect waves-light btn-sm">View</button>
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
