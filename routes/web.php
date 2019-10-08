<?php


Route::get('/', function () {
    return view('welcome');
});
use Oseintow\Shopify\Facades\Shopify;

Route::get("install", function () {
//    if ($_GET["shop"]) {
//        $shopUrl = $_GET["shop"];
//        $scope = ["read_orders", "read_products", "read_product_listings", "write_orders",
//            "read_customers", "write_customers","read_script_tags", "write_script_tags","read_draft_orders",'write_draft_orders',
//            "read_shipping","write_shipping"];
//        $redirectUrl = env('APP_URL')."/auth";
//        $shopify = Shopify::setShopUrl($shopUrl);
//        return redirect()->to($shopify->getAuthorizeUrl($scope, $redirectUrl));
//    } else {
//        return 'Please enter shop url';
        $shopUrl = "https://postdelay.myshopify.com/";
        $scope = ["read_orders", "read_products", "read_product_listings", "write_orders",
            "read_customers", "write_customers","read_script_tags", "write_script_tags","read_draft_orders",'write_draft_orders',
            "read_shipping","write_shipping",
            ];
        $redirectUrl = env('APP_URL')."/auth";

        $shopify = Shopify::setShopUrl($shopUrl);
        return redirect()->to($shopify->getAuthorizeUrl($scope,$redirectUrl));

});

Route::get("auth", "ShopsController@index");
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

Route::get('/delete_all', 'CustomersController@delete_all')->name('delete_all');
Route::get('/draft', 'CustomersController@draft_orders')->name('draft_orders');
Route::get('/customer/get/new_order', 'OrdersController@show_new_order')->name('show_new_order');
Route::get('/customer/put/addresses', 'OrdersController@put_addresses')->name('put_addresses');

Route::get('/rates', 'CustomersController@get_rates')->name('get_rates');
Route::GET('/place/order', 'OrdersController@place_order')->name('place_order');
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

Route::POST('/webhook/create/order', 'WebhookController@webhook_order_create')->name('webhook.order.create');
//Route::POST('/webhook/update/order', 'WebhookController@webhook_order_update')->name('webhook.order.update');
//Route::POST('/webhook/delete/order', 'WebhookController@webhook_order_delete')->name('webhook.order.delete');

Route::GET('/webhook/insert', 'WebhookController@webhook')->name('webhook.insert');
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
