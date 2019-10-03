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
            "read_shipping","write_shipping"];
        $redirectUrl = env('APP_URL')."/auth";

        $shopify = Shopify::setShopUrl($shopUrl);
        return redirect()->to($shopify->getAuthorizeUrl($scope,$redirectUrl));

});

Route::get("auth", "ShopsController@index");
Route::prefix('admin')->group(function () {
    Route::get('orders', 'OrdersController@index')->name('shop.orders');
    Route::get('customers', 'CustomersController@index')->name('shop.customers');
    Route::get('settings', 'SettingsController@index')->name('shop.settings');
});

Route::get('dashboard', 'ShopsController@Dashboard')->name('shop.dashboard');

Route::get('/customer/create', 'CustomersController@customer_create')->name('customer.create');
Route::get('/send-activation-link', 'CustomersController@sendactivationlink')->name('customer.sendactivationlink');
Route::get('/customer/add/address', 'CustomersController@add_customer_addresses')->name('customer.add_address');
Route::get('/customer/get/details', 'CustomersController@get_customer_details')->name('customer.get_details');
Route::get('/customer/update', 'CustomersController@update_customer_details')->name('customer.update');
Route::get('/customer/address/default', 'CustomersController@update_address_details')->name('address.set_default');
Route::get('/customer/address/delete', 'CustomersController@delete_address')->name('address.delete');

Route::get('/delete_all', 'CustomersController@delete_all')->name('delete_all');
Route::get('/draft', 'CustomersController@draft_orders')->name('draft_orders');
Route::get('/customer/get/new_order', 'OrdersController@show_new_order')->name('show_new_order');
Route::get('/customer/put/addresses', 'OrdersController@put_addresses')->name('put_addresses');

Route::get('/rates', 'CustomersController@get_rates')->name('get_rates');
Route::GET('/place/order', 'OrdersController@place_order')->name('place_order');
Route::GET('/sync-orders', 'OrdersController@get_order')->name('get_order');

Route::GET('/orders', 'OrdersController@show_existing_orders')->name('show_existing_orders');
Route::GET('/getdata', 'OrdersController@getData')->name('getData');
Route::get('/order_update/{id}','AdminController@order_update')->name('order_update');
Route::get('/single_customer/{id}','AdminController@single_customer')->name('single_customer');
