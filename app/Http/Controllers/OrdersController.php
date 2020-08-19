<?php

namespace App\Http\Controllers;

use App\Address;
use App\BillingAddress;
use App\Customer;
use App\KeyDate;
use App\Location;
use App\Mail\AfterCancellationItemDisposed;
use App\Mail\AfterCancellationReturnPaymentReceived;
use App\Mail\CheckCostOrRefund;
use App\Mail\DisposeOrderAfterPriceIncrease;
use App\Mail\DisposeOrderAfterUndeliverable;
use App\Mail\DraftOrderComplete;
use App\Mail\FullManualRefund;
use App\Mail\MailingFormEmail;
use App\Mail\NotificationEmail;
use App\Mail\OrderMailOutLate;
use App\Mail\RequestFormAdminEmail;
use App\Mail\RequestFormEmail;
use App\Mail\ReturnOrderAfterPriceIncrease;
use App\Mail\ReturnOrderAfterUndeliverable;
use App\Mail\SendManualInvoice;
use App\Order;
use App\OrderLog;
use App\OrderResponse;
use App\OrderStatusHistory;
use App\PackageDetail;
use App\PostDelayFee;
use App\PostType;
use App\RecipientAddress;
use App\Scale;
use App\SenderAddress;
use App\Settings;
use App\Shape;
use App\Shop;
use App\Status;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use DateTime;
use Doctrine\DBAL\Schema\AbstractAsset;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Jasny\ISO\Countries;
use Jasny\ISO\CountrySubdivisions;
use SimpleXMLElement;
use USPS\Rate;
use USPS\RatePackage;

require_once 'library/ISO/CountrySubdivisions.php';
require_once 'library/ISO/Countries.php';

class OrdersController extends Controller
{
    protected $helper;
    protected $api;

    public function __construct()
    {
        $this->helper = new HelperController();
        $settings = Settings::all()->first();
        if($settings != null){
            $this->api = $settings->usps_username;
        }
        else{
            $this->api = '021POSTD3725';
        }

    }

    public function index()
    {
        $orders = Order::where('checkout_completed', 1)
            ->where('additional_payment', 0)->orderBy('order_name', 'DESC')->get();
        $status = Status::all();
        return view('orders.index', compact('orders', 'status'));
    }

    public function place_order(Request $request)
    {
//        dd($request);
        $line_items = [];
        $default = PostDelayFee::where('default', 1)->where('type', 'primary')->first();
        $weight = $request->input('weight');

//        array_push($line_items, [
//            "title"=> 'Postdelay Fee',
//            "price"=> $request->input('new_postdelay_fee'),
//            "quantity"=> 1,
//            "requires_shipping" => true,
//            "grams" =>$weight,
//        ]);

        array_push($line_items, [
            "variant_id" => $request->input('product_id'),
            "quantity" => 1,
        ]);

//        dd(CountrySubdivisions::getCode('United States','Alabama'));

        $draft_orders = $this->helper->getShopify()->call([
            'METHOD' => 'POST',
            'URL' => '/admin/draft_orders.json',
            'DATA' =>
                [
                    "draft_order" => [
                        'line_items' => $line_items,
                        "customer" => [
                            "id" => $request->input('customer_id'),
                        ],
                        "shipping_address" => [
                            "address1" => $request->input('receipent_address1'),
                            "address2" => $request->input('receipent_address2'),
                            "city" => $request->input('receipent_city'),
                            "company" => $request->input('receipent_business'),
                            "first_name" => $request->input('receipent_first_name'),
                            "last_name" => $request->input('receipent_last_name'),
                            "province" => $request->input('receipent_state'),
                            "country" => $request->input('receipent_country'),
                            "phone" => $request->input('receipent_phone'),
                            "zip" => $request->input('receipent_postecode'),
                            "name" => $request->input('receipent_first_name') . ' ' . $request->input('receipent_last_name'),
                            "country_code" => Countries::getCode($request->input('receipent_country')),
                            "province_code" => CountrySubdivisions::getCode($request->input('receipent_country'), $request->input('receipent_state'))
                        ],
                        "billing_address" => [
                            "address1" => $request->input('billing_address1'),
                            "address2" => $request->input('billing_address2'),
                            "city" => $request->input('billing_city'),
                            "company" => $request->input('billing_business'),
                            "first_name" => $request->input('billing_first_name'),
                            "last_name" => $request->input('billing_last_name'),
                            "province" => $request->input('billing_state'),
                            "country" => $request->input('billing_country'),
                            "zip" => $request->input('billing_postecode'),
                            "name" => $request->input('billing_first_name') . ' ' . $request->input('billing_last_name'),
                            "country_code" => Countries::getCode($request->input('billing_country')),
                            "province_code" => CountrySubdivisions::getCode($request->input('billing_country'), $request->input('billing_state'))
                        ],
                        "shipping_line" => [
                            "custom" => true,
                            "price" => $request->input('new_shipping_price'),
                            "title" => $request->input('shipping_method')
                        ],
//                        "use_customer_default_address" => false
                    ]

                ]
        ]);
//        dd($draft_orders);
        $invoiceURL = $draft_orders->draft_order->invoice_url;
        $token = explode('/', $invoiceURL)[5];
        $order = new Order();
        $order->draft_order_id = $draft_orders->draft_order->id;
        $order->checkout_token = $token;
        $order->ship_out_date = $request->input('ship_out_date');
        $order->checkout_completed = 0;

        $customer = Customer::where('shopify_customer_id', $request->input('customer_id'))->first();

        $order->customer_id = $customer->id;
        $order->shopify_customer_id = $request->input('customer_id');

        $package_detail = new PackageDetail();
        $package_detail->type = $request->input('post_type');
        $package_detail->special_holding = $request->input('special_holding');
        $package_detail->shape = $request->input('shape');
        $package_detail->scale = $request->input('unit_of_measures');
        $package_detail->weight = $weight;
        $package_detail->length = $request->input('length');
        $package_detail->girth = $request->input('girth');
        $package_detail->width = $request->input('width');
        $package_detail->height = $request->input('height');
        $package_detail->postcard_size =  $request->input('postcard_size');
        $package_detail->unit_of_measures_weight =  $request->input('unit_of_measures_weight');
        $package_detail->pounds =  $request->input('pounds');
        $package_detail->ounches =  $request->input('ounches');
        $package_detail->setUpdatedAt(now());
        $package_detail->setCreatedAt(now());
        $package_detail->save();

        $order->package_detail_id = $package_detail->id;

        $billing_address = new BillingAddress();
        $billing_address->address1 = $request->input('billing_address1');
        $billing_address->address2 = $request->input('billing_address2');
        $billing_address->city = $request->input('billing_city');
        $billing_address->business = $request->input('billing_business');
        $billing_address->first_name = $request->input('billing_first_name');
        $billing_address->last_name = $request->input('billing_last_name');
        $billing_address->state = $request->input('billing_state');
        $billing_address->country = $request->input('billing_country');
        $billing_address->postcode = $request->input('billing_postecode');
        $billing_address->email = $request->input('billing_phone');
        $billing_address->save();

        $order->billing_address_id = $billing_address->id;

        $sender_address = new SenderAddress();
        $sender_address->address1 = $request->input('sender_address1');
        $sender_address->address2 = $request->input('sender_address2');
        $sender_address->city = $request->input('sender_city');
        $sender_address->business = $request->input('sender_business');
        $sender_address->first_name = $request->input('sender_first_name');
        $sender_address->last_name = $request->input('sender_last_name');
        $sender_address->state = $request->input('sender_state');
        $sender_address->country = $request->input('sender_country');
        $sender_address->postcode = $request->input('sender_postecode');
        $sender_address->phone = $request->input('sender_phone');
        $sender_address->save();

        $order->sender_address_id = $sender_address->id;

        $recipient_address = new RecipientAddress();
        $recipient_address->address1 = $request->input('receipent_address1');
        $recipient_address->address2 = $request->input('receipent_address2');
        $recipient_address->city = $request->input('receipent_city');
        $recipient_address->business = $request->input('receipent_business');
        $recipient_address->first_name = $request->input('receipent_first_name');
        $recipient_address->last_name = $request->input('receipent_last_name');
        $recipient_address->state = $request->input('receipent_state');
        $recipient_address->country = $request->input('receipent_country');
        $recipient_address->postcode = $request->input('receipent_postecode');
        $recipient_address->phone = $request->input('receipent_phone');
        $recipient_address->save();

        $order->recipient_address_id = $recipient_address->id;
        $order->save();

        return response()->json([
            "invoiceURL" => $invoiceURL,
        ]);
    }

    public function get_order()
    {
        $orders = $this->helper->getShopify()->call([
            'METHOD' => 'GET',
            'URL' => '/admin/orders.json',
        ]);
        $orders = $orders->orders;

        foreach ($orders as $index => $order) {

            $checkout_token = explode('/', $order->landing_site)[3];
            $draft_order = Order::where('checkout_token', $checkout_token)
                ->where('checkout_completed', 0)->first();
            if ($draft_order != NULL) {

                $draft_order->checkout_completed = 1;
                $draft_order->shopify_order_id = $order->id;
                $draft_order->order_name = $order->name;
                $draft_order->order_total = $order->total_price;
                $draft_order->payment_gateway = $order->gateway;
                $draft_order->items = json_encode($order->line_items);
                if (count($order->shipping_lines) > 0) {
                    $draft_order->shipping_method_title = $order->shipping_lines[0]->title;
                    $draft_order->shipping_method_id = $order->shipping_lines[0]->id;
                    $draft_order->shipping_method_price = $order->shipping_lines[0]->price;
                    $draft_order->shipping_method_source = $order->shipping_lines[0]->source;

                }
                $draft_order->status_id = 1;
                $draft_order->token = $order->token;

                if (isset($order->billing_address)) {
                    if($draft_order->has_billing != null){
                        $draft_order->has_billing->first_name = $order->billing_address->first_name;
                        $draft_order->has_billing->last_name = $order->billing_address->last_name;
                        $draft_order->has_billing->address1 = $order->billing_address->address1;
                        $draft_order->has_billing->address2 = $order->billing_address->address2;
                        $draft_order->has_billing->city = $order->billing_address->city;
                        $draft_order->has_billing->state = $order->billing_address->province;
                        $draft_order->has_billing->country = $order->billing_address->country;
                        $draft_order->has_billing->business = $order->billing_address->company;
                        $draft_order->has_billing->postcode = $order->billing_address->zip;
                        $draft_order->has_billing->save();
                    }
                    else{
                        $billing = new BillingAddress();
                        $billing->first_name = $order->billing_address->first_name;
                        $billing->last_name = $order->billing_address->last_name;
                        $billing->address1 = $order->billing_address->address1;
                        $billing->address2 = $order->billing_address->address2;
                        $billing->city = $order->billing_address->city;
                        $billing->state = $order->billing_address->province;
                        $billing->country = $order->billing_address->country;
                        $billing->business = $order->billing_address->company;
                        $billing->postcode = $order->billing_address->zip;
                        $billing->save();
                        $draft_order->billing_address_id = $billing->id;
                        $draft_order->save();
                    }

                }
                if (isset($order->shipping_address)) {
                    if($draft_order->has_recepient != null) {
                        $draft_order->has_recepient->first_name = $order->shipping_address->first_name;
                        $draft_order->has_recepient->last_name = $order->billing_address->last_name;
                        $draft_order->has_recepient->address1 = $order->shipping_address->address1;
                        $draft_order->has_recepient->address2 = $order->shipping_address->address2;
                        $draft_order->has_recepient->city = $order->shipping_address->city;
                        $draft_order->has_recepient->state = $order->shipping_address->province;
                        $draft_order->has_recepient->country = $order->shipping_address->country;
                        $draft_order->has_recepient->business = $order->shipping_address->company;
                        $draft_order->has_recepient->postcode = $order->shipping_address->zip;
                        $draft_order->has_recepient->save();
                    }
                    else{
                        $recip = new RecipientAddress();
                        $recip->first_name = $order->shipping_address->first_name;
                        $recip->last_name = $order->shipping_address->last_name;
                        $recip->address1 = $order->shipping_address->address1;
                        $recip->address2 = $order->shipping_address->address2;
                        $recip->city = $order->shipping_address->city;
                        $recip->state = $order->shipping_address->province;
                        $recip->country = $order->shipping_address->country;
                        $recip->business = $order->shipping_address->company;
                        $recip->postcode = $order->shipping_address->zip;
                        $recip->save();
                        $draft_order->recipient_address_id = $recip->id;
                        $draft_order->save();
                    }
                }

                $draft_order->save();

                if ($draft_order->additional_payment == 1) {
                    if ($draft_order->additional_payment_name == 'Additional PostDelay Charges Payment') {
                        $res = OrderResponse::where('order_id', $draft_order->order_id)
                            ->where('fulfill', 0)->whereNotNull('response')->orderBy('created_at','DESC')->first();
                        $res->fulfill = 1;
                        $res->save();
                        $assosiate_order = Order::find($draft_order->order_id);
                        if($res->response == 20){
                            $assosiate_order->recipient_address_id = $draft_order->recipient_address_id;
                            $this->helper->getShopify()->call([
                                'METHOD' => 'PUT',
                                'URL' => '/admin/orders/'.$assosiate_order->shopify_order_id.'.json',
                                'DATA' => [
                                    "order" => [
                                        "shipping_address" => [
                                            "address1" => $draft_order->has_recepient->address1,
                                            "address2" =>  $draft_order->has_recepient->address2,
                                            "city" =>  $draft_order->has_recepient->city,
                                            "company" =>  $draft_order->has_recepient->business,
                                            "first_name" =>  $draft_order->has_recepient->first_name,
                                            "last_name" => $draft_order->has_recepient->last_name,
                                            "province" =>  $draft_order->has_recepient->state,
                                            "country" =>  $draft_order->has_recepient->country,
                                            "zip" =>  $draft_order->has_recepient->postcode,
                                            "name" => $draft_order->has_recepient->first_name . ' ' .  $draft_order->has_recepient->last_name,
                                            "country_code" => Countries::getCode( $draft_order->has_recepient->country),
                                            "province_code" => CountrySubdivisions::getCode( $draft_order->has_recepient->country,  $draft_order->has_recepient->state)
                                        ]
                                    ]
                                ]
                            ]);
                        }
                        else if(($res->response == 9)){
                            if($assosiate_order->payment_gateway != "Cash on Delivery (COD)"){
                                $this->helper->getShopify()->call([
                                    'METHOD' => 'POST',
                                    'URL' => '/admin/api/2019-10/orders/' . $assosiate_order->shopify_order_id . '/cancel.json',
                                    'DATA' => [
                                        "amount" => $assosiate_order->shipping_method_price,
                                        "currency" => 'USD'
                                    ]
                                ]);
                            }
                            else{
                                $this->helper->getShopify()->call([
                                    'METHOD' => 'POST',
                                    'URL' => '/admin/api/2019-10/orders/' . $assosiate_order->shopify_order_id . '/cancel.json',
                                ]);
                            }
                        }
                        $assosiate_order->status_id = $res->response;
                        $assosiate_order->save();
                        $this->status_log($assosiate_order);
                        $customer = Customer::find($assosiate_order->customer_id);

                        if(in_array($assosiate_order->status_id,[3,16,20])){
                            $date = new DateTime($order->ship_out_date);
                            $now = new DateTime();
                            if($date < $now) {
                                Mail::to('admin@postdelay.com')->send(new OrderMailOutLate($customer, $assosiate_order));
                            }
                        }

                        if(in_array($assosiate_order->status_id,[9])){
                            Mail::to('admin@postdelay.com')->send(new AfterCancellationReturnPaymentReceived($customer, $assosiate_order));
                        }

                        if(in_array($assosiate_order->status_id,[17])){
                            Mail::to('admin@postdelay.com')->send(new ReturnOrderAfterPriceIncrease($customer, $assosiate_order));
                        }

                        if(in_array($assosiate_order->status_id,[21])){
                            Mail::to('admin@postdelay.com')->send(new ReturnOrderAfterUndeliverable($customer, $assosiate_order));
                        }


//                        Mail::to($customer->email)->send(new NotificationEmail($customer, $assosiate_order));
                    } else {
                        $assosiate_order = Order::find($draft_order->order_id);
                        $customer = Customer::find($assosiate_order->customer_id);
                        Mail::to('papercopy@postdelay.com')->send(new RequestFormAdminEmail($assosiate_order,$draft_order,$customer));

                    }

                } else {
                    $old_history = OrderStatusHistory::where('order_id', $draft_order->id)->first();
                    if ($old_history == null) {
                        $history = new OrderStatusHistory();
                        $history->order_id = $draft_order->id;
                        $history->order_status_id = $draft_order->status_id;
                        $history->change_at = now();
                        $history->setCreatedAt(now());
                        $history->setUpdatedAt(now());
                        $history->save();
                    }
                }
            }
        }
    }

    public function show_new_order(Request $request)
    {
        $shop = Shop::where('shopify_domain', $request->input('shop'))->value('id');
        $customer_addresses = Address::where('shopify_customer_id', $request->input('customer_id'))
            ->where('shop_id', $shop)->get();
        $shapes = Shape::all();
        $types = PostType::all();
        $scales = Scale::all();
        $fee = PostDelayFee::where('default', 1)->where('type', 'primary')->first();
        $settings = Settings::all()->first();
        if($settings == null){
            $settings =  new Settings();
            $settings->min_threshold_ship_out_date = 7;
            $settings->min_threshold_for_modify_ship_out_date = 5;
            $settings->max_threshold_for_modify_ship_out_date = 5;
            $settings->save();
        }
        $returnHTML = view('customers.new_order', [
            'customer_id' => $request->input('customer_id'),
            'addresses' => $customer_addresses,
            'billing_address' => null,
            'sender_address' => null,
            'recipient_address' => null,
            'shapes' => $shapes,
            'types' => $types,
            'scales' => $scales,
            'fee' => $fee,
            'settings' => $settings
        ])->render();
        return response()->json([
            "html" => $returnHTML,
        ]);
    }

    public function put_addresses(Request $request)
    {
        $shop = Shop::where('shopify_domain', $request->input('shop'))->value('id');
        $customer_addresses = Address::where('shopify_customer_id', $request->input('customer_id'))
            ->where('shop_id', $shop)->get();
        $billing_address = Address::find($request->input('billing_address'));
        $sender_address = Address::find($request->input('sender_address'));
        $recipient_address = Address::find($request->input('recipient_address'));
        $shapes = Shape::all();
        $types = PostType::all();
        $scales = Scale::all();
        $fee = PostDelayFee::where('default', 1)->where('type', 'primary')->first();
        $settings = Settings::all()->first();
        if($settings == null){
            $settings =  new Settings();
            $settings->min_threshold_ship_out_date = 7;
            $settings->min_threshold_for_modify_ship_out_date = 5;
            $settings->max_threshold_for_modify_ship_out_date = 5;
            $settings->save();
        }
        $returnHTML = view('customers.new_order', [
            'customer_id' => $request->input('customer_id'),
            'addresses' => $customer_addresses,
            'billing_address' => $billing_address,
            'sender_address' => $sender_address,
            'recipient_address' => $recipient_address,
            'shapes' => $shapes,
            'types' => $types,
            'scales' => $scales,
            'fee' => $fee,
            'settings' => $settings
        ])->render();
        return response()->json([
            "html" => $returnHTML,
        ]);
    }

    public function show_existing_orders(Request $request)
    {
        $shop = Shop::where('shopify_domain', $request->input('shop'))->value('id');
        $customer = Customer::where('shopify_customer_id', $request->input('customer_id'))->first();
        $orders = Order::where('shopify_customer_id', $customer->shopify_customer_id)->where('checkout_completed', 1)
            ->where('additional_payment', 0)->orderBy('order_name', 'DESC')->get();
        $returnHTML = view('customers.existing_orders', ['orders' => $orders])->render();
        return response()->json([
            "html" => $returnHTML,
        ]);
    }

    public function getData(Request $request)
    {

        if ($request->input('customer_url') != null) {
            $token = explode('/', $request->input('customer_url'))[5];
            $order = Order::where('token', $token)->first();
            $response = OrderResponse::where('order_id', $order->id)->where('fulfill', 0)->first();
            $settings = Settings::all()->first();
            if($settings == null){
                $settings =  new Settings();
                $settings->min_threshold_ship_out_date = 7;
                $settings->min_threshold_for_modify_ship_out_date = 5;
                $settings->max_threshold_for_modify_ship_out_date = 5;
                $settings->usps_username = '021POSTD3725';
                $settings->status_7_option_1 = 'Return my mailing to me.';
                $settings->status_7_option_2 = 'Dispose of my mailing.';
                $settings->status_7_option_3 = 'Uncancel the order';
                $settings->status_15_option_1 = 'Pay additional cost to continue shipment.';
                $settings->status_15_option_2 = 'Return item to me.';
                $settings->status_15_option_3 = 'Dispose of item. - $0.00';
                $settings->status_19_option_1 = 'Charge Extra and Re-attempt Delivery Process';
                $settings->status_19_option_2 = 'Charge Extra and Return my shipment';
                $settings->status_19_option_3 = 'Dispose my shipment';
                $settings->save();
            }
            if ($order != null) {
                $sender_form = view('customers.inc.sender_detail_form', ['order' => $order])->render();
                $order_status = view('customers.inc.order_status', ['order' => $order])->render();
                $shipment_details = view('customers.inc.package_detail', ['order' => $order])->render();
                $billing_email = view('customers.inc.billing_email', ['order' => $order])->render();
                $recepient_email = view('customers.inc.recepient_email', ['order' => $order])->render();
                $additional_fee = view('customers.inc.additional_fee', ['order' => $order, 'response' => $response])->render();
                $keydate = view('customers.inc.keydate', ['order' => $order,'settings'=>$settings])->render();
                $shipment_to_postdelay = view('customers.inc.shipment_to_postdelay', ['order' => $order])->render();
                if (in_array($order->status_id, [7, 10, 15, 19])) {
                    $response_form_status = 'yes';
                    $response_form = view('customers.inc.response_form', ['order' => $order,'settings'=>$settings])->render();
                } else {
                    $response_form_status = 'no';
                    $response_form = null;
                }
                return response()->json([
                    "sender_form_html" => $sender_form,
                    "order_status" => $order_status,
                    "shipment_details" => $shipment_details,
                    "billing_email" => $billing_email,
                    "recepient_email" => $recepient_email,
                    "additional_fee" => $additional_fee,
                    "keydate" => $keydate,
                    "shipment_to_postdelay" => $shipment_to_postdelay,
                    "response_form" => $response_form,
                    "response_form_status" => $response_form_status
                ]);
            }
        }
    }

    public function update_order_status(Request $request)
    {
        $order_old_status = Order::find($request->input('order'));
        Order::find($request->input('order'))->update([
            'status_id' => $request->input('status')
        ]);



        $order = Order::find($request->input('order'));
        $this->status_log($order);
        if($request->input('status') == 15){
            $order->additional_cost_to_ship = 10;
            $order->additional_cost_to_return = 10;
            $order->save();
        }

        if($order->status_id == 9){
            if($order_old_status->status_id == 10){
                $customer = Customer::find($order->customer_id);
                Mail::to($customer->email)->send(new NotificationEmail($customer, $order));
            }
        }
        else{
            $customer = Customer::find($order->customer_id);
            Mail::to($customer->email)->send(new NotificationEmail($customer, $order));
        }


        /*Email to Admin*/
        /*Order Mail Out Late Email to PostDelay*/
        if(in_array($order->status_id,[3,16,20])){
            $date = new DateTime($order->ship_out_date);
            $now = new DateTime();
            if($date < $now) {
                Mail::to('admin@postdelay.com')->send(new OrderMailOutLate($customer, $order));
            }
        }

        if(in_array($order->status_id,[8])){
            Mail::to('admin@postdelay.com')->send(new AfterCancellationItemDisposed($customer, $order));
        }

        if(in_array($order->status_id,[9])){
            Mail::to('admin@postdelay.com')->send(new AfterCancellationReturnPaymentReceived($customer, $order));
        }

        if(in_array($order->status_id,[17])){
            Mail::to('admin@postdelay.com')->send(new ReturnOrderAfterPriceIncrease($customer, $order));
        }

        if(in_array($order->status_id,[18])){
            Mail::to('admin@postdelay.com')->send(new DisposeOrderAfterPriceIncrease($customer, $order));
        }

        if(in_array($order->status_id,[21])){
            Mail::to('admin@postdelay.com')->send(new ReturnOrderAfterUndeliverable($customer, $order));
        }

        if(in_array($order->status_id,[22])){
            Mail::to('admin@postdelay.com')->send(new DisposeOrderAfterUndeliverable($customer, $order));
        }

        if(in_array($order->status_id,[6])){
            Mail::to('admin@postdelay.com')->send(new FullManualRefund($customer, $order));
        }

        if(in_array($order->status_id,[14])){
            Mail::to('admin@postdelay.com')->send(new CheckCostOrRefund($customer, $order));
        }

        if(in_array($order->status_id,[10])){
            Mail::to('admin@postdelay.com')->send(new SendManualInvoice($customer, $order));
        }

        return response()->json([
            'status' => 'changed'
        ]);
    }

    public function order_history(Request $request)
    {
        $logs = OrderStatusHistory::where('order_id', $request->id)->get();
        return view('orders.order_history')->with([
            'logs' => $logs
        ]);
    }

    public function place_additional_payments(Request $request)
    {

        $associate_order = Order::where('shopify_order_id', $request->input('order-id'))->first();
        $shop = Shop::where('shopify_domain', $request->input('shop'))->first();
        if ($request->input('type') == 'additional-fee') {
            $default = PostDelayFee::where('default', 1)->where('type', 'additional')->first();
            $product = $this->helper->getShopify()->call([
                'METHOD' => 'POST',
                'URL' => '/admin/api/2019-10/products.json',
                'DATA' => [
                    "product" => [
                        "title" => $default->name,
                        "variants" => [
                            [
                                "price" => $default->price,
                            ]
                        ]
                    ],
                ]
            ]);
            $image = $this->helper->getShopify()->call([
                'METHOD' => 'POST',
                'URL' => '/admin/api/2019-10/products/' . $product->product->id . '/images.json',
                'DATA' => [
                    'image' => [
                        'src' => 'https://cdn.shopify.com/s/files/1/0120/3106/6193/files/Screenshot_36.png'
                    ]
                ]
            ]);
            $product_id = $product->product->variants[0]->id;
            if(in_array($request->input('response'),[17])){
                $draft_orders = $this->helper->getShopify()->call([
                    'METHOD' => 'POST',
                    'URL' => '/admin/draft_orders.json',
                    'DATA' =>
                        [
                            "draft_order" => [
                                'line_items' => [
                                    [
                                        "variant_id" => $product_id,
                                        "quantity" => 1,
                                        "properties" => [
                                            [
                                                "name" => 'Response',
                                                "value" => $request->input('response'),
                                            ],
                                        ]
                                    ]
                                ],
                                "customer" => [
                                    "id" => $request->input('customer-id'),
                                ],
                                "billing_address" => [
                                    "address1" => $associate_order->has_billing->address1,
                                    "address2" =>  $associate_order->has_billing->address2,
                                    "city" =>  $associate_order->has_billing->city,
                                    "company" =>  $associate_order->has_billing->business,
                                    "first_name" =>  $associate_order->has_billing->first_name,
                                    "last_name" => $associate_order->has_billing->last_name,
                                    "province" =>  $associate_order->has_billing->state,
                                    "country" =>  $associate_order->has_billing->country,
                                    "zip" =>  $associate_order->has_billing->postcode,
                                    "name" => $associate_order->has_billing->first_name . ' ' .  $associate_order->has_billing->last_name,
                                    "country_code" => Countries::getCode( $associate_order->has_billing->country),
                                    "province_code" => CountrySubdivisions::getCode( $associate_order->has_billing->country,  $associate_order->has_billing->state)
                                ],
                                "shipping_address" => [
                                    "address1" => $request->input('address1'),
                                    "address2" => $request->input('address2'),
                                    "city" => $request->input('city'),
                                    "company" => $request->input('business'),
                                    "first_name" => $request->input('first_name'),
                                    "last_name" => $request->input('last_name'),
                                    "province" => $request->input('state'),
                                    "country" => $request->input('country'),
                                    "zip" => $request->input('postcode'),
                                    "name" => $request->input('first_name') . ' ' . $request->input('last_name'),
                                    "country_code" => Countries::getCode($request->input('country')),
                                    "province_code" => CountrySubdivisions::getCode($request->input('country'), $request->input('state'))
                                ],
                                "shipping_line" => [
                                    "custom" => true,
                                    "price" => $request->input('new_shipping_price'),
                                    "title" => $request->input('shipping_method')
                                ],

                            ]

                        ]
                ]);
            }
            if(in_array($request->input('response'),[9])){
                $product = $this->helper->getShopify()->call([
                    'METHOD' => 'POST',
                    'URL' => '/admin/api/2019-10/products.json',
                    'DATA' => [
                        "product" => [
                            "title" =>   $default->name,
                            "variants" => [
                                [
                                    "price" =>  0,
                                ]
                            ]
                        ],
                    ]
                ]);

                $image = $this->helper->getShopify()->call([
                    'METHOD' => 'POST',
                    'URL' => '/admin/api/2019-10/products/' . $product->product->id . '/images.json',
                    'DATA' => [
                        'image' => [
                            'src' => 'https://cdn.shopify.com/s/files/1/0120/3106/6193/files/Screenshot_36.png'
                        ]
                    ]
                ]);


                $product_id = $product->product->variants[0]->id;
                $draft_orders = $this->helper->getShopify()->call([
                    'METHOD' => 'POST',
                    'URL' => '/admin/draft_orders.json',
                    'DATA' =>
                        [
                            "draft_order" => [
                                'line_items' => [
                                    [
                                        "variant_id" => $product_id,
                                        "quantity" => 1,
                                        "properties" => [
                                            [
                                                "name" => 'Response',
                                                "value" => $request->input('response'),
                                            ],
                                        ]
                                    ]
                                ],
                                "customer" => [
                                    "id" => $request->input('customer-id'),
                                ],
                                "billing_address" => [
                                    "address1" => $associate_order->has_billing->address1,
                                    "address2" =>  $associate_order->has_billing->address2,
                                    "city" =>  $associate_order->has_billing->city,
                                    "company" =>  $associate_order->has_billing->business,
                                    "first_name" =>  $associate_order->has_billing->first_name,
                                    "last_name" => $associate_order->has_billing->last_name,
                                    "province" =>  $associate_order->has_billing->state,
                                    "country" =>  $associate_order->has_billing->country,
                                    "zip" =>  $associate_order->has_billing->postcode,
                                    "name" => $associate_order->has_billing->first_name . ' ' .  $associate_order->has_billing->last_name,
                                    "country_code" => Countries::getCode( $associate_order->has_billing->country),
                                    "province_code" => CountrySubdivisions::getCode( $associate_order->has_billing->country,  $associate_order->has_billing->state)
                                ],
                                "shipping_address" => [
                                    "address1" => $request->input('address1'),
                                    "address2" => $request->input('address2'),
                                    "city" => $request->input('city'),
                                    "company" => $request->input('business'),
                                    "first_name" => $request->input('first_name'),
                                    "last_name" => $request->input('last_name'),
                                    "province" => $request->input('state'),
                                    "country" => $request->input('country'),
                                    "zip" => $request->input('postcode'),
                                    "name" => $request->input('first_name') . ' ' . $request->input('last_name'),
                                    "country_code" => Countries::getCode($request->input('country')),
                                    "province_code" => CountrySubdivisions::getCode($request->input('country'), $request->input('state'))
                                ],
                                "shipping_line" => [
                                    "custom" => true,
                                    "price" => $request->input('new_shipping_price'),
                                    "title" => $request->input('shipping_method')
                                ],

                            ]

                        ]
                ]);
            }
            else if(in_array($request->input('response'),[20,21])){

                $product = $this->helper->getShopify()->call([
                    'METHOD' => 'POST',
                    'URL' => '/admin/api/2019-10/products.json',
                    'DATA' => [
                        "product" => [
                            "title" =>   $default->name,
                            "variants" => [
                                [
                                    "price" =>  0,
                                ]
                            ]
                        ],
                    ]
                ]);

                $image = $this->helper->getShopify()->call([
                    'METHOD' => 'POST',
                    'URL' => '/admin/api/2019-10/products/' . $product->product->id . '/images.json',
                    'DATA' => [
                        'image' => [
                            'src' => 'https://cdn.shopify.com/s/files/1/0120/3106/6193/files/Screenshot_36.png'
                        ]
                    ]
                ]);


                $product_id = $product->product->variants[0]->id;
                $draft_orders = $this->helper->getShopify()->call([

                    'METHOD' => 'POST',
                    'URL' => '/admin/draft_orders.json',
                    'DATA' =>
                        [
                            "draft_order" => [
                                'line_items' => [
                                    [
                                        "variant_id" => $product_id,
                                        "quantity" => 1,
                                        "properties" => [
                                            [
                                                "name" => 'Response',
                                                "value" => $request->input('response'),
                                            ],
                                        ]
                                    ]
                                ],
                                "customer" => [
                                    "id" => $request->input('customer-id'),
                                ],
                                "billing_address" => [
                                    "address1" => $associate_order->has_billing->address1,
                                    "address2" =>  $associate_order->has_billing->address2,
                                    "city" =>  $associate_order->has_billing->city,
                                    "company" =>  $associate_order->has_billing->business,
                                    "first_name" =>  $associate_order->has_billing->first_name,
                                    "last_name" => $associate_order->has_billing->last_name,
                                    "province" =>  $associate_order->has_billing->state,
                                    "country" =>  $associate_order->has_billing->country,
                                    "zip" =>  $associate_order->has_billing->postcode,
                                    "name" => $associate_order->has_billing->first_name . ' ' .  $associate_order->has_billing->last_name,
                                    "country_code" => Countries::getCode( $associate_order->has_billing->country),
                                    "province_code" => CountrySubdivisions::getCode( $associate_order->has_billing->country,  $associate_order->has_billing->state)
                                ],
                                "shipping_address" => [
                                    "address1" => $request->input('address1'),
                                    "address2" => $request->input('address2'),
                                    "city" => $request->input('city'),
                                    "company" => $request->input('business'),
                                    "first_name" => $request->input('first_name'),
                                    "last_name" => $request->input('last_name'),
                                    "province" => $request->input('state'),
                                    "country" => $request->input('country'),
                                    "zip" => $request->input('postcode'),
                                    "name" => $request->input('first_name') . ' ' . $request->input('last_name'),
                                    "country_code" => Countries::getCode($request->input('country')),
                                    "province_code" => CountrySubdivisions::getCode($request->input('country'), $request->input('state'))
                                ],
                                "shipping_line" => [
                                    "custom" => true,
                                    "price" => $request->input('new_shipping_price'),
                                    "title" => $request->input('shipping_method')
                                ],

                            ]

                        ]
                ]);
            }
            else{
                $draft_orders = $this->helper->getShopify()->call([
                    'METHOD' => 'POST',
                    'URL' => '/admin/draft_orders.json',
                    'DATA' =>
                        [
                            "draft_order" => [
                                'line_items' => [
                                    [
                                        "variant_id" => $product_id,
                                        "price" => $default->price,
                                        "quantity" => 1,
                                        "properties" => [
                                            [
                                                "name" => 'Response',
                                                "value" => $request->input('response'),
                                            ],
                                        ]
                                    ]
                                ],
                                "customer" => [
                                    "id" => $request->input('customer-id'),
                                ],
                                "billing_address" => [
                                    "address1" => $associate_order->has_billing->address1,
                                    "address2" =>  $associate_order->has_billing->address2,
                                    "city" =>  $associate_order->has_billing->city,
                                    "company" =>  $associate_order->has_billing->business,
                                    "first_name" =>  $associate_order->has_billing->first_name,
                                    "last_name" => $associate_order->has_billing->last_name,
                                    "province" =>  $associate_order->has_billing->state,
                                    "country" =>  $associate_order->has_billing->country,
                                    "zip" =>  $associate_order->has_billing->postcode,
                                    "name" => $associate_order->has_billing->first_name . ' ' .  $associate_order->has_billing->last_name,
                                    "country_code" => Countries::getCode( $associate_order->has_billing->country),
                                    "province_code" => CountrySubdivisions::getCode( $associate_order->has_billing->country,  $associate_order->has_billing->state)
                                ],
                                "shipping_address" => [
                                    "address1" => $request->input('address1'),
                                    "address2" => $request->input('address2'),
                                    "city" => $request->input('city'),
                                    "company" => $request->input('business'),
                                    "first_name" => $request->input('first_name'),
                                    "last_name" => $request->input('last_name'),
                                    "province" => $request->input('state'),
                                    "country" => $request->input('country'),
                                    "zip" => $request->input('postcode'),
                                    "name" => $request->input('first_name') . ' ' . $request->input('last_name'),
                                    "country_code" => Countries::getCode($request->input('country')),
                                    "province_code" => CountrySubdivisions::getCode($request->input('country'), $request->input('state'))
                                ],
                            ]

                        ]
                ]);
            }

        } else {
            $default = PostDelayFee::where('default', 1)->where('type', 'request_form')->first();
            $product = $this->helper->getShopify()->call([
                'METHOD' => 'POST',
                'URL' => '/admin/api/2019-10/products.json',
                'DATA' => [
                    "product" => [
                        "title" => $default->name,
                        "variants" => [
                            [
                                "price" => $default->price,
                            ]
                        ]
                    ],
                ]
            ]);

            $image = $this->helper->getShopify()->call([
                'METHOD' => 'POST',
                'URL' => '/admin/api/2019-10/products/' . $product->product->id . '/images.json',
                'DATA' => [
                    'image' => [
                        'src' => 'https://cdn.shopify.com/s/files/1/0120/3106/6193/files/Screenshot_36.png'
                    ]
                ]
            ]);


            $product_id = $product->product->variants[0]->id;
            $draft_orders = $this->helper->getShopify()->call([
                'METHOD' => 'POST',
                'URL' => '/admin/draft_orders.json',
                'DATA' =>
                    [
                        "draft_order" => [
                            'line_items' => [
                                [
                                    "variant_id" => $product_id,
                                    "quantity" => 1,
                                ]
                            ],
                            "customer" => [
                                "id" => $request->input('customer-id'),
                            ],
                            "billing_address" => [
                                "address1" => $associate_order->has_billing->address1,
                                "address2" =>  $associate_order->has_billing->address2,
                                "city" =>  $associate_order->has_billing->city,
                                "company" =>  $associate_order->has_billing->business,
                                "first_name" =>  $associate_order->has_billing->first_name,
                                "last_name" => $associate_order->has_billing->last_name,
                                "province" =>  $associate_order->has_billing->state,
                                "country" =>  $associate_order->has_billing->country,
                                "zip" =>  $associate_order->has_billing->postcode,
                                "name" => $associate_order->has_billing->first_name . ' ' .  $associate_order->has_billing->last_name,
                                "country_code" => Countries::getCode( $associate_order->has_billing->country),
                                "province_code" => CountrySubdivisions::getCode( $associate_order->has_billing->country,  $associate_order->has_billing->state)
                            ],
                            "shipping_address" => [
                                "address1" => $request->input('address1'),
                                "address2" => $request->input('address2'),
                                "city" => $request->input('city'),
                                "company" => $request->input('business'),
                                "first_name" => $request->input('first_name'),
                                "last_name" => $request->input('last_name'),
                                "province" => $request->input('state'),
                                "country" => $request->input('country'),
                                "zip" => $request->input('postcode'),
                                "name" => $request->input('first_name') . ' ' . $request->input('last_name'),
                                "country_code" => Countries::getCode($request->input('country')),
                                "province_code" => CountrySubdivisions::getCode($request->input('country'), $request->input('state'))
                            ],
                            "shipping_line" => [
                                "custom" => true,
                                "price" => '0.00',
                                "title" => 'FREE SHIPPING - POSTDELAY'
                            ],

                        ]

                    ]
            ]);
        }

        $invoiceURL = $draft_orders->draft_order->invoice_url;
        $token = explode('/', $invoiceURL)[5];
        $order = new Order();
        $order->draft_order_id = $draft_orders->draft_order->id;
        $order->checkout_token = $token;
        $order->ship_out_date = $request->input('ship_out_date');
        $order->checkout_completed = 0;
        $order->order_id = $associate_order->id;
        $order->additional_payment = 1;
        if ($request->input('type') == 'additional-fee') {
            $order->additional_payment_name = 'Additional PostDelay Charges Payment';
        } else {
            $order->additional_payment_name = 'Request Form Payment';
        }

        $customer = Customer::where('shopify_customer_id', $request->input('customer-id'))->first();
        $order->customer_id = $customer->id;
        $order->shopify_customer_id = $request->input('customer-id');

        $recipient_address = new RecipientAddress();
        $recipient_address->address1 = $request->input('address1');
        $recipient_address->address2 = $request->input('address2');
        $recipient_address->city = $request->input('city');
        $recipient_address->business = $request->input('business');
        $recipient_address->first_name = $request->input('first_name');
        $recipient_address->last_name = $request->input('last_name');
        $recipient_address->state = $request->input('state');
        $recipient_address->country = $request->input('country');
        $recipient_address->postcode = $request->input('postecode');
        $recipient_address->save();
        $order->recipient_address_id = $recipient_address->id;
        /*Order Billing Address */
        $order->billing_address_id = $associate_order->billing_address_id;


        $order->save();
        return response()->json([
            "invoiceURL" => $invoiceURL,
        ]);
    }

    public function get_order_type(Request $request)
    {
        $type = Order::where('shopify_order_id', $request->input('shopify_order_id'))->value('additional_payment');
//     ad
        return response()->json([
            "type" => $type,
        ]);
    }

    public function set_key_dates(Request $request)
    {
//        dd($request);
//        KeyDate::UpdateOrcreate([
//            "order_id" => $request->input('order_id'),
//        ], [
//            "received_post_date" => $request->input('received_post_date'),
//            "completion_date" => $request->input('completion_date'),
//        ]);

        $keydate = KeyDate::where('order_id',$request->input('order_id'))->first();
        if($keydate == null){
            $keydate =  new KeyDate();
        }
        $keydate->order_id = $request->input('order_id');
        $keydate->received_post_date = $request->input('received_post_date');
        $keydate->completion_date = $request->input('completion_date');
        $keydate->save();
        return redirect()->back()->with('action','important-dates');
    }

    public function clear_received_post_date(Request $request)
    {
        $keydate = KeyDate::where('order_id',$request->input('order_id'))->first();
        $keydate->received_post_date = null;
        $keydate->save();
        return redirect()->back()->with('action','important-dates');
    }

    public function clear_completion_date(Request $request)
    {
        $keydate = KeyDate::where('order_id',$request->input('order_id'))->first();
        $keydate->completion_date = null;
        $keydate->save();
        return redirect()->back()->with('action','important-dates');
    }

    public function shipment_to_postdelay(Request $request)
    {
        Order::where('order_name', $request->input('order_name'))->update([
            'ship_to_postdelay_date' => $request->input('ship-date'),
            'ship_method' => $request->input('ship-method'),
            'tracking_id' => $request->input('tracking_id'),
            'status_id' => 2
        ]);

        $order = Order::where('order_name', $request->input('order_name'))->first();
        $this->status_log($order);

        $customer = Customer::find($order->customer_id);
//        Mail::to($customer->email)->send(new NotificationEmail($customer, $order));

        return response()->json([
            'status' => 'changed'
        ]);
    }

    /**
     * @param $order
     */
    public function status_log($order): void
    {
        $history = new OrderStatusHistory();
        $history->order_id = $order->id;
        $history->order_status_id = $order->status_id;
        $history->change_at = now();
        $history->setCreatedAt(now());
        $history->setUpdatedAt(now());
        $history->save();
    }

    public function download_pdf(Request $request)
    {
        $pdf = App::make('dompdf.wrapper');
        $order = Order::where('shopify_order_id', $request->input('order'))->first();
        $customer = Customer::find($order->customer_id);
        $pdf = $pdf->loadView('mailing_form', [
            "customer" => $customer,
            "order" =>$order
        ]);
        return $pdf->download('PostDelay_<'.$order->order_name.'>_Shipping_Label.pdf');
    }

    public function update_order_sender_details(Request $request)
    {
        SenderAddress::find($request->input('id'))->update($request->all());
        return redirect()->back()->with('action','sender');
    }

    public function update_tracking(Request $request)
    {
        $order = Order::find($request->input('id'));
        $order->outbound_tracking_id = $request->input('outbound_tracking_id');
        $order->save();
        return redirect()->back()->with('action','tracking');
    }

    public function update_order_recipient_details(Request $request)
    {
        RecipientAddress::find($request->input('id'))->update($request->all());
        return redirect()->back()->with('action','recipients');
    }

    public function order_update_billing_details(Request $request)
    {
        BillingAddress::find($request->input('id'))->update($request->all());
        return redirect()->back()->with('action','billing');
    }

    public function get_checkout()
    {
        $checkout = $this->helper->getShopify()->call([
            'METHOD' => 'POST',
            'URL' => '/admin/api/2019-10/checkouts.json',
            'DATA' =>
                [
                    "checkout" => [
                        'line_items' => [
                            [

                                "variant_id" => 30931674529873,
                                "quantity" => 1,


                            ]
                        ],

                    ]

                ]
        ]);

        dd($checkout);
    }

    public function cancel_order(Request $request)
    {
        $order = Order::where('token', $request->input('order_token'))->first();
        $settings = Settings::all()->first();
        if (strtotime(now()) > strtotime(Carbon::parse($order->ship_out_date)->addDays($settings->min_threshold_in_cancellation)))
        {
            return response()->json([
                'status' => 'error',
                'message' => ' Your order cannot be cancelled because the ship-out date is in fewer than ' . $settings->min_threshold_in_cancellation . ' days'
            ]);
        }
        else {
            if ($order->ship_to_postdelay_date != null) {
                return $this->cancelled_with_processing($order);
            }
            else {
                if ($order->has_key_dates != null) {
                    if ($order->has_key_dates->received_post_date != null) {
                        return $this->cancelled_with_processing($order);
                    } else {
                        return response()->json([
                            'status' => 'permission',
                            'message_status' => '6'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 'permission',
                        'message_status' => '6'
                    ]);

                }
            }
        }
    }


    public function delete_order(Request $request)
    {
        $order = Order::find($request->input('id'));
        $this->helper->getShopify()->call([
            'METHOD' => 'DELETE',
            'URL' => 'admin/orders/' . $order->shopify_order_id . '.json',
        ]);
        $order->delete();
        return redirect()->back();
    }

    public function showEmail()
    {
        return view('email_template');
    }

    public function get_shipping_rates(Request $request)
    {

        $post_type = PostType::where('name', $request->input('post_type'))->first();
        $weight = $request->input('weight');
        $default = PostDelayFee::where('default', 1)->where('type', 'primary')->first();
        $product = $this->helper->getShopify()->call([
            'METHOD' => 'POST',
            'URL' => '/admin/api/2019-10/products.json',
            'DATA' => [
                "product" => [
                    "title" => 'Post Delay Fee',
                    "requires_shipping" => true,
                    "variants" => [
                        [
                            "price" => $default->price,
                            "grams" => $weight
                        ]
                    ]
                ],
            ]
        ]);

        $image = $this->helper->getShopify()->call([
            'METHOD' => 'POST',
            'URL' => '/admin/api/2019-10/products/' . $product->product->id . '/images.json',
            'DATA' => [
                'image' => [
                    'src' => 'https://cdn.shopify.com/s/files/1/0120/3106/6193/files/Screenshot_36.png'
                ]
            ]
        ]);


        $product_id = $product->product->variants[0]->id;
        echo $product_id;
    }
    public function response_from_user(Request $request)
    {
        $order = Order::where('shopify_order_id', $request->input('order-id'))->first();

        $response = new OrderResponse();
        $response->order_id = $order->id;
        $response->status_id = $order->status_id;
        $response->response = $request->input('response');
        $response->save();


        if (in_array($request->input('response'), [20, 21])) {

            return Redirect::to('https://postdelay.myshopify.com/account?view=additional-fee&&order-id=' . $order->shopify_order_id . '&&response=' . $response->response);
        }
        else if (in_array($request->input('response'), [16, 17])) {
            $shop = Shop::where('shopify_domain', 'postdelay.myshopify.com')->first();
            $price = 0;
            if($request->input('response') == 16){
                $price = $order->additional_cost_to_ship;
            }
            else{
                $price = $order->additional_cost_to_return;
            }
            $associate_order = $order;
            $product = $this->helper->getShopify()->call([
                'METHOD' => 'POST',
                'URL' => '/admin/api/2019-10/products.json',
                'DATA' => [
                    "product" => [
                        "title" => 'PostDelay Additional Fee',

                        "variants" => [
                            [
                                "price" => $price,
                                "requires_shipping" => false,
                            ]
                        ]
                    ],
                ]
            ]);
            $image = $this->helper->getShopify()->call([
                'METHOD' => 'POST',
                'URL' => '/admin/api/2019-10/products/' . $product->product->id . '/images.json',
                'DATA' => [
                    'image' => [
                        'src' => 'https://cdn.shopify.com/s/files/1/0120/3106/6193/files/Screenshot_36.png'
                    ]
                ]
            ]);
            $product_id = $product->product->variants[0]->id;

            $draft_orders = $this->helper->getShopify()->call([
                'METHOD' => 'POST',
                'URL' => '/admin/draft_orders.json',
                'DATA' =>
                    [
                        "draft_order" => [
                            'line_items' => [
                                [
                                    "variant_id" => $product_id,
                                    "quantity" => 1,
                                    "properties" => [
                                        [
                                            "name" => 'Response',
                                            "value" => $request->input('response'),
                                        ],
                                    ]
                                ]
                            ],
                            "customer" => [
                                "id" => $order->has_customer->shopify_customer_id,
                            ],
                            "billing_address" => [
                                "address1" => $order->has_billing->address1,
                                "address2" =>  $order->has_billing->address2,
                                "city" =>  $order->has_billing->city,
                                "company" =>  $order->has_billing->business,
                                "first_name" =>  $order->has_billing->first_name,
                                "last_name" => $order->has_billing->last_name,
                                "province" =>  $order->has_billing->state,
                                "country" =>  $order->has_billing->country,
                                "zip" =>  $order->has_billing->postcode,
                                "name" => $order->has_billing->first_name . ' ' .  $order->has_billing->last_name,
                                "country_code" => Countries::getCode( $order->has_billing->country),
                                "province_code" => CountrySubdivisions::getCode( $order->has_billing->country,  $order->has_billing->state)
                            ],
                        ]

                    ]
            ]);
            $invoiceURL = $draft_orders->draft_order->invoice_url;
            $token = explode('/', $invoiceURL)[5];
            $order = new Order();
            $order->draft_order_id = $draft_orders->draft_order->id;
            $order->checkout_token = $token;
            $order->checkout_completed = 0;
            $order->order_id = $associate_order->id;
            $order->additional_payment = 1;

            $order->additional_payment_name = 'Additional PostDelay Charges Payment';


            $customer = Customer::where('shopify_customer_id', $associate_order->has_customer->shopify_customer_id)->first();
            $order->customer_id = $customer->id;
            $order->shopify_customer_id = $associate_order->has_customer->shopify_customer_id;
            $order->billing_address_id = $associate_order->billing_address_id;
            $order->save();
            return Redirect::to($invoiceURL);

        }
        else if(in_array($request->input('response'),[8,9])){
            if($request->input('response') == 8){
                if($order->payment_gateway != "Cash on Delivery (COD)") {
                    $cancelledd_refund = $this->helper->getShopify()->call([
                        'METHOD' => 'POST',
                        'URL' => '/admin/api/2019-10/orders/' . $order->shopify_order_id . '/cancel.json',
                        'DATA' => [
                            "amount" => $order->shipping_method_price,
                            "currency" => 'USD'
                        ]
                    ]);
                }
                else{
                    $cancelledd_refund = $this->helper->getShopify()->call([
                        'METHOD' => 'POST',
                        'URL' => '/admin/api/2019-10/orders/' . $order->shopify_order_id . '/cancel.json',
                    ]);
                }
                $order->status_id = 8;
                $order->save();
                $this->status_log($order);
                $customer = Customer::find($order->customer_id);
                Mail::to($customer->email)->send(new NotificationEmail($customer, $order));
                if(in_array($order->status_id,[8])){
                    Mail::to('admin@postdelay.com')->send(new AfterCancellationItemDisposed($customer, $order));
                }
                return Redirect::to('https://postdelay.myshopify.com/account/orders/' . $order->token);

            }
            else{
                $order->status_id = 14;
                $order->save();
                $this->status_log($order);
                $customer = Customer::find($order->customer_id);

                if(in_array($order->status_id,[14])){
                    Mail::to('admin@postdelay.com')->send(new CheckCostOrRefund($customer, $order));
                }

                return Redirect::to('https://postdelay.myshopify.com/account/orders/' . $order->token);

//                return Redirect::to('https://postdelay.myshopify.com/account?view=additional-fee&&order-id=' . $order->shopify_order_id . '&&response=' . $response->response);
            }
        }
        else {
            $order->status_id = $request->input('response');
            $order->save();
            $this->status_log($order);
            $customer = Customer::find($order->customer_id);
            if($order->status_id != '3'){
                Mail::to($customer->email)->send(new NotificationEmail($customer, $order));
            }
            else{
                if(in_array($order->status_id,[3,16,20])){
                    $date = new DateTime($order->ship_out_date);
                    $now = new DateTime();
                    if($date < $now) {
                        Mail::to('admin@postdelay.com')->send(new OrderMailOutLate($customer, $order));
                    }
                }
            }

            if(in_array($order->status_id,[18])){
                Mail::to('admin@postdelay.com')->send(new DisposeOrderAfterPriceIncrease($customer, $order));
            }
            if(in_array($order->status_id,[22])){
                Mail::to('admin@postdelay.com')->send(new DisposeOrderAfterUndeliverable($customer, $order));
            }

            $res = OrderResponse::where('order_id', $order->id)
                ->where('response', $request->input('response'))->where('fulfill', 0)->first();
            $res->fulfill = 1;
            $res->save();
            return Redirect::to('https://postdelay.myshopify.com/account/orders/' . $order->token);

        }

    }
    public function testusps(Request $request)
    {
        $rate = new Rate($this->api);
        $location = Location::all()->first();
        if($location != null){
            $origin_zip_code = $location->postcode;
        }
        else{
            $origin_zip_code = 10008;
        }

        $fee = PostDelayFee::where('type','primary')->where('default',1)->first();
        if($fee != null){
            $origin_fee = $fee->price;
        }
        else{
            $origin_fee = 200;
        }

        if($request->input('unit_of_measures_weight') == 'Metric'){
            if($request->input('width')!= null){
                $width = $request->input('width');
            } else{
                $width = 10;
            }
            if($request->input('length')!= null){
                $length = $request->input('length');
            } else{
                $length = 15;
            }
            if($request->input('height')!= null){
                $height = $request->input('height');
            } else{
                $height = 10;
            }
            if($request->input('girth')!= null){
                $girth = $request->input('girth');
            } else{
                $girth = 0;
            }
        }
        else{
            if($request->input('width')!= null){
                $width = $request->input('width')/2.54;
            } else{
                $width = 10;
            }
            if($request->input('length')!= null){
                $length = $request->input('length')/2.54;
            } else{
                $length = 15;
            }
            if($request->input('height')!= null){
                $height = $request->input('height')/2.54;
            } else{
                $height = 10;
            }
            if($request->input('girth')!= null){
                $girth = $request->input('girth')/2.54;
            } else{
                $girth = 0;
            }
        }


        if($request->input('pounds') != null){
            $weight_in_pounds =number_format($request->input('pounds'),2);
            $weight_in_ounches = number_format($request->input('ounches'),2);
        } else{
            $weight_in_ounches = 0;
            $weight_in_pounds  =0.21345678;
        }

        if($request->input('receipent_country') != 'United States'){

            $rate->setInternationalCall(true);
            $rate->addExtraOption('Revision', 2);
            $package = new RatePackage;
            $package->setPounds($weight_in_pounds);
            $package->setOunces($weight_in_ounches);
            $package->setField('Machinable', 'false');
            if($request->input('post_type') != 'POSTCARD' ){
                if($request->input('post_type') == 'POSTCARD' ){
                    $package->setField('MailType','POSTCARDS');
                }
                else if($request->input('post_type') == 'ENVELOPE'){
                    $package->setField('MailType', 'ENVELOPE');
                }
                else if($request->input('post_type') == 'ENVELOPE'){
                    $package->setField('MailType', 'LARGEENVELOPE');
                }
                else if($request->input('post_type') == 'LETTER'){
                    $package->setField('MailType', 'LETTER');
                }
                else{
                    $package->setField('MailType', 'PACKAGE');
                }
                if($request->input('special_holding') == 'yes'){
                    $package->setField('GXG', array(
                        'POBoxFlag' => 'Y',
                        'GiftFlag' => 'Y'
                    ));
                }
                $package->setField('ValueOfContents', $origin_fee);
                $package->setField('Country', $request->input('receipent_country'));
                if($request->input('post_type') == 'PACKAGE' || $request->input('post_type') == 'LARGE PACKAGE'){
                    if($request->input('shape') == 'Rectangular'){
                        $package->setField('Container', RatePackage::CONTAINER_RECTANGULAR);
                    }
                    else{
                        $package->setField('Container', RatePackage::CONTAINER_NONRECTANGULAR);
                    }
                }
                else if($request->input('post_type') == 'ENVELOPE'){
                    $package->setField('Container', RatePackage::CONTAINER_FLAT_RATE_ENVELOPE);
                }
                else if($request->input('post_type') == 'LARGE ENVELOPE'){
                    $package->setField('Container', RatePackage::CONTAINER_VARIABLE);
                }
                else if($request->input('post_type') == 'POSTCARD'){
                    $package->setField('Container', RatePackage::CONTAINER_VARIABLE);
                }
                else{
                    $package->setField('Container', RatePackage::CONTAINER_VARIABLE);
                }
                if($request->input('post_type') == 'PACKAGE' || $request->input('post_type') == 'LARGE PACKAGE'){
                    $package->setField('Width', $width);
                    $package->setField('Length', $length);
                    $package->setField('Height', $height);
                    $package->setField('Girth', $girth);
                }
                $package->setField('OriginZip', $origin_zip_code);
                $date =now()->addDays(7)->format('Y-m-d\TH:i:s');
                $date = $date . '-06:00';
//            '2020-01-01T13:15:00-06:00'
                $package->setField('AcceptanceDateTime',$date );
                $package->setField('DestinationPostalCode', $request->input('receipent_postecode'));

                $rate->addPackage($package);

                $rate->getRate();
                $rates = $rate->getArrayResponse();
                if ($rate->isSuccess()) {
                    $services = $rates['IntlRateV2Response']['Package']['Service'];
                    $error = null;

                } else {
                    $services = null;
                    $error = $rate->getErrorMessage();
                }
                return response()->json([
                    'services' => $services,
                    'error' => $error,
                    'status' => 'international'
                ]);
            }
            else{
                $services = [];
                array_push($services,[
                    'Postage' => '1.20',
                    'SvcDescription' =>  'First-Class Mail® International Postcard',
                    'SvcCommitments' => ''
                ]);
                $error = null;
                return response()->json([
                    'services' => $services,
                    'error' => $error,
                    'status' => 'international'
                ]);
            }


        }
        else{

            $package = new RatePackage();
            $services = [];
            if($request->input('post_type') == 'POSTCARD'){
                if($request->input('postcard_size') == 'regular'){
                    $size = 'REGULAR';
                    $s = $this->DomesticPostcardShipping($origin_zip_code,$request->input('receipent_postecode'),0,0.12,'POSTCARDS',RatePackage::SERVICE_FIRST_CLASS,RatePackage::MAIL_TYPE_POSTCARD,$size);
                    $services = $s['Package']['Postage'];
                }
                else{
                    $size = 'LARGE';
                    array_push($services,[
                        'Rate' => 0.55,
                        'MailService' => 'First-Class Mail® Stamped Large Postcards',
                    ]);
                }


            }

            else if($request->input('post_type') == 'LARGE ENVELOPE'){
                $envelopes = [
                    RatePackage::CONTAINER_FLAT_RATE_ENVELOPE,
                    RatePackage::CONTAINER_GIFT_CARD_FLAT_RATE_ENVELOPE,
                    RatePackage::CONTAINER_SM_FLAT_RATE_ENVELOPE,
                    RatePackage::CONTAINER_LEGAL_FLAT_RATE_ENVELOPE,
                    RatePackage::CONTAINER_PADDED_FLAT_RATE_ENVELOPE,
                    RatePackage::CONTAINER_WINDOW_FLAT_RATE_ENVELOPE,
                ];
                $usps_services = [
                    RatePackage::SERVICE_PRIORITY,
                    RatePackage::SERVICE_EXPRESS,
                ];

                $services = [];
                foreach ($usps_services as $usps){
                    foreach ($envelopes as $en){
                        $temp =  [];
                        $s =  $this->DomesticShipping($origin_zip_code,$request->input('receipent_postecode'),$weight_in_pounds,$weight_in_ounches,$en,$usps,'','','','','','False');
                        if(!array_key_exists('Error',$s['Package'])){
                            array_push($temp,$s['Package']['Postage']);
                            array_push($services,$temp[0]);
                        }

                    }
                }

            }
            else if($request->input('post_type') == 'LETTER'){
                $services = [];
                if($request->input('special_holding') == 'yes'){
                    $machine = 'True';
                }
                else{
                    $machine = 'False';
                }
                if($weight_in_pounds < 1){
                    if($machine == 'False'){
                        $machine = 'True';
                    }
                    else{
                        $machine = 'False';
                    }
                    $s =  $this->DomesticShipping($origin_zip_code,$request->input('receipent_postecode'),0,0.12,'',RatePackage::SERVICE_FIRST_CLASS,RatePackage::MAIL_TYPE_LETTER,'','','','',$machine);
                    array_push($services,$s['Package']['Postage']);
                }

                $envelopes = [
                    RatePackage::CONTAINER_FLAT_RATE_ENVELOPE,
                    RatePackage::CONTAINER_GIFT_CARD_FLAT_RATE_ENVELOPE,
                    RatePackage::CONTAINER_SM_FLAT_RATE_ENVELOPE,
                    RatePackage::CONTAINER_LEGAL_FLAT_RATE_ENVELOPE,
                    RatePackage::CONTAINER_PADDED_FLAT_RATE_ENVELOPE,
                    RatePackage::CONTAINER_WINDOW_FLAT_RATE_ENVELOPE,
                ];
                $usps_services = [
                    RatePackage::SERVICE_PRIORITY,
//                    RatePackage::SERVICE_EXPRESS,
                ];
                foreach ($usps_services as $usps){
                    foreach ($envelopes as $en){
                        $temp =  [];
                        $s =  $this->DomesticShipping($origin_zip_code,$request->input('receipent_postecode'),$weight_in_pounds,$weight_in_ounches,$en,$usps,'','','','','',$machine);
                        if(!array_key_exists('Error',$s['Package'])){
                            array_push($temp,$s['Package']['Postage']);
                            array_push($services,$temp[0]);
                        }

                    }
                }
            }
            else if($request->input('post_type') == 'PACKAGE'){
                $envelopes = [
                    RatePackage::CONTAINER_LG_FLAT_RATE_BOX,
                    RatePackage::CONTAINER_MD_FLAT_RATE_BOX,
                    RatePackage::CONTAINER_SM_FLAT_RATE_BOX,
                    RatePackage::CONTAINER_RECTANGULAR,

                ];
                $usps_services = [
                    RatePackage::SERVICE_PRIORITY,
                    RatePackage::SERVICE_EXPRESS,
                ];

                $services = [];
                foreach ($usps_services as $usps){
                    foreach ($envelopes as $en){
                        $temp =  [];
                        $s =  $this->DomesticShipping($origin_zip_code,$request->input('receipent_postecode'),$weight_in_pounds,$weight_in_ounches,$en,$usps,'','','','','','False');
                        if(!array_key_exists('Error',$s['Package'])){
                            array_push($temp,$s['Package']['Postage']);
                            array_push($services,$temp[0]);
                        }

                    }
                }

            }
            else{
                if($request->input('shape') == 'Rectangular'){
                    $envelopes = [
                        RatePackage::CONTAINER_RECTANGULAR,
                    ];
                }
                else{
                    $envelopes = [
                        RatePackage::CONTAINER_NONRECTANGULAR,
                    ];
                }

                $usps_services = [
                    RatePackage::SERVICE_PRIORITY,
                    RatePackage::SERVICE_PRIORITY_HFP_COMMERCIAL,
                    RatePackage::SERVICE_EXPRESS,
                    RatePackage::SERVICE_EXPRESS_HFP_COMMERCIAL,
                    RatePackage::SERVICE_MEDIA,

                ];

                $services = [];
                foreach ($usps_services as $usps){
                    foreach ($envelopes as $en){
                        $temp =  [];
                        $s =  $this->DomesticShipping($origin_zip_code,$request->input('receipent_postecode'),$weight_in_pounds,$weight_in_ounches,$en,$usps,'',$width,$length,$height,$girth,'False');
                        if(!array_key_exists('Error',$s['Package'])){
                            array_push($temp,$s['Package']['Postage']);
                            array_push($services,$temp[0]);
                        }

                    }
                }
            }

            return response()->json([
                'services' => $services,
                'error' => null,
                'status' => 'domestic'
            ]);

        }

    }
    public function USPS_PostCard($request, $origin_zip_code, $weight_in_ounches, $weight_in_pounds){
        $all_services = [];
        $all_errors = [];

        $all_packages = [
            RatePackage::SERVICE_FIRST_CLASS,
            RatePackage::SERVICE_PRIORITY,
        ];

        $rate = new Rate($this->api);
        foreach ($all_packages as $a) {
            $package = new RatePackage();
            $package->setService($a);
            $package->setFirstClassMailType(RatePackage::MAIL_TYPE_POSTCARD);
            $weight_in_ounches = 0;
            $weight_in_pounds = 0.21875;
            $package->setZipOrigination($origin_zip_code);
            $package->setZipDestination($request->input('receipent_postecode'));
            $package->setPounds($weight_in_pounds);
            $package->setOunces($weight_in_ounches);
            $package->setField('Container', RatePackage::CONTAINER_VARIABLE);
            $package->setField('Machinable', false);
            $rate->addPackage($package);

        }
        $rate->getRate();
        $rates = $rate->getArrayResponse();
        if ($rate->isSuccess()) {
            array_push($all_services, $rates['RateV4Response']['Package']['Postage']);
            array_push($all_errors, []);
        } else {
            array_push($all_errors, $rate->getErrorMessage());
            array_push($all_services, []);
        }
        dd($all_services, $all_errors);
    }
    public function USPS_Envolope($request, $origin_zip_code, $weight_in_ounches, $weight_in_pounds){
        $all_services = [];
        $all_errors = [];

        $all_packages = [
            RatePackage::SERVICE_FIRST_CLASS,
            RatePackage::SERVICE_PRIORITY,
            RatePackage::SERVICE_EXPRESS,
            RatePackage::SERVICE_EXPRESS_HFP
        ];

//        foreach ($all_packages as $a) {
        $rate = new Rate($this->api);
        $package = new RatePackage();
        $package->setService(RatePackage::SERVICE_ALL);
//            $package->setFirstClassMailType(RatePackage::MAIL_TYPE_FLAT);
        $package->setZipOrigination($origin_zip_code);
        $package->setZipDestination($request->input('receipent_postecode'));
        $package->setPounds($weight_in_pounds);
        $package->setOunces($weight_in_ounches);
        $package->setField('Container', RatePackage::CONTAINER_VARIABLE);
        $package->setField('Machinable', false);
        $rate->addPackage($package);
        $rate->getRate();
        $rates = $rate->getArrayResponse();
        if ($rate->isSuccess()) {
            array_push($all_services, $rates['RateV4Response']['Package']['Postage']);
            array_push($all_errors, []);
        } else {
            array_push($all_errors, $rate->getErrorMessage());
            array_push($all_services, []);
        }
//        }
        dd($all_services, $all_errors);
    }

    public function DomesticShipping($zipOrigin,$zipDestination,$pounds,$ounches,$container,$service,$firstclassmailtype,$width,$length,$height,$girth,$machinable = null){
        $xml_data = '<RateV4Request USERID="'.$this->api.'">'.
            '<Revision>2</Revision>'.
            '<Package ID="1ST">'.
            '<Service>'.$service.'</Service>'.
            '<FirstClassMailType>'.$firstclassmailtype.'</FirstClassMailType>'.
            '<ZipOrigination>'.$zipOrigin.'</ZipOrigination>'.
            '<ZipDestination>'.$zipDestination.'</ZipDestination>'.
            '<Pounds>'.$pounds.'</Pounds>'.
            '<Ounces>'.$ounches.'</Ounces>'.
            '<Container>'.$container.'</Container>'.
            '<Width>'.$width.'</Width>'.
            '<Length>'.$length.'</Length>'.
            '<Height>'.$height.'</Height>'.
            '<Girth>'.$girth.'</Girth>'.
            '<Machinable>'.$machinable.'</Machinable>'.
            '</Package>'.
            '</RateV4Request>';

        $url = "https://Secure.ShippingAPIs.com/ShippingAPI.dll";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $data = "API=RateV4&XML=".$xml_data;
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $result=curl_exec ($ch);

        if (curl_errno($ch)){
            dd(curl_error($ch));
            curl_close($ch);
        }
        else{
            curl_close($ch);
//            dd($result);
            $data = strstr($result, '<?');
            $xml = simplexml_load_string($data);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
//            dd($array);
            return $array;
        }
    }
    public function DomesticPostcardShipping($zipOrigin,$zipDestination,$pounds,$ounches,$container,$service,$firstclassmailtype,$size){
        $xml_data = '<RateV4Request USERID="'.$this->api.'">'.
            '<Revision>2</Revision>'.
            '<Package ID="1ST">'.
            '<Service>'.$service.'</Service>'.
            '<FirstClassMailType>'.$firstclassmailtype.'</FirstClassMailType>'.
            '<ZipOrigination>'.$zipOrigin.'</ZipOrigination>'.
            '<ZipDestination>'.$zipDestination.'</ZipDestination>'.
            '<Pounds>'.$pounds.'</Pounds>'.
            '<Ounces>'.$ounches.'</Ounces>'.
            '<Container>'.$container.'</Container>'.
            '<Size>'.$size.'</Size>'.
            '<Machinable>false</Machinable>'.
            '</Package>'.
            '</RateV4Request>';

        $url = "https://Secure.ShippingAPIs.com/ShippingAPI.dll";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $data = "API=RateV4&XML=".$xml_data;
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $result=curl_exec ($ch);

        if (curl_errno($ch)){
            dd(curl_error($ch));
            curl_close($ch);
        }
        else{
            curl_close($ch);
//            dd($result);
            $data = strstr($result, '<?');
            $xml = simplexml_load_string($data);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
//            dd($array);
            return $array;
        }
    }

    public function get_re_calculate_form(Request $request){
        $sender  = $request->all();
        $types = PostType::all();
        $associate_order = Order::where('shopify_order_id', $request->input('order-id'))->first();
        $returnHTML = view('inc.re-calculate-form', [
            'sender' => $sender,
            'order' => $associate_order,
            'types' => $types
        ])->render();
        return response()->json([
            'message' => 'success',
            'html' => $returnHTML
        ]);

    }

    public function update_modify_date(Request $request){
        $order = Order::find($request->input('order_id'));
        if($order != null){
            $order_log = new OrderLog();
            $order_log->order_id = $order->id;
            $order_log->modification_date = now();
            $order_log->previous_date = $order->ship_out_date;
            $order_log->new_date = $request->input('ship_out_date');
            $order_log->save();
            $order->ship_out_date = $request->input('ship_out_date');
            $order->save();
            if($request->ajax()){
                return response()->json([
                    'message' => 'success'
                ]);
            }
            else{
                return redirect()->back()->with('action','modify-ship-out-date');
            }

        }
        else{
            if($request->ajax()){
                return response()->json([
                    'message' => 'error'
                ]);
            }
            else{
                return redirect()->back();
            }
        }
    }
    public function update_order_extra_charges(Request $request){
        $order = Order::find($request->input('id'));
        if($order != null){
            $order->additional_cost_to_ship = $request->input('additional_cost_to_ship');
            $order->additional_cost_to_return = $request->input('additional_cost_to_return');
            $order->save();
            return \redirect()->back()->with('action','update-additional-charges');
        }
        else{
            return \redirect()->back();
        }
    }

    /**
     * @param $order
     * @return mixed
     */
    public function cancel_and_refund($order)
    {
        try{
            if($order->payment_gateway != "Cash on Delivery (COD)"){
                $cancelledd_refund = $this->helper->getShopify()->call([
                    'METHOD' => 'POST',
                    'URL' => '/admin/api/2019-10/orders/' . $order->shopify_order_id . '/cancel.json',
                    'DATA' => [
                        "amount" => $order->order_total,
                        "currency" => 'USD'
                    ]
                ]);
            }
            else{
                $cancelledd_refund = $this->helper->getShopify()->call([
                    'METHOD' => 'POST',
                    'URL' => '/admin/api/2019-10/orders/' . $order->shopify_order_id . '/cancel.json',
                ]);
            }
        }
        catch (\Exception $e){

        }


        $order->status_id = 6;
        $order->save();
        $this->status_log($order);
        $customer = Customer::find($order->customer_id);
        Mail::to('admin@postdelay.com')->send(new FullManualRefund($customer, $order));
        Mail::to($customer->email)->send(new NotificationEmail($customer, $order));
        return $customer;
    }

    /**
     * @param $order
     * @return mixed
     */
    public function cancelled_with_processing($order)
    {
        if (in_array($order->status_id, [8, 9, 11, 12, 13, 17, 18, 21, 22, 23, 24])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Your mailing cannot be cancelled; check your order status for more information or contact customerservice@postdelay.com '
            ]);
        } else {
            if (in_array($order->status_id, [7, 15, 19])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your mailing cannot be cancelled because we are waiting for information from you. Check the ‘Attention Needed for Further Processing’ section in ‘Order Details’'
                ]);
            } else {
                return response()->json([
                    'status' => 'permission',
                    'message_status' => '7'
                ]);
            }
        }
    }


    public function update_modify_date_ajax(Request $request){
        $order = Order::find($request->input('order_id'));
        if($order != null){
            $order_log = new OrderLog();
            $order_log->order_id = $order->id;
            $order_log->modification_date = now();
            $order_log->previous_date = $order->ship_out_date;
            $order_log->new_date = $request->input('ship_out_date');
            $order_log->save();
            $order->ship_out_date = $request->input('ship_out_date');
            $order->save();
            return response()->json([
                'message' => 'success'
            ]);
        }
        else{
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    /**
     * @param $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function order_cancellation_with_status_seven($order): \Illuminate\Http\JsonResponse
    {
        $order->status_id = 7;
        $order->save();
        $this->status_log($order);
        $customer = Customer::find($order->customer_id);
        Mail::to($customer->email)->send(new NotificationEmail($customer, $order));
        return response()->json([
            'status' => 'success',
            'message' => 'Your order will be cancelled. Check the ‘Attention Needed for Further Processing’ section in order details',
            'response' => 7
        ]);
    }

    public function set_status_cancellation(Request $request){
        $order = Order::where('token', $request->input('order_token'))->first();
        if($order != null){
            if($request->input('permission') == '6'){
                $this->cancel_and_refund($order);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Your mailing has been cancelled and refunded.',
                    'response' => 6
                ]);
            }
            else{
                return $this->order_cancellation_with_status_seven($order);
            }
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Internal Server Error'
            ]);
        }
    }

    public function seedData(){

        $settings = Settings::all()->first();
        $settings->usps_username = '021POSTD3725';
        $settings->status_7_option_1 = 'Return my mailing to me.';
        $settings->status_7_option_2 = 'Dispose of my mailing.';
        $settings->status_7_option_3 = 'Uncancel the order';
        $settings->status_15_option_1 = 'Pay additional cost to continue shipment.';
        $settings->status_15_option_2 = 'Return item to me.';
        $settings->status_15_option_3 = 'Dispose of item. - $0.00';
        $settings->status_19_option_1 = 'Charge Extra and Re-attempt Delivery Process';
        $settings->status_19_option_2 = 'Charge Extra and Return my shipment';
        $settings->status_19_option_3 = 'Dispose my shipment';

        $settings->verify_shipping_cost_threshold = '7';
        $settings->wait_for_response_for_status_7 = '7';
        $settings->wait_for_response_for_status_15 = '7';
        $settings->wait_for_response_for_status_19 = '7';
        $settings->wait_for_response_for_status_10 = '7';


        $settings->save();

    }

    public function test_emails(){
//        $order = Order::find(141);
//        $customer = Customer::find($order->customer_id);
//
//
//        Mail::to($customer->email)->send(new AfterCancellationReturnPaymentReceived($customer, $order));

//        $response  = $this->helper->getShopify()->call([
//            'METHOD' => 'GET',
//            'URL' => '/admin/draft_orders/596690501713.json',
//        ]);
//        Mail::to('djtauros789@gmail.com')->send(new DraftOrderComplete($response->draft_order));


    }

}

