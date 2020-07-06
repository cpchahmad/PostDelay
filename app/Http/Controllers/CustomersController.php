<?php

namespace App\Http\Controllers;

use App\Address;
use App\BillingAddress;
use App\Country;
use App\Customer;
use App\Mail\AccountDeletionEmail;
use App\Mail\SendAccountDeleteEmail;
use App\Order;
use App\OrderStatusHistory;
use App\PackageDetail;
use App\RecipientAddress;
use App\SenderAddress;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Oseintow\Shopify\Facades\Shopify;

class CustomersController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new HelperController();
    }

    public function customer_create(Request $request)
    {
//        dd($request);
        $shop = Shop::where('shopify_domain', $request->input('shop'))->value('id');
        $customer = Customer::where('email', $request->input('email'))->first();
        $response = '';

        if ($customer) {
            if($customer->status == 'invited'){
                $response = [
                    'status' => 'invited',
                    'msg' => 'Customer Already Invited, Please check your email address to verify or <a id="send_activation_link" data-shop="postdelay.myshopify.com" data-customer-id="'.$customer->shopify_customer_id.'">Click here</a> to resend the Invitation again.'
                ];
            }elseif ($customer->status == 'declined') {
                $response = [
                    'status' => 'declined',
                    'msg' => 'Customer Declined the Invitation, <a id="send_activation_link" data-shop="postdelay.myshopify.com" data-customer-id="'.$customer->shopify_customer_id.'">Click here</a> to resend the Invitation again.'
                ];
            }elseif($customer->status == 'enabled'){
                $response = [
                    'status' => 'enabled',
                    'msg' => 'Email Already Register, <a href="/account/login">Click here</a> to Login.'
                ];
            }elseif ($customer->status == 'disabled'){
                $response = [
                    'status' => 'disabled',
                    'msg' => 'Customer Account Disabled, Please contact customer support to enable the account.'
                ];
            }elseif ($customer->status == 'deleting'){
                $response = [
                    'status' => 'deleting',
                    'msg' => 'The Account associated with this email is in Deleting Process, Please contact customer support to enable the account.'
                ];
            } else{
                $response = [
                    'status' => 'error',
                    'msg' => 'Customer Already Invited, Please check your email address to verify or <a id="send_activation_link" data-shop="postdelay.myshopify.com" data-customer-id="'.$customer->shopify_customer_id.'">Click here</a> to resend the Invitation again.'
                ];
            }
        }else {

            if($request->input('receve-mail')){
                $subscription = true;
                $accept_marketing = 1;
            }else{
                $subscription = false;
                $accept_marketing = 0;
            }

            $customer = $this->helper->getShopify()->call([
                'METHOD' => 'POST',
                'URL' => '/admin/customers.json',
                'DATA' => [
                    "customer" => [
                        "first_name" => $request->input("first_name"),
                        "last_name" => $request->input("last_name"),
                        "email" => $request->input("email"),
                        "accepts_marketing" => $subscription,
                        "send_email_welcome" => false,
                        "verified_email" => false,
                        "send_email_invite" => true,

                    ]
                ]
            ]);

            if ($customer != null) {
                Customer::create([
                    'first_name' => $request->input("first_name"),
                    'last_name' => $request->input("last_name"),
                    'email' => $request->input("email"),
                    'business' => $request->input("business"),
                    'phone' => $request->input('phone'),
                    'address1' => $request->input('address1'),
                    'address2' => $request->input('address2'),
                    'city' => $request->input('city'),
                    'state' => $request->input('province'),
                    'country' => $request->input('country'),
                    'postcode' => $request->input('postecode'),
                    'accept_marketing' => $accept_marketing,
                    'shop_id' => $shop,
                    'status' => 'invited',
                    'shopify_customer_id' => $customer->customer->id,
                ]);
                $response = [
                    'status' => 'success',
                    'customer_id' => $customer->customer->id
                ];
            }
        }
        return json_encode($response);
    }

    public function sendactivationlink(Request $request)
    {

        $invite_send = $this->helper->getShopify()->call([
            'METHOD' => 'post',
            'URL' => 'admin/customers/' . $request->input('customer_id') . '/send_invite.json',
        ]);

        return response()->json(['invite_send' => 'created'], 200);
    }

    public function index()
    {

        $customers=Customer::orderBy('id', 'DESC')->get();
        $t_order=Order::all();
        return view('customers.index',compact('customers','t_order'));
    }

    public function add_customer_addresses(Request $request)
    {
        $shop = Shop::where('shopify_domain', $request->input('shop'))->value('id');
        $customer = Customer::where('shopify_customer_id', $request->input('customer_id'))->first();
        if ($shop != null && $customer != null) {
            /*Shopify Add Address Code*/
//            try{
//                $address = $this->helper->getShopify()->call([
//                    'METHOD' => 'POST',
//                    'URL' => '/admin/customers/' . $customer->shopify_customer_id . '/addresses.json',
//                    'DATA' => [
//                        "address" => [
//                            "address1" => $request->input('address1'),
//                            "address2" => $request->input('address2'),
//                            "city" => $request->input('city'),
//                            "company" => $request->input('business'),
//                            "first_name" => $request->input('first_name'),
//                            "last_name" => $request->input('last_name'),
//                            "province" => $request->input('province'),
//                            "country" => $request->input('country'),
//                            "phone" => $request->input('phone'),
//                            "zip" => $request->input('postecode'),
//                            "name" => $request->input('first_name') . ' ' . $request->input('last_name'),
//                        ]
//                    ]
//                ]);
//            }catch (\Exception $e){
//                $address = null;
//            }

            Address::create([
                'first_name' => $request->input("first_name"),
                'last_name' => $request->input("last_name"),
                'email' => $request->input("email"),
                'address_type' => $request->input('address_type'),
                'business' => $request->input("business"),
                'phone' => $request->input('phone'),
                'address1' => $request->input('address1'),
                'address2' => $request->input('address2'),
                'city' => $request->input('city'),
                'state' => $request->input('province'),
                'country' => $request->input('country'),
                'postcode' => $request->input('postecode'),
                'shop_id' => $shop,
                'shopify_customer_id' => $customer->shopify_customer_id,
                'customer_id' => $customer->id,
//                'shopify_address_id' => $address->customer_address->id
            ]);
            return response()->json(['msg' => 'address_created'], 200);

            /*  if ($address != null) {

                 }
                 else{
                     $old_record = Address::where('address_type', $request->input('address_type'))
                         ->where('first_name', $request->input('first_name'))
                         ->where('last_name', $request->input('last_name'))
                         ->where('email', $request->input('email'))
                         ->where('phone', $request->input('phone'))
                         ->where('address1', $request->input('address1'))
                         ->where('address2', $request->input('address2'))
                         ->where('city', $request->input('city'))
                         ->where('state', $request->input('province'))
                         ->where('country', $request->input('country'))
                         ->where('postcode', $request->input('postecode'))
                         ->where('shop_id', $shop)
                      ->exists();
                     if($old_record == false){
                         Address::create([
                             'first_name' => $request->input("first_name"),
                             'last_name' => $request->input("last_name"),
                             'email' => $request->input("email"),
                             'address_type' => $request->input('address_type'),
                             'business' => $request->input("business"),
                             'phone' => $request->input('phone'),
                             'address1' => $request->input('address1'),
                             'address2' => $request->input('address2'),
                             'city' => $request->input('city'),
                             'state' => $request->input('province'),
                             'country' => $request->input('country'),
                             'postcode' => $request->input('postecode'),
                             'shop_id' => $shop,
                             'shopify_customer_id' => $customer->shopify_customer_id,
                             'customer_id' => $customer->id,
                         ]);
                         return response()->json(['msg' => 'address_created'], 200);
                     }
                     else{
                         return response()->json(['msg' => 'shop or customer not exists'], 500);
                     }
                 }*/

        } else {
            return response()->json(['msg' => 'shop or customer not exists'], 500);
        }

    }

    public function get_customer_details(Request $request)
    {
        $shop = Shop::where('shopify_domain', $request->input('shop'))->value('id');
        $customer = Customer::where('shopify_customer_id', $request->input('customer_id'))
            ->where('shop_id', $shop)->first();
        $customer_addresses = Address::where('shopify_customer_id', $request->input('customer_id'))
            ->where('shop_id', $shop)->get();
        $countries = Country::all();
        $returnHTML = view('customers.customer_detail', [
            'customer' => $customer,
            'addresses' => $customer_addresses,
            'countries' => $countries
        ])->render();
        return response()->json([
            "html" => $returnHTML,
        ]);

    }

    public function update_customer_details(Request $request)
    {
        $customer = Customer::where('shopify_customer_id', $request->input('customer_id'))->first();
//        $validate_data = Validator::make($request->toArray(), [
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email,' . $customer->id],
//        ]);

//        if ($validate_data->fails()) {
//            return response()->json($validate_data->messages(), 200);
//        } else {
        $shop = Shop::where('shopify_domain', $request->input('shop'))->value('id');

        if ($shop != null) {
//                $updated_customer = $this->helper->getShopify()->call([
//                    'METHOD' => 'PUT',
//                    'URL' => '/admin/customers/' . $request->input('customer_id') . '.json',
//                    'DATA' => [
//                        "customer" => [
//                            "first_name" => $request->input("first_name"),
//                            "last_name" => $request->input("last_name"),
//                            "email" => $request->input("email"),
//                            "phone" => $request->input('phone'),
//                            "send_email_welcome" => false,
//                            "verified_email" => false,
//                            "send_email_invite" => true,
//
//                        ]
//                    ]
//                ]);
            Customer::where('shopify_customer_id', $request->input('customer_id'))->update([
                'first_name' => $request->input("first_name"),
                'last_name' => $request->input("last_name"),
                'email' => $request->input("email"),
                'business' => $request->input("business"),
                'phone' => $request->input('phone'),
                'address1' => $request->input('address1'),
                'address2' => $request->input('address2'),
                'city' => $request->input('city'),
                'state' => $request->input('province'),
                'country' => $request->input('country'),
                'postcode' => $request->input('postecode'),
                'shop_id' => $shop,
                'shopify_customer_id' => $request->input('customer_id'),
            ]);
        }


        if($request->input('source') == 'admin'){
            return redirect()->back();
        }else {
            return response()->json(['msg' => 'Updated'], 200);
        }
//            }

    }

    public function delete_all()
    {
        $customers = Customer::all();

        $orders =  $this->helper->getShopify()->call([
            'METHOD' => 'GET',
            'URL' => 'admin/orders.json',
        ]);
        if(count($orders->orders) > 0){
            foreach ($orders->orders as $order){
                $this->helper->getShopify()->call([
                    'METHOD' => 'DELETE',
                    'URL' => 'admin/orders/' .$order->id. '.json',
                ]);
            }
        }

        $shopify_customer =  $this->helper->getShopify()->call([
            'METHOD' => 'GET',
            'URL' => 'admin/customers.json',
        ]);

//           dd($shopify_customer);
        if(count($shopify_customer->customers) > 0) {
            foreach ($shopify_customer->customers as $customer) {
                $this->helper->getShopify()->call([
                    'METHOD' => 'DELETE',
                    'URL' => 'admin/customers/' . $customer->id . '.json',
                ]);
            }
        }

        DB::table('customers')->truncate();
        DB::table('addresses')->truncate();
        DB::table('billing_addresses')->truncate();
        DB::table('sender_addresses')->truncate();
        DB::table('recipient_addresses')->truncate();
        DB::table('key_dates')->truncate();
        DB::table('order_status_histories')->truncate();
        DB::table('package_details')->truncate();
        DB::table('orders')->truncate();
    }

    public function draft_orders()
    {
        $draft_orders = $this->helper->getShopify()->call([
            'METHOD' => 'POST',
            'URL' => '/admin/draft_orders.json',
            'DATA' =>
                [
                    "draft_order" => [
                        'line_items' => [
                            [
                                "title"=> "Draft Product",
                                "price"=> 100,
                                "quantity"=> 1,
                                "requires_shipping" => true,
                                "grams" =>1100,
                            ]
                        ],
//                        "customer" => [
//                            "id" => 2442048176209,
//                        ],
                        "shipping_address" => [
                            "address1" => "hkdjafk dsajkf ",
                            "address2" => "sadfljlajf ajsdofnj",
                            "city" => "NewYork",
                            "company" => "Creatify",
                            "first_name" => "Fazal",
                            "last_name" => "Khan",
                            "province" => "New York",
                            "country" => "United States",
                            "phone" => "613559856",
                            "zip" => "10001",
                            "name" => "Fazal Khan",
                        ],
                        "billing_address" => [
                            "address1" => "hkdjafk dsajkf ",
                            "address2" => "sadfljlajf ajsdofnj",
                            "city" => "NewYork",
                            "company" => "Creatify",
                            "first_name" => "Fazal",
                            "last_name" => "Khan",
                            "province" => "New York",
                            "country" => "United States",
                            "phone" => "613559856",
                            "zip" => "10001",
                            "name" => "Fazal Khan",
                        ]

                    ]

                ]
        ]);




//        $complete = $this->helper->getShopify()->call([
//            'METHOD' => 'PUT',
//            'URL' =>'/admin/api/2019-10/draft_orders/'.$draft_orders->draft_order->id.'/complete.json',
//    ]);

        dd($draft_orders);


//        $rates = $this->helper->getShopify()->call([
//            'METHOD' => 'GET',
//            'URL' => '/admin/api/2019-10/checkouts/'.'ede863e74844686f2de19f59e0052378'.'/shipping_rates.json',
//        ]);
//
//        dd($rates);
    }

    public function get_customers(){
        $customers = $this->helper->getShopify()->call([
            'METHOD' => 'GET',
            'URL' => '/admin/customers.json',
        ]);
        $customers = $customers->customers;
        $shop = Shop::where('shopify_domain','postdelay.myshopify.com')->value('id');
        foreach ($customers as $index => $customer){
            Customer::UpdateorCreate([
                'shopify_customer_id' => $customer->id
            ],[
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'email' => $customer->email,
                'shop_id' => $shop
            ]);
        }
    }

    public function delete_account(Request $request){

        $customer = Customer::where('shopify_customer_id',$request->input('customer'))->first();
        $customer->status = 'inactive';
        $customer->save();
//            $orders = $this->helper->getShopify()->call([
//                'METHOD' => 'GET',
//                'URL' => '/admin/customers/'.$customer->shopify_customer_id.'/orders.json',
//            ]);
//
//            $orders = $orders->orders;
//
//            foreach ($orders as $order){
//                $this->helper->getShopify()->call([
//                    'METHOD' => 'DELETE',
//                    'URL' => 'admin/orders/' .$order->id. '.json',
//                ]);
//            }
//
//            $this->helper->getShopify()->call([
//                'METHOD' => 'DELETE',
//                'URL' => 'admin/customers/' . $customer->shopify_customer_id . '.json',
//            ]);
//
//            $customer_orders = Order::where('customer_id',$customer->id)->delete();
        Mail::to($customer->email)->send(new AccountDeletionEmail($customer));
//            $customer->delete();


        if(!$request->ajax()){
            return redirect()->back();
        }
    }

    public function delete_account_confirmation(Request $request){
        $customer = Customer::where('shopify_customer_id',$request->input('customer'))->first();
        $customer->status = 'deleting';
        $customer->save();

        Mail::to($customer->email)->send(new SendAccountDeleteEmail($customer));

    }

    public function delete_account_from_email($id){

    }


    public function ResetAll(){
        $customers = $this->helper->getShopify()->call([
            'METHOD' => 'GET',
            'URL' => '/admin/customers.json'
        ]);
        foreach ($customers->customers as $customer){
            $orders = $this->helper->getShopify()->call([
                'METHOD' => 'GET',
                'URL' => '/admin/customers/'.$customer->id.'/orders.json',
            ]);
            foreach ($orders->orders as $order){
                $this->helper->getShopify()->call([
                    'METHOD' => 'DELETE',
                    'URL' => 'admin/orders/' .$order->id. '.json',
                ]);
            }
            $this->helper->getShopify()->call([
                'METHOD' => 'DELETE',
                'URL' => 'admin/customers/' . $customer->id . '.json',
            ]);

            $customer_orders = Order::where('customer_id',$customer->id)->delete();

        }
    }
    public function getCustomer($id){

        $customer = $this->helper->getShopify()->call([
            'METHOD' => 'GET',
            'URL' => '/admin/customers/'.$id.'.json',
        ]);

        dd($customer);
    }

    public function getWebhooks(){
        $APP_URL = 'https://postdelay.shopifyapplications.com';

//        $this->helper->getShopify()->call([
//            'METHOD' => 'POST',
//            'URL' => 'admin/webhooks.json',
//            "DATA" => [
//                "webhook" => [
//                    "topic" => "customers/create",
//                    "address" => $APP_URL.'/webhook/create/customer',
//                    "format" => "json"
//                ]
//            ]
//        ]);
//
//        $this->helper->getShopify(->call([
//            'METHOD' => 'POST',
//            'URL' => 'admin/webhooks.json',
//            "DATA" => [
//                "webhook" => [
//                    "topic" => "customers/update",
//                    "address" => $APP_URL.'/webhook/update/customer',
//                    "format" => "json"
//                ]
//            ]
//        ]);
//
//        $this->helper->getShopify()->call([
//            'METHOD' => 'POST',
//            'URL' => 'admin/webhooks.json',
//            "DATA" => [
//                "webhook" => [
//                    "topic" => "customers/delete",
//                    "address" => $APP_URL.'/webhook/delete/customer',
//                    "format" => "json"
//                ]
//            ]
//        ]);

//        $customer = $this->helper->getShopify()->call([
//            'METHOD' => 'GET',
//            'URL' => '/admin/webhooks.json',
//        ]);
//
//        foreach ($customer->webhooks as $webhook){
//            $customer = $this->helper->getShopify()->call([
//                'METHOD' => 'DELETE',
//                'URL' => '/admin/webhooks/'.$webhook->id.'.json',
//            ]);
//        }
//
        $customer = $this->helper->getShopify()->call([
            'METHOD' => 'GET',
            'URL' => '/admin/webhooks.json',
        ]);
        dd($customer);
    }

    public function check_customer_status(Request $request){
        $customer_status = Customer::where('email',$request->input('customer')['email'])->value('status');
        return response()->json([
            'status' => $customer_status
        ]);
    }

    public function update_customer_status(Request $request){
        $customer = Customer::where('email',$request->input('customer')['email'])->first();
        $customer->status = "enabled";
        $customer->save();
        return response()->json([
            'status' => $customer->status
        ]);
    }
    public function customer_status(Request $request){
        $customer = Customer::find($request->input('id'));
        $customer->status = $request->input('customer_status');
        $customer->save();
        return response()->json([
            'status' => $customer->status
        ]);
    }

}

