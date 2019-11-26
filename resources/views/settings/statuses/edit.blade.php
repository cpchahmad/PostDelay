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
                        <h4 class="page-title m-0">Edit Status</h4>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{route('statuses.update_status')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$status->id}}">
                        <div class="row" style="margin: 10px 4px">
                            <div class="col-md-12">
                                <label for="status_name">Name</label>
                                <input type="text" id="status_name" class="form-control" name="name" value="{{$status->name}}">
                            </div>
                        </div>
                        <div class="row" style="margin: 10px 4px">
                            <div class="col-md-12">
                                <label  for="status_description">Description</label>
                                <textarea id="status_description" name="description" class="form-control" maxlength="225" rows="3" >{{$status->description}}</textarea>
{{--                                <input type="text" id="status_description" class="form-control" name="description" value="{{$status->description}}">--}}
                            </div>
                        </div>
                        <div class="row" style="margin: 10px 4px">
                            <div class="col-md-4">
                                <label  for="status_color">Color</label>
                                <input type="text" id="status_color" class="form-control" name="color" value="{{$status->color}}">
                            </div>
                            <div class="col-md-4">
                                <label  for="status_subject">Email Subject</label>
                                <input type="text" id="status_subject" class="form-control" name="subject" value="{{$status->subject}}">
                            </div>
                            <div class="col-md-4">
                                <label  for="status_button">Email Button Text</label>
                                <input type="text" id="status_button" class="form-control" name="button_text" value="{{$status->button_text}}">
                            </div>
                        </div>
                        <div class="row" style="margin: 10px 4px">
                            <div class="col-md-12">
                                <label for="status_message">Email Message</label>
                                <textarea id="status_message" name="message" class="form-control" maxlength="225" rows="3" >{{$status->message}}</textarea>
{{--                                <input type="textarea" id="status_message" class="form-control" name="message" value="">--}}
                            </div>
                        </div>
                        <div class="row" style="margin: 10px 4px">
                            <div class="col-md-2">
                                <button type="submit" class="btn  btn-success waves-effect waves-light"> Save </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
