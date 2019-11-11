<div id="address_{{ $address->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content text-left">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Edit Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

<div class="modal-body">
    <form action="{{ route('update_address') }}" method="GET" class="update_address_admin">
        <input type="hidden" name="shopify_customer_id" value="{{ $address->shopify_customer_id }}">
        <input type="hidden" name="shop" value="postdelay.myshopify.com">
        <input type="hidden" name="address_id" value="{{ $address->id }}">

        <input type="hidden" name="address_type" value="{{ $address->address_type }}">
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
                    <input  type="text" name="first_name" class="form-control" value="{{ $address->first_name }}">
                </div>
            </div>

            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="example-text-input" class="">Last Name</label>
                    <input  type="text" name="last_name" class="form-control" value="{{ $address->last_name }}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="example-text-input" class="">Street Address</label>
            <input  type="text" name="address1" class="form-control" value="{{ $address->address1 }}">
            <input  type="text" name="address2" class="form-control mt-1" value="{{ $address->address2 }}">
        </div>

        <div class="form-group">
            <label for="example-text-input" class="">City</label>
            <input  type="text" name="city" class="form-control" value="{{ $address->city }}">
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="example-text-input" class="">Province</label>
                    <select class="form-control" name="province" value="{{ $address->state }}">
                        @include('customers.inc.usa_states')
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="example-text-input" class="">Zipcode</label>
                    <input  type="text" name="postecode" class="form-control" value="{{ $address->postcode }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="example-text-input" class="">Phone</label>
                    <input  type="text" name="phone" class="form-control" value="{{ $address->phone }}">
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="example-text-input" class="">Email</label>
                    <input  type="email" name="email" class="form-control" value="{{ $address->email }}">
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-primary address_update_btn">Update</button>
    </form>
</div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>