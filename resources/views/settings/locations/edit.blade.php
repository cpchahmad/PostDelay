@extends('layout.admin')
@section('content')

    <script>
        document.getElementById('navbar-custom').style.display = "block";
    </script>

    <div class="row" >
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <h4 class="page-title" style="margin-left: 200px;margin-right: 200px;">Edit Location</h4>
                        <div class="card" style="margin-left: 200px;margin-right: 200px;margin-top: 20px">
                            <div class="card-body">
                                <form id="location_update_form" action="{{route('update_location')}}" method="post">
                                    @csrf
{{--                                    <div class="form-group row">--}}
{{--                                        <label class="col-sm-1 col-form-label">Shop</label>--}}
{{--                                        <div class="col-sm-11">--}}
{{--                                            <select name="shop_id" class="form-control">--}}
{{--                                                @foreach($shops as $shop)--}}
{{--                                                    <option @if($location->shop_id == $shop->id) selected @endif value="{{$shop->id}}">{{strtoupper(explode('.',$shop->shop_name)[0]) }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <input type="hidden" name="location_id" value="{{$location->id}}">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="shop_name">Shop</label>
                                            <input id="shop_name" class="form-control" name="shop_name" type="text" value="{{$location->shop_name}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="address1">Address1</label>
                                            <input id="address1" class="form-control" name="address1" type="text" value="{{$location->address1}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="address2">Address2</label>
                                            <input id="address2" class="form-control" name="address2" type="text" value="{{$location->address2}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="city">City</label>
                                            <input id="city" class="form-control" name="city" type="text" value="{{$location->city}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="state">State</label>
                                            <input id="state" class="form-control" name="state" type="text" value="{{$location->state}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="country">Country</label>
                                            <input id="country" class="form-control" name="country" type="text" value="{{$location->country}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="postcode">Zip</label>
                                            <input id="postcode" class="form-control" name="postcode" type="number" value="{{$location->postcode}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone">Phone</label>
                                            <input id="phone" class="form-control" name="phone" type="number" value="{{$location->phone}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-2">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Update</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

