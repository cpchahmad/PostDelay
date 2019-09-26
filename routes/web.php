<?php


Route::get('/', function () {
    return view('welcome');
});


use Oseintow\Shopify\Facades\Shopify;

Route::get("install", function () {
    if ($_GET["shop"]) {
        $shopUrl = $_GET["shop"];
        $scope = ["read_orders", "read_products", "read_product_listings", "write_orders", "read_customers", "write_customers","read_script_tags", "write_script_tags"];
        $redirectUrl = env('APP_URL')."/auth";
        $shopify = Shopify::setShopUrl($shopUrl);
        return redirect()->to($shopify->getAuthorizeUrl($scope, $redirectUrl));
    } else {
        return 'Please enter shop url';
    }
});

Route::get("auth", "ShopsController@index");
Route::get('dashboard', 'ShopsController@Dashboard')->name('shop.dashboard');
Route::get('orders', 'OrdersController@index')->name('shop.orders');
Route::get('customers', 'CustomersController@index')->name('shop.customers');
Route::get('settings', 'SettingsController@index')->name('shop.settings');

Route::get('/customer/create', 'CustomersController@customer_create')->name('customer.create');
Route::get('/send-activation-link', 'CustomersController@sendactivationlink')->name('customer.sendactivationlink');
