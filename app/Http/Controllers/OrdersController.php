<?php

namespace App\Http\Controllers;

use App\Address;
use App\BillingAddress;
use App\Customer;
use App\KeyDate;
use App\Mail\NotificationEmail;
use App\Order;
use App\OrderStatusHistory;
use App\PackageDetail;
use App\PostDelayFee;
use App\PostType;
use App\RecipientAddress;
use App\Scale;
use App\SenderAddress;
use App\Shape;
use App\Shop;
use App\Status;
use Barryvdh\DomPDF\PDF;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new HelperController();
    }

    public function index(){
        $orders=Order::where('checkout_completed',1)
            ->where('additional_payment',0)->orderBy('order_name', 'DESC')->get();
        $status=Status::all();
        return view('orders.index',compact('orders','status'));
    }

    public function place_order(Request $request){
        $line_items = [];
        $default =  PostDelayFee::where('default',1)->where('type','primary')->first();
        if($request->input('weight') == null){
            $post_type = PostType::where('name',$request->input('post_type'))->first();
            if($post_type != null){
                if($post_type->weight == null){
                    $weight = 1000;
                }else{
                    $weight = $post_type->weight;
                }

            }
            else{
                $weight = 1000;
            }
        }
        else{
            $weight = $request->input('weight');
        }

        array_push($line_items, [
            "title"=> 'Postdelay Fee',
            "price"=> $request->input('new_postdelay_fee'),
            "quantity"=> 1,
            "requires_shipping" => true,
            "grams" =>$weight,
        ]);

        $draft_orders = $this->helper->getShop('postdelay.myshopify.com')->call([
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
                        ],
                        "shipping_line" => [
                            "custom" => true,
                            "price" => $request->input('new_shipping_price'),
                            "title" => $request->input('shipping_method')
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
        $package_detail->weight = $weight;
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
        $billing_address->email =   $request->input('billing_phone');
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
//        dd($orders);
        foreach ($orders as $index => $order){
            $checkout_token =  explode('/',$order->landing_site)[3];
            $draft_order = Order::where('checkout_token',$checkout_token)
                ->where('checkout_completed',0)->first();
            if($draft_order != NULL){

                $draft_order->checkout_completed = 1;
                $draft_order->shopify_order_id = $order->id;
                $draft_order->order_name = $order->name;
                $draft_order->order_total = $order->total_price;
                $draft_order->payment_gateway = $order->gateway;
                $draft_order->items = json_encode($order->line_items);
                if(count($order->shipping_lines) > 0){
                    $draft_order->shipping_method_title = $order->shipping_lines[0]->title;
                    $draft_order->shipping_method_id = $order->shipping_lines[0]->id;
                    $draft_order->shipping_method_price = $order->shipping_lines[0]->price;
                    $draft_order->shipping_method_source = $order->shipping_lines[0]->source;

                }
                $draft_order->status_id =1;
                $draft_order->token = $order->token;

                if($order->billing_address != null){
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
                if(isset($order->shipping_address)){
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

                $draft_order->save();

                $old_history = OrderStatusHistory::where('order_id',$draft_order->id)->first();
                if($old_history ==  null){
                    $history = new OrderStatusHistory();
                    $history->order_id = $draft_order->id;
                    $history->order_status_id =  $draft_order->status_id;
                    $history->change_at = now();
                    $history->setCreatedAt(now());
                    $history->setUpdatedAt(now());
                    $history->save();
                }

//                $customer = Customer::find($draft_order->customer_id);
//                Mail::to($customer->email)->send(new NotificationEmail($customer,$draft_order));
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
        $fee =  PostDelayFee::where('default',1)->where('type','primary')->first();
        $returnHTML = view('customers.new_order', [
            'customer_id' =>$request->input('customer_id'),
            'addresses' => $customer_addresses,
            'billing_address' => null,
            'sender_address' => null,
            'recipient_address' => null,
            'shapes'=>$shapes,
            'types' => $types,
            'scales'=>$scales,
            'fee' => $fee
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
        $fee =  PostDelayFee::where('default',1)->where('type','primary')->first();
        $returnHTML = view('customers.new_order', [
            'customer_id' =>$request->input('customer_id'),
            'addresses' => $customer_addresses,
            'billing_address' => $billing_address,
            'sender_address' => $sender_address,
            'recipient_address' => $recipient_address,
            'shapes'=>$shapes,
            'types' => $types,
            'scales'=>$scales,
            'fee' => $fee
        ])->render();
        return response()->json([
            "html" => $returnHTML,
        ]);
    }

    public function show_existing_orders(Request $request){
        $shop = Shop::where('shop_name', $request->input('shop'))->value('id');
        $customer = Customer::where('shopify_customer_id', $request->input('customer_id'))->first();
        $orders = Order::where('shopify_customer_id',$customer->shopify_customer_id)->where('checkout_completed',1)
            ->where('additional_payment',0)->orderBy('order_name', 'DESC')->get();
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
                $additional_fee = view('customers.inc.additional_fee', ['order' => $order])->render();
                $keydate = view('customers.inc.keydate', ['order' => $order])->render();
                $shipment_to_postdelay = view('customers.inc.shipment_to_postdelay', ['order' => $order])->render();
                return response()->json([
                    "sender_form_html" => $sender_form,
                    "order_status" => $order_status,
                    "shipment_details" => $shipment_details,
                    "billing_email" => $billing_email,
                    "recepient_email" => $recepient_email,
                    "additional_fee" => $additional_fee,
                    "keydate" => $keydate,
                    "shipment_to_postdelay" =>$shipment_to_postdelay,
                ]);
            }
        }
    }

    public function update_order_status(Request $request){
        Order::find($request->input('order'))->update([
            'status_id' => $request->input('status')
        ]);

        $order = Order::find($request->input('order'));
        $this->status_log($order);

        $customer = Customer::find($order->customer_id);
        Mail::to($customer->email)->send(new NotificationEmail($customer,$order));

        return response()->json([
            'status' => 'changed'
        ]);
    }

    public function order_history(Request $request){
        $logs =  OrderStatusHistory::where('order_id',$request->id)->get();
        return view('orders.order_history')->with([
            'logs' => $logs
        ]);
    }

    public function place_additional_payments(Request $request){

        $shop = Shop::where('shop_name',$request->input('shop'))->first();
        if($request->input('type') == 'additional-fee'){
            $default =  PostDelayFee::where('default',1)->where('type','additional')->first();
            $draft_orders = $this->helper->getShop($shop->shop_name)->call([
                'METHOD' => 'POST',
                'URL' => '/admin/draft_orders.json',
                'DATA' =>
                    [
                        "draft_order" => [
                            'line_items' => [
                                [
                                    "title"=> $default->name,
                                    "price"=> $default->price,
                                    "quantity"=> 1,
                                ]
                            ],
                            "customer" => [
                                "id" => $request->input('customer-id'),
                            ],
                            "billing_address" => [
                                "address1" => $request->input('address1'),
                                "address2" =>  $request->input('address2'),
                                "city" =>  $request->input('city'),
                                "company" =>  $request->input('business'),
                                "first_name" =>  $request->input('first_name'),
                                "last_name" =>  $request->input('blast_name'),
                                "province" =>  $request->input('state'),
                                "country" =>  $request->input('country'),
                                "zip" =>  $request->input('postecode'),
                                "name" =>  $request->input('first_name').' '.$request->input('last_name'),
                            ]

                        ]

                    ]
            ]);
        }
        else{
            $default =  PostDelayFee::where('default',1)->where('type','request_form')->first();

            $draft_orders = $this->helper->getShop($shop->shop_name)->call([
                'METHOD' => 'POST',
                'URL' => '/admin/draft_orders.json',
                'DATA' =>
                    [
                        "draft_order" => [
                            'line_items' => [
                                [
                                    "title"=> $default->name,
                                    "price"=> $default->price,
                                    "quantity"=> 1,
                                ]
                            ],
                            "customer" => [
                                "id" => $request->input('customer-id'),
                            ],
                            "billing_address" => [
                                "address1" => $request->input('address1'),
                                "address2" =>  $request->input('address2'),
                                "city" =>  $request->input('city'),
                                "company" =>  $request->input('business'),
                                "first_name" =>  $request->input('first_name'),
                                "last_name" =>  $request->input('blast_name'),
                                "province" =>  $request->input('state'),
                                "country" =>  $request->input('country'),
                                "zip" =>  $request->input('postecode'),
                                "name" =>  $request->input('first_name').' '.$request->input('last_name'),
                            ]

                        ]

                    ]
            ]);
        }


        $invoiceURL = $draft_orders->draft_order->invoice_url;
        $token = explode('/',$invoiceURL)[5];
        $order =  new Order();
        $order->draft_order_id =  $draft_orders->draft_order->id;
        $order->checkout_token = $token;
        $order->ship_out_date = $request->input('ship_out_date');
        $order->checkout_completed = 0;

        $associate_order = Order::where('shopify_order_id',$request->input('order-id'))->first();
        $order->order_id = $associate_order->id;
        $order->additional_payment = 1;
        if($request->input('type') == 'additional-fee'){
            $order->additional_payment_name = 'Additional PostDelay Charges Payment';
        }
        else{
            $order->additional_payment_name = 'Request Form Payment';
        }


        $customer = Customer::where('shopify_customer_id',$request->input('customer-id'))->first();
        $order->customer_id = $customer->id;
        $order->shopify_customer_id = $request->input('customer-id');

        $billing_address = new BillingAddress();
        $billing_address->address1 = $request->input('address1');
        $billing_address->  address2 =  $request->input('address2');
        $billing_address ->city =  $request->input('city');
        $billing_address->business =  $request->input('business');
        $billing_address->first_name =  $request->input('first_name');
        $billing_address -> last_name =  $request->input('last_name');
        $billing_address->state =  $request->input('state');
        $billing_address->country =  $request->input('country');
        $billing_address->postcode =  $request->input('postecode');
        $billing_address->save();

        $order->billing_address_id = $billing_address->id;

        $order->save();

        return response()->json([
            "invoiceURL" => $invoiceURL,
        ]);
    }

    public function get_order_type(Request $request){
        $type = Order::where('shopify_order_id',$request->input('shopify_order_id'))->value('additional_payment');
        return response()->json([
            "type" => $type,
        ]);
    }

    public function set_key_dates(Request $request){
//        dd($request);
        KeyDate::UpdateOrcreate([
            "order_id" => $request->input('order_id'),
        ],[
            "received_post_date" => $request->input('received_post_date'),
            "completion_date" => $request->input('completion_date'),
        ]);

        return redirect()->back();
    }

    public function shipment_to_postdelay(Request $request){
        Order::where('order_name',$request->input('order_name'))->update([
            'ship_to_postdelay_date' => $request->input('ship-date'),
            'ship_method' => $request->input('ship-method'),
            'tracking_id' => $request->input('tracking_id'),
            'status_id' => 2
        ]);

        $order =   Order::where('order_name',$request->input('order_name'))->first();
        $this->status_log($order);

        $customer = Customer::find($order->customer_id);
        Mail::to($customer->email)->send(new NotificationEmail($customer,$order));

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

    public function download_pdf(Request $request){

        $pdf = App::make('dompdf.wrapper');
        $order = Order::where('shopify_order_id',$request->input('order'))->first();
        $pdf = $pdf->loadView('customers.pdf',[
            "order" => $order
        ]);
        return $pdf->download('PostDelay_OrderDetails.pdf');
    }

    public function update_order_sender_details(Request $request){
        SenderAddress::find($request->input('id'))->update($request->all());
        return redirect()->back();
    }

    public function update_order_recipient_details(Request $request){
        RecipientAddress::find($request->input('id'))->update($request->all());
        return redirect()->back();
    }
    public function order_update_billing_details(Request $request){
        BillingAddress::find($request->input('id'))->update($request->all());
        return redirect()->back();
    }


//    public function place_order(Request $request){
//
//
//        if($request->input('weight') == null){
//            $post_type = PostType::where('name',$request->input('post_type'))->first();
//            if($post_type != null){
//                if($post_type->weight == null){
//                    $weight = 1000;
//                }else{
//                    $weight = $post_type->weight;
//                }
//
//            }
//            else{
//                $weight = 1000;
//            }
//        }
//        else{
//            $weight = $request->input('weight');
//        }
//        $default =  PostDelayFee::where('default',1)->where('type','primary')->first();
////        dd($default->price);
//
//        $product = $this->helper->getShop('postdelay.myshopify.com')->call([
//            'METHOD' => 'POST',
//            'URL' => '/admin/api/2019-10/products.json',
//            'DATA' =>[
//                "product"=>[
//                    "title"=> $default->name,
//                    "requires_shipping" => true,
//                    "variants" => [
//                        [
//                            "price" =>  $default->price,
//                            "grams" =>$weight,
//                            "inventory_quantity" => 20
//
//                        ]
//
//                    ]
//                ],
//            ]]);
////
////dd($product);
//        $variant_id = $product->product->variants[0]->id;
////        dd($variant_id);
//        $product_listing = $this->helper->getShop('postdelay.myshopify.com')->call([
//            'METHOD' => 'GET',
//            'URL' => '/admin/api/2019-10/product_listings.json',
//        ]);
//
//        dd($product_listing);
//
//        $checkout = $this->helper->getShop('postdelay.myshopify.com')->call([
//            'METHOD' => 'POST',
//            'URL' => '/admin/checkouts.json',
//            'DATA' =>
//                [
//                    "checkout" => [
//                        'line_items' => [
//                            [
//                                "variant_id" => $variant_id,
//                                "quantity"=> 1,
//                            ]
//                        ],
//
//                    ]
//
//                ]
//        ]);
//        dd($checkout);
//        $invoiceURL = $draft_orders->draft_order->invoice_url;
//        $token = explode('/',$invoiceURL)[5];
//        $order =  new Order();
//        $order->draft_order_id =  $draft_orders->draft_order->id;
//        $order->checkout_token = $token;
//        $order->ship_out_date = $request->input('ship_out_date');
//        $order->checkout_completed = 0;
//
//        $customer = Customer::where('shopify_customer_id',$request->input('customer_id'))->first();
//
//        $order->customer_id = $customer->id;
//        $order->shopify_customer_id = $request->input('customer_id');
//
//        $package_detail  = new PackageDetail();
//        $package_detail->type = $request->input('post_type');
//        $package_detail->special_holding = $request->input('special_holding');
//        $package_detail->shape = $request->input('shape');
//        $package_detail->scale = $request->input('unit_of_measures');
//        $package_detail->weight = $weight;
//        $package_detail->length = $request->input('length');
//        $package_detail->girth = $request->input('girth');
//        $package_detail->width = $request->input('width');
//        $package_detail->height = $request->input('height');
//        $package_detail->setUpdatedAt(now());
//        $package_detail->setCreatedAt(now());
//        $package_detail->save();
//
//        $order->package_detail_id = $package_detail->id;
//
//        $billing_address = new BillingAddress();
//        $billing_address->address1 = $request->input('billing_address1');
//        $billing_address->  address2 =  $request->input('billing_address2');
//        $billing_address ->city =  $request->input('billing_city');
//        $billing_address->business =  $request->input('billing_business');
//        $billing_address->first_name =  $request->input('billing_first_name');
//        $billing_address -> last_name =  $request->input('billing_last_name');
//        $billing_address->state =  $request->input('billing_state');
//        $billing_address->country =  $request->input('billing_country');
//        $billing_address->postcode =  $request->input('billing_postecode');
//        $billing_address->email =   $request->input('billing_phone');
//        $billing_address->save();
//
//        $order->billing_address_id = $billing_address->id;
//
//        $sender_address = new SenderAddress();
//        $sender_address->address1 = $request->input('sender_address1');
//        $sender_address->  address2 =  $request->input('sender_address2');
//        $sender_address ->city =  $request->input('sender_city');
//        $sender_address->business =  $request->input('sender_business');
//        $sender_address->first_name =  $request->input('sender_first_name');
//        $sender_address -> last_name =  $request->input('sender_last_name');
//        $sender_address->state =  $request->input('sender_state');
//        $sender_address->country =  $request->input('sender_country');
//        $sender_address->postcode =  $request->input('sender_postecode');
//        $sender_address->phone =   $request->input('sender_phone');
//        $sender_address->save();
//
//        $order->sender_address_id = $sender_address->id;
//
//        $recipient_address = new RecipientAddress();
//        $recipient_address->address1 = $request->input('receipent_address1');
//        $recipient_address->  address2 =  $request->input('receipent_address2');
//        $recipient_address ->city =  $request->input('receipent_city');
//        $recipient_address->business =  $request->input('receipent_business');
//        $recipient_address->first_name =  $request->input('receipent_first_name');
//        $recipient_address -> last_name =  $request->input('receipent_last_name');
//        $recipient_address->state =  $request->input('receipent_state');
//        $recipient_address->country =  $request->input('receipent_country');
//        $recipient_address->postcode =  $request->input('receipent_postecode');
//        $recipient_address->phone =   $request->input('receipent_phone');
//        $recipient_address->save();
//
//        $order->recipient_address_id = $recipient_address->id;
//        $order->save();
//
//        return response()->json([
//            "invoiceURL" => $invoiceURL,
//        ]);
//    }



    public function get_checkout(){
        $checkout = $this->helper->getShop('postdelay.myshopify.com')->call([
            'METHOD' => 'POST',
            'URL' => '/admin/api/2019-10/checkouts.json',
            'DATA' =>
                [
                    "checkout" => [
                        'line_items' => [
                            [

                                "variant_id" => 30931674529873,
                                "quantity"=> 1,


                            ]
                        ],

                    ]

                ]
        ]);

        dd($checkout);
    }


    public function cancel_order(Request $request){
        $order = Order::where('token', $request->input('order_token'))->first();

        $cancelledd_refund = $this->helper->getShop('postdelay.myshopify.com')->call([
            'METHOD' => 'POST',
            'URL' => '/admin/api/2019-10/orders/'.$order->shopify_order_id.'/cancel.json',
//            'DATA' => [
//                "refund" => [
//                    "notify"=> true,
//                    "note" => "Customer Cancelled",
//                    "shipping" => [
//                        "full_refund"=> true
//                    ]
//                ],
//
//            ]
        ]);
        $status = $order->status_id;
        if($status == 1){
            $order->status_id = 6;
            $order->save();
            $this->status_log($order);
            $customer = Customer::find($order->customer_id);
            Mail::to($customer->email)->send(new NotificationEmail($customer,$order));
        }

        if($status == 2){
            if(count($order->has_additional_payments) > 0){
                $order->status_id = 7;
                $order->save();
                $this->status_log($order);
            }
            else{
                $order->status_id = 9;
                $order->save();
                $this->status_log($order);
            }

            $customer = Customer::find($order->customer_id);
            Mail::to($customer->email)->send(new NotificationEmail($customer,$order));
        }

        if($status == 3){
            if(count($order->has_additional_payments) > 0){
                $order->status_id = 10;
                $order->save();
                $this->status_log($order);
            }
            else{
                $order->status_id = 12;
                $order->save();
                $this->status_log($order);
            }

            $customer = Customer::find($order->customer_id);
            Mail::to($customer->email)->send(new NotificationEmail($customer,$order));
        }

////        if($cancelledd_refund != null){
//            $refund = $this->helper->getShop('postdelay.myshopify.com')->call([
//                'METHOD' => 'POST',
//                'URL' => '/admin/api/2019-10/orders/'.$order->shopify_order_id.'/refunds.json',
//
//                'DATA' => [
//                    "refund" => [
//                    "currency"=> "USD",
//                    "notify"=> true,
//                    "note" => "Customer Cancelled",
//                    "shipping" => [
//                        "full_refund"=> true
//                    ]
//                ],
//
//            ]
//                ]);
////        }
//        dd($refund);

    }

    public function delete_order(Request $request){
        $order = Order::find($request->input('id'));
        $this->helper->getShop('postdelay.myshopify.com')->call([
            'METHOD' => 'DELETE',
            'URL' => 'admin/orders/' .$order->shopify_order_id. '.json',
        ]);
        $order->delete();
        return redirect()->back();
    }


    public function showEmail(){
        return view('email_template');
    }

    public function get_shipping_rates(Request $request){
               if($request->input('weight') == null){
            $post_type = PostType::where('name',$request->input('post_type'))->first();
            if($post_type != null){
                if($post_type->weight == null){
                    $weight = 1000;
                }else {
                    $weight = $post_type->weight;
                }
            }
            else{
                $weight = 1000;
            }
        }
        else{
            $weight = $request->input('weight');
        }

        $default =  PostDelayFee::where('default',1)->where('type','primary')->first();
                $product = $this->helper->getShop('postdelay.myshopify.com')->call([
            'METHOD' => 'POST',
            'URL' => '/admin/api/2019-10/products.json',
            'DATA' =>[
                "product"=>[
                    "title"=> 'Post Delay Fee',
                    "requires_shipping" => true,
                    "variants" => [
                        [
                            "price" =>  $default->price,
                            "grams" =>$weight
                        ]

                    ]
                ],
            ]
                ]);

                $product_id = $product->product->variants[0]->id;
                echo $product_id;
    }
}

