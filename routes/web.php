<?php


use Illuminate\Support\Facades\App;

Route::get('/', 'ShopsController@Dashboard')->name('home')->middleware('auth.shop');

Route::prefix('admin')->group(function () {
    Route::get('orders', 'OrdersController@index')->name('shop.orders');
    Route::get('customers', 'CustomersController@index')->name('shop.customers');
    Route::get('settings', 'SettingsController@show_shape')->name('shop.settings');
});

Route::get('dashboard', 'ShopsController@Dashboard')->name('shop.dashboard');

Route::get('/customer/create', 'CustomersController@customer_create')->name('customer.create');
Route::get('/send-activation-link', 'CustomersController@sendactivationlink')->name('customer.sendactivationlink');
Route::get('/customer/add/address', 'CustomersController@add_customer_addresses')->name('customer.add_address');
Route::get('/customer/get/details', 'CustomersController@get_customer_details')->name('customer.get_details');
Route::get('/customer/update', 'CustomersController@update_customer_details')->name('customer.update');
Route::get('/customer/address/default', 'AddressController@set_default_address')->name('address.set_default');
Route::get('/customer/address/delete', 'AddressController@delete_address')->name('address.delete');
Route::get('/customer/addresses/delete-address', 'AddressController@delete_customer_address')->name('customer.address.delete');

Route::get('/delete_all', 'CustomersController@delete_all')->name('delete_all');
Route::get('/draft', 'CustomersController@draft_orders')->name('draft_orders');
Route::get('/customer/get/new_order', 'OrdersController@show_new_order')->name('show_new_order');
Route::get('/customer/put/addresses', 'OrdersController@put_addresses')->name('put_addresses');

Route::GET('/place/order', 'OrdersController@place_order')->name('place_order');
Route::GET('/get_shipping_rates', 'OrdersController@get_shipping_rates')->name('get_shipping_rates');

Route::GET('/place/additional-payment', 'OrdersController@place_additional_payments')->name('place_additional_payments');
Route::GET('/sync-orders', 'OrdersController@get_order')->name('get_order');

Route::GET('/orders', 'OrdersController@show_existing_orders')->name('show_existing_orders');
Route::GET('/getdata', 'OrdersController@getData')->name('getData');


Route::GET('/get/addresses', 'AddressController@get_address')->name('get_address');
Route::GET('/get/addresses/type', 'AddressController@get_address_form')->name('get_address_form');
Route::GET('/update/address', 'AddressController@update_address')->name('update_address');

//Route::POST('/webhook/create/customer', 'WebhookController@webhook_customer_create')->name('webhook.customer.create');
//Route::POST('/webhook/update/customer', 'WebhookController@webhook_customer_update')->name('webhook.customer.update');
//Route::POST('/webhook/delete/customer', 'WebhookController@webhook_customer_delete')->name('webhook.customer.delete');
//
//Route::POST('/webhook/create/order', 'WebhookController@webhook_order_create')->name('webhook.order.create');
////Route::POST('/webhook/update/order', 'WebhookController@webhook_order_update')->name('webhook.order.update');
////Route::POST('/webhook/delete/order', 'WebhookController@webhook_order_delete')->name('webhook.order.delete');
//
//Route::GET('/webhook/insert', 'WebhookController@webhook')->name('webhook.insert');

Route::GET('/webhook/get', 'WebhookController@getWebhooks')->name('webhook.getWebhooks');

Route::get('/order_update/{id}','AdminController@order_update')->name('order_update');
Route::get('/single_customer/{id}','AdminController@single_customer')->name('single_customer');

Route::get('/setting/shape', 'SettingsController@show_shape')->name('shape.index');
Route::GET('/shape/update','SettingsController@update_shape')->name('update_shape');
Route::GET('/shape/delete','SettingsController@delete_shape')->name('delete_shape');
Route::POST('/shape/add','SettingsController@add_shape')->name('add_shape');

Route::get('/setting/type', 'SettingsController@show_type')->name('types.index');
Route::GET('/type/update','SettingsController@update_type')->name('update_type');
Route::GET('/type/delete','SettingsController@delete_type')->name('delete_type');
Route::POST('/type/add','SettingsController@add_type')->name('add_type');

Route::get('/setting/scales', 'SettingsController@show_scales')->name('scales.index');
Route::GET('/scale/update','SettingsController@update_scale')->name('update_scale');
Route::GET('/scale/delete','SettingsController@delete_scale')->name('delete_scale');
Route::POST('/scale/add','SettingsController@add_scale')->name('add_scale');


Route::get('/setting/locations', 'LocationController@show_locations')->name('locations.index');
Route::POST('/location/add', 'LocationController@add_location')->name('add_location');
Route::GET('/location/delete', 'LocationController@delete_location')->name('delete_location');
Route::GET('/location/edit/{id}', 'LocationController@show_edit_form')->name('show_edit_form');
Route::POST('/location/update/', 'LocationController@update_location')->name('update_location');

Route::get('/setting/post-delay-fee', 'SettingsController@show_post_delay_fee')->name('postdelayfee.index');


Route::POST('/post-delay-fee/add', 'SettingsController@add_fee')->name('add_fee');
Route::GET('/post-delay-fee/default', 'SettingsController@make_default_fee')->name('default_fee');
Route::GET('/post-delay-fee/update', 'SettingsController@update_fee')->name('update_fee');
Route::GET('/post-delay-fee/delete', 'SettingsController@delete_fee')->name('delete_fee');


Route::GET('/order/status/update', 'OrdersController@update_order_status')->name('update_order_status');
Route::GET('/order/log/{id}', 'OrdersController@order_history')->name('order_history');

Route::GET('/script_tag/insert', 'WebhookController@script_tag')->name('script.insert');
Route::GET('/script_tag/get', 'WebhookController@getScriptTags')->name('script.get');

Route::GET('/request-form', 'AddressController@get_billing_addresses')->name('get_billing_addresses');
Route::GET('/request-form/billing-address', 'AddressController@get_billing_form')->name('get_billing_form');

Route::GET('/get-order', 'OrdersController@get_order_type')->name('get_order');
Route::GET('/order/key-dates', 'OrdersController@set_key_dates')->name('set_key_dates');
Route::GET('/shipment-to-postdelay', 'OrdersController@shipment_to_postdelay')->name('shipment_to_postdelay');
Route::GET('/sync-customers', 'CustomersController@get_customers')->name('get_customers');
Route::GET('/download/pdf', 'OrdersController@download_pdf')->name('download_pdf');
Route::GET('/set_all_addresses', 'AddressController@set_all')->name('set_all');



Route::GET('/update/order/sender-details', 'OrdersController@update_order_sender_details')->name('update_order_sender_details');
Route::GET('/update/order/recipient-details', 'OrdersController@update_order_recipient_details')->name('update_order_recipient_details');
Route::GET('/update/order/billing-details', 'OrdersController@order_update_billing_details')->name('order_update_billing_details');
Route::GET('/update/order/outbound-tracking', 'OrdersController@update_tracking')->name('update_tracking');
Route::GET('/clear/order/received_post_date', 'OrdersController@clear_received_post_date')->name('clear_received_post_date');
Route::GET('/clear/order/completion_date', 'OrdersController@clear_completion_date')->name('clear_completion_date');
Route::GET('/checkout', 'OrdersController@get_checkout')->name('get_checkout');

Route::GET('/cancel/order', 'OrdersController@cancel_order')->name('cancel_order');
Route::GET('/delete/account/confirmation', 'CustomersController@delete_account_confirmation')->name('delete_account');
Route::GET('/delete/account', 'CustomersController@delete_account')->name('delete_account');
Route::GET('customer/{id}/delete', 'CustomersController@delete_account_from_email')->name('delete_account.from.email');
Route::GET('/delete/order', 'OrdersController@delete_order')->name('delete_order');

Route::GET('/reset_all', 'CustomersController@ResetAll')->name('reset');

Route::GET('/email', 'OrdersController@showEmail');

Route::get('/test', function () {
    $pdf = App::make('dompdf.wrapper');
    $pdf = $pdf->loadView('mailing_form');
    return $pdf->download('Mailing_form.pdf');
//    return view('mailing_form');
});

Route::GET('/c/{id}', 'CustomersController@getCustomer');
Route::GET('/webhooks', 'CustomersController@getWebhooks');

Route::POST('/response/customer', 'OrdersController@response_from_user')->name('response_from_user');
Route::GET('/check/customer/status', 'CustomersController@check_customer_status')->name('check_customer_status');
Route::GET('/update/customer/status', 'CustomersController@update_customer_status')->name('update_customer_status');
/*Admin side*/
Route::GET('/update/status', 'CustomersController@customer_status')->name('update.status');
/* End Admin side */
Route::get('/setting/statuses', 'SettingsController@show_statuses')->name('statuses.index');
Route::get('/status/{id}', 'SettingsController@edit_status')->name('statuses.edit_status');
Route::POST('/status/update', 'SettingsController@update_status')->name('statuses.update_status');


Route::get('/setting/threshold', 'SettingsController@show_threshold')->name('threshold.index');
Route::post('/setting/threshold/update', 'SettingsController@update_threshold')->name('threshold.update');

Route::post('/update/order/modify-date', 'OrdersController@update_modify_date')->name('order.modify.date');
Route::post('/update/order/additional-charges', 'OrdersController@update_order_extra_charges')->name('update_order_extra_charges');

Route::post('/update/order/modify-date/ajax', 'OrdersController@update_modify_date_ajax')->name('order.modify.date.ajax');



Route::get('/test/usps', 'OrdersController@testusps')->name('app.calculate_shipping');
Route::get('/get/re-calculate-form','OrdersController@get_re_calculate_form');
Route::get('/xml', 'OrdersController@testUspsXML');

Route::POST('/cancel/order/process', 'OrdersController@set_status_cancellation')->name('set_status_cancellation');
Route::get('/seed','OrdersController@seedData');
Route::get('/test/emails','OrdersController@test_emails');



Route::get('/setting/api', 'SettingsController@api_credentials')->name('api_credentials.index');
Route::POST('/setting/api/usps/update', 'SettingsController@update_usps_credentials')->name('api_credentials.usps.update');


Route::get('/setting/app/messages', 'SettingsController@app_messages')->name('app_messages.index');
Route::POST('/setting/app/messages/update', 'SettingsController@update_app_messages')->name('app_messages.update');

