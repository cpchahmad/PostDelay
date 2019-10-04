<?php

namespace App\Http\Controllers;

use App\Address;
use App\BillingAddress;
use App\Customer;
use App\Order;
use App\PackageDetail;
use App\PostType;
use App\RecipientAddress;
use App\Scale;
use App\SenderAddress;
use App\Shape;
use App\Shop;
use App\Status;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new HelperController();
    }

    public function index(){
        $orders=Order::all();
        $status=Status::all();
        return view('orders.index',compact('orders','status'));
    }
    public function place_order(Request $request){


        $draft_orders = $this->helper->getShop('postdelay.myshopify.com')->call([
            'METHOD' => 'POST',
            'URL' => '/admin/draft_orders.json',
            'DATA' =>
                [
                    "draft_order" => [
                        'line_items' => [
                            [
                                "title"=> "PostDelay Fee",
                                "price"=> "100.00",
                                "quantity"=> 1,
                                "requires_shipping" => true,

                            ]
                        ],
                        "customer" => [
                            "id" => $request->input('customer_id'),
                        ],
                        "shipping_address" => [
                            "address1" => $request->input('receipent_address1'),
                            "address2" =>  $request->input('receipent_address2'),
                            "city" =>  $request->input('receipent_city'),
                            "company" =>  $request->input('receipent_business'),
                            "first_name" =>  $request->input('receipent_first_name'),
                            "last_name" =>  $request->input('receipent_last_name'),
                            "province" =>  $request->input('receipent_state'),
                            "country" =>  $request->input('receipent_country'),
                            "phone" =>  $request->input('receipent_phone'),
                            "zip" =>  $request->input('receipent_postecode'),
                            "name" =>  $request->input('receipent_first_name').' '.$request->input('receipent_last_name'),
                        ],
                        "billing_address" => [
                            "address1" => $request->input('billing_address1'),
                            "address2" =>  $request->input('billing_address2'),
                            "city" =>  $request->input('billing_city'),
                            "company" =>  $request->input('billing_business'),
                            "first_name" =>  $request->input('billing_first_name'),
                            "last_name" =>  $request->input('billing_last_name'),
                            "province" =>  $request->input('billing_state'),
                            "country" =>  $request->input('billing_country'),
                            "zip" =>  $request->input('billing_postecode'),
                            "name" =>  $request->input('billing_first_name').' '.$request->input('billing_last_name'),
                        ]

                    ]

                ]
        ]);
        $invoiceURL = $draft_orders->draft_order->invoice_url;
        $token = explode('/',$invoiceURL)[5];
        $order =  new Order();
        $order->draft_order_id =  $draft_orders->draft_order->id;
        $order->checkout_token = $token;
        $order->ship_out_date = $request->input('ship_out_date');
        $order->checkout_completed = 0;

        $customer = Customer::where('shopify_customer_id',$request->input('customer_id'))->first();

        $order->customer_id = $customer->id;
        $order->shopify_customer_id = $request->input('customer_id');

        $package_detail  = new PackageDetail();
        $package_detail->type = $request->input('post_type');
        $package_detail->special_holding = $request->input('special_holding');
        $package_detail->shape = $request->input('shape');
        $package_detail->scale = $request->input('unit_of_measures');
        $package_detail->weight = $request->input('weight');
        $package_detail->length = $request->input('length');
        $package_detail->girth = $request->input('girth');
        $package_detail->width = $request->input('width');
        $package_detail->height = $request->input('height');
        $package_detail->setUpdatedAt(now());
        $package_detail->setCreatedAt(now());
        $package_detail->save();

        $order->package_detail_id = $package_detail->id;

        $billing_address = new BillingAddress();
        $billing_address->address1 = $request->input('billing_address1');
        $billing_address->  address2 =  $request->input('billing_address2');
        $billing_address ->city =  $request->input('billing_city');
        $billing_address->business =  $request->input('billing_business');
        $billing_address->first_name =  $request->input('billing_first_name');
        $billing_address -> last_name =  $request->input('billing_last_name');
        $billing_address->state =  $request->input('billing_state');
        $billing_address->country =  $request->input('billing_country');
        $billing_address->postcode =  $request->input('billing_postecode');
        $billing_address->email =   $request->input('billing_email');
        $billing_address->save();

        $order->billing_address_id = $billing_address->id;

        $sender_address = new SenderAddress();
        $sender_address->address1 = $request->input('sender_address1');
        $sender_address->  address2 =  $request->input('sender_address2');
        $sender_address ->city =  $request->input('sender_city');
        $sender_address->business =  $request->input('sender_business');
        $sender_address->first_name =  $request->input('sender_first_name');
        $sender_address -> last_name =  $request->input('sender_last_name');
        $sender_address->state =  $request->input('sender_state');
        $sender_address->country =  $request->input('sender_country');
        $sender_address->postcode =  $request->input('sender_postecode');
        $sender_address->phone =   $request->input('sender_phone');
        $sender_address->save();

        $order->sender_address_id = $sender_address->id;

        $recipient_address = new RecipientAddress();
        $recipient_address->address1 = $request->input('receipent_address1');
        $recipient_address->  address2 =  $request->input('receipent_address2');
        $recipient_address ->city =  $request->input('receipent_city');
        $recipient_address->business =  $request->input('receipent_business');
        $recipient_address->first_name =  $request->input('receipent_first_name');
        $recipient_address -> last_name =  $request->input('receipent_last_name');
        $recipient_address->state =  $request->input('receipent_state');
        $recipient_address->country =  $request->input('receipent_country');
        $recipient_address->postcode =  $request->input('receipent_postecode');
        $recipient_address->phone =   $request->input('receipent_phone');
        $recipient_address->save();

        $order->recipient_address_id = $recipient_address->id;
        $order->save();

        return response()->json([
            "invoiceURL" => $invoiceURL,
        ]);
    }

    public function get_order(){
        $orders = $this->helper->getShop('postdelay.myshopify.com')->call([
            'METHOD' => 'GET',
            'URL' => '/admin/orders.json',
        ]);
        $orders = $orders->orders;

        foreach ($orders as $index => $order){
            $checkout_token =  explode('/',$order->landing_site)[3];
            $draft_order = Order::where('checkout_token',$checkout_token)->first();
            if($draft_order != NULL){
                $draft_order->checkout_completed = 1;
                $draft_order->shopify_order_id = $order->id;
                $draft_order->order_name = $order->name;
                $draft_order->order_total = $order->total_price;
                $draft_order->payment_gateway = $order->gateway;
                $draft_order->shipping_method_title = $order->shipping_lines[0]->title;
                $draft_order->shipping_method_id = $order->shipping_lines[0]->id;
                $draft_order->shipping_method_price = $order->shipping_lines[0]->price;
                $draft_order->shipping_method_source = $order->shipping_lines[0]->source;
                $draft_order->status_id =1;
                $draft_order->token = $order->token;
                $draft_order->save();
            }
        }
    }
    public function show_new_order(Request $request)
    {
        $shop = Shop::where('shop_name', $request->input('shop'))->value('id');
        $customer_addresses = Address::where('shopify_customer_id', $request->input('customer_id'))
            ->where('shop_id', $shop)->get();
        $shapes = Shape::all();
        $types = PostType::all();
        $scales = Scale::all();
        $returnHTML = view('customers.new_order', [
            'addresses' => $customer_addresses,
            'billing_address' => null,
            'sender_address' => null,
            'recipient_address' => null,
            'shapes'=>$shapes,
            'types' => $types,
            'scales'=>$scales
        ])->render();
        return response()->json([
            "html" => $returnHTML,
        ]);
    }

    public function put_addresses(Request $request)
    {
        $shop = Shop::where('shop_name', $request->input('shop'))->value('id');
        $customer_addresses = Address::where('shopify_customer_id', $request->input('customer_id'))
            ->where('shop_id', $shop)->get();
        $billing_address = Address::find($request->input('billing_address'));
        $sender_address = Address::find($request->input('sender_address'));
        $recipient_address = Address::find($request->input('recipient_address'));
        $shapes = Shape::all();
        $types = PostType::all();
        $scales = Scale::all();
        $returnHTML = view('customers.new_order', [
            'addresses' => $customer_addresses,
            'billing_address' => $billing_address,
            'sender_address' => $sender_address,
            'recipient_address' => $recipient_address,
            'shapes'=>$shapes,
            'types' => $types,
            'scales'=>$scales
        ])->render();
        return response()->json([
            "html" => $returnHTML,
        ]);
    }

    public function show_existing_orders(Request $request){
        $shop = Shop::where('shop_name', $request->input('shop'))->value('id');
        $customer = Customer::where('shopify_customer_id', $request->input('customer_id'))->first();
        $orders = Order::where('shopify_customer_id',$customer->shopify_customer_id)->where('checkout_completed',1)->get();
        $returnHTML = view('customers.existing_orders', ['orders' => $orders])->render();
        return response()->json([
            "html" => $returnHTML,
        ]);
    }

    public function getData(Request $request){

        if($request->input('customer_url') != null){
            $token = explode('/',$request->input('customer_url'))[5];
            $order = Order::where('token',$token)->first();
            if($order !=  null){
                $sender_form = view('customers.inc.sender_detail_form', ['order' => $order])->render();
                $order_status = view('customers.inc.order_status', ['order' => $order])->render();
                $shipment_details = view('customers.inc.package_detail', ['order' => $order])->render();
                $billing_email = view('customers.inc.billing_email', ['order' => $order])->render();
                $recepient_email = view('customers.inc.recepient_email', ['order' => $order])->render();
                return response()->json([
                    "sender_form_html" => $sender_form,
                    "order_status" => $order_status,
                    "shipment_details" => $shipment_details,
                    "billing_email" => $billing_email,
                    "recepient_email" => $recepient_email,
                ]);
            }
        }
    }
}
