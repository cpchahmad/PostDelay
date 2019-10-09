<?php

namespace App\Http\Controllers;

use App\Address;
use App\BillingAddress;
use App\Customer;
use App\Order;
use App\OrderStatusHistory;
use App\PackageDetail;
use App\RecipientAddress;
use App\SenderAddress;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $validate_data = Validator::make($request->toArray(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'business' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
//           'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:255'],
            'shop' => ['required', 'string', 'max:255'],
        ]);

        if ($validate_data->fails()) {
            return response()->json($validate_data->messages(), 200);
        } else {
            $shop = Shop::where('shop_name', $request->input('shop'))->value('id');
          dd($this->helper->getShop($request->input('shop')));
            if ($shop != null) {
                $customer = $this->helper->getShop($request->input('shop'))->call([
                    'METHOD' => 'POST',
                    'URL' => '/admin/customers.json',
                    'DATA' => [
                        "customer" => [
                            "first_name" => $request->input("first_name"),
                            "last_name" => $request->input("last_name"),
                            "email" => $request->input("email"),
//                            "phone" => $request->input('phone'),
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
                        'state' => $request->input('state'),
                        'country' => $request->input('country'),
                        'postcode' => $request->input('postecode'),
                        'shop_id' => $shop,
                        'shopify_customer_id' => $customer->customer->id,
                    ]);
                }
                return response()->json(['msg' => 'created', 'customer_id' => $customer->customer->id], 200);
            } else {
                return response()->json('Shop Not Registered', 200);
            }
        }


    }

    public function sendactivationlink(Request $request)
    {

        $invite_send = $this->helper->getShop($request->input('shop'))->call([
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
        $shop = Shop::where('shop_name', $request->input('shop'))->value('id');
        $customer = Customer::where('shopify_customer_id', $request->input('customer_id'))->first();
        if ($shop != null && $customer != null) {

            $address = $this->helper->getShop($request->input('shop'))->call([
                'METHOD' => 'POST',
                'URL' => '/admin/customers/' . $customer->shopify_customer_id . '/addresses.json',
                'DATA' => [
                    "address" => [
                        "address1" => $request->input('address1'),
                        "address2" => $request->input('address2'),
                        "city" => $request->input('city'),
                        "company" => $request->input('business'),
                        "first_name" => $request->input('first_name'),
                        "last_name" => $request->input('last_name'),
                        "province" => $request->input('province'),
                        "country" => $request->input('country'),
                        "phone" => $request->input('phone'),
                        "zip" => $request->input('postecode'),
                        "name" => $request->input('first_name') . ' ' . $request->input('last_name'),
                    ]
                ]
            ]);

            if ($address != null) {
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
                    'shopify_address_id' => $address->customer_address->id

                ]);
            }


            return response()->json(['msg' => 'address_created'], 200);
        } else {
            return response()->json(['msg' => 'shop or customer not exists'], 200);
        }

    }

    public function get_customer_details(Request $request)
    {
        $shop = Shop::where('shop_name', $request->input('shop'))->value('id');
        $customer = Customer::where('shopify_customer_id', $request->input('customer_id'))
            ->where('shop_id', $shop)->first();
        $customer_addresses = Address::where('shopify_customer_id', $request->input('customer_id'))
            ->where('shop_id', $shop)->get();
        $returnHTML = view('customers.customer_detail', ['customer' => $customer, 'addresses' => $customer_addresses])->render();
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
            $shop = Shop::where('shop_name', $request->input('shop'))->value('id');

            if ($shop != null) {
//                $updated_customer = $this->helper->getShop($request->input('shop'))->call([
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
                        'state' => $request->input('state'),
                        'country' => $request->input('country'),
                        'postcode' => $request->input('postecode'),
                        'shop_id' => $shop,
                        'shopify_customer_id' => $request->input('customer_id'),
                    ]);
                }


                return response()->json(['msg' => 'Updated'], 200);

//            }

        }

    public function delete_all()
    {
        $customers = Customer::all();

//        foreach ($customers as $customer){
//           $orders =  $this->helper->getShop('postdelay.myshopify.com')->call([
//                'METHOD' => 'GET',
//                'URL' => 'admin/customers/' .$customer->shopify_customer_id. '/orders.json',
//                ]);
//           if(count($orders->orders) > 0){
//               foreach ($orders->orders as $order){
//                   $this->helper->getShop('postdelay.myshopify.com')->call([
//                       'METHOD' => 'DELETE',
//                       'URL' => 'admin/orders/' .$order->id. '.json',
//                   ]);
//               }
//           }
//           $customer =  $this->helper->getShop('postdelay.myshopify.com')->call([
//                'METHOD' => 'GET',
//                'URL' => 'admin/customers/' .$customer->shopify_customer_id. '.json',
//            ]);
//           if($customer->customer != null){
//               $this->helper->getShop('postdelay.myshopify.com')->call([
//                   'METHOD' => 'DELETE',
//                   'URL' => 'admin/customers/' .$customer->shopify_customer_id. '.json',
//               ]);
//           }
//
//
//        }

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
        $draft_orders = $this->helper->getShop('postdelay.myshopify.com')->call([
            'METHOD' => 'POST',
            'URL' => '/admin/draft_orders.json',
            'DATA' =>
                [
                    "draft_order" => [
                        'line_items' => [
                            [
                                "variant_id" => 30341585371217,

                                "quantity" => 1,
                            ]
                        ],
                        "customer" => [
                            "id" => 2442048176209,
                        ],
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

        dd($draft_orders);
    }

    public function get_customers(){
        $customers = $this->helper->getShop('postdelay.myshopify.com')->call([
            'METHOD' => 'GET',
            'URL' => '/admin/customers.json',
        ]);
        $customers = $customers->customers;
        $shop = Shop::where('shop_name','postdelay.myshopify.com')->value('id');
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



}

