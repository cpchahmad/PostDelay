<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Mail\NotificationEmail;
use App\Order;
use App\OrderResponse;
use App\OrderStatusHistory;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebhookController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new HelperController();
    }

    public function getWebhooks()
    {
        $webhooks = $this->helper->getShopify()->call([
            'METHOD' => 'get',
            'URL' => 'admin/webhooks.json',
        ]);
        dd($webhooks);
    }

    public function webhook(Request $request)
    {

    }

    public function Webhook_customer_update($data){

        if (Customer::where('shopify_customer_id', '=', $data->id)->exists()) {
                $customer = Customer::where('shopify_customer_id', '=', $data->id)->first();
        }else{
            $customer = new Customer();
        }
        $customer->status = $data->state;
        $customer->save();
    }


    public function CustomerDateProcessing($data){
        $data = json_decode($data, true);

        $customer = Customer::find(50);
        $customer->status = $data['email'];
        $customer->save();}


        public function webhook_order_create($order, $shop)
        {
            $checkout_token =  explode('/',$order->landing_site)[3];
            $draft_order = Order::where('checkout_token',$checkout_token)
                ->where('checkout_completed',0)->first();
            if($draft_order != NULL){

                if($draft_order->additional_payment  == 1){
                    $order_controller = new OrdersController();
                    $order_controller->get_order();

                }
                else{
                    $draft_order->checkout_completed = 1;
                    $draft_order->shopify_order_id = $order->id;
                    $draft_order->order_name = $order->name;
                    $draft_order->order_total = $order->total_price;
                    $draft_order->payment_gateway = $order->gateway;
                    $draft_order->items = json_encode($order->line_items);
                    if(isset($order->shipping_lines)){
                        $draft_order->shipping_method_title = $order->shipping_lines[0]->title;
                        $draft_order->shipping_method_id = $order->shipping_lines[0]->id;
                        $draft_order->shipping_method_price = $order->shipping_lines[0]->price;
                        $draft_order->shipping_method_source = $order->shipping_lines[0]->source;

                    }
                    $draft_order->status_id =1;
                    $draft_order->token = $order->token;

                    if(isset($order->billing_address)){
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


    public function script_tag(Request $request){
        $this->helper->getShopify()->call([
            'METHOD' => 'POST',
            'URL' => 'admin/script_tags.json',
            "DATA" => [
                "script_tag" => [
                    "event" => "onload",
                    "src" => 'https://postdelay.shopifyapplications.com/js/script_tag.js',
                ]
            ]
        ]);
    }

    public function getScriptTags(Request $request){
        $scripts = $this->helper->getShopify()->call([
            'METHOD' => 'get',
            'URL' => 'admin/script_tags.json',
        ]);
//        dd($scripts);

        foreach ($scripts->script_tags as $script){

            $this->helper->getShopify()->call([
                'METHOD' => 'delete',
                'URL' => 'admin/script_tags/'.$script->id.'.json',
            ]);
        }
    }

    /**
     * @param $draft_order
     */
    public function status_log($draft_order): void
    {
        $history = new OrderStatusHistory();
        $history->order_id = $draft_order->id;
        $history->order_status_id = $draft_order->status_id;
        $history->change_at = now();
        $history->setCreatedAt(now());
        $history->setUpdatedAt(now());
        $history->save();
    }


}

