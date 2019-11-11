<div id="customer_{{ $customer->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content text-left">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Edit Customer Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">

                    <form id="update_customer_details_form" action="/customer/update" method="get">
                        <input type="hidden" name="customer_id" value="{{ $customer->shopify_customer_id }}">
                    <input type="hidden" name="shop" value="postdelay.myshopify.com">
                    <div class="form-group">
                        <label for="example-text-input" class="">Country</label>
                        <select class="form-control" name="country">
                            <option value="United States">United States</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="example-text-input" class="">First Name</label>
                                <input  type="text" name="first_name" class="form-control" value="{{ $customer->first_name }}">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="example-text-input" class="">Last Name</label>
                                <input  type="text" name="last_name" class="form-control" value="{{ $customer->last_name }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="">Street Address</label>
                        <input  type="text" name="address1" class="form-control" value="{{ $customer->address1 }}">
                        <input  type="text" name="address2" class="form-control mt-1" value="{{ $customer->address2 }}">
                    </div>

                    <div class="form-group">
                        <label for="example-text-input" class="">City</label>
                        <input  type="text" name="city" class="form-control" value="{{ $customer->city }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="example-text-input" class="">Province</label>
                                <select class="form-control" name="province" value="{{ $customer->state }}">
                                    @include('customers.inc.usa_states')
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="example-text-input" class="">Zipcode</label>
                                <input  type="text" name="postecode" class="form-control" value="{{ $customer->postcode }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="example-text-input" class="">Phone</label>
                                <input  type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="example-text-input" class="">Email</label>
                                <input  type="email" name="email" class="form-control" value="{{ $customer->email }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>