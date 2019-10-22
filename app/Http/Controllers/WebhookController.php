<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\OrderStatusHistory;
use App\Shop;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new HelperController();
    }

    public function getWebhooks()
    {
        $webhooks = $this->helper->getShop(session('shop_name'))->call([
            'METHOD' => 'get',
            'URL' => 'admin/webhooks.json',
        ]);
        dd($webhooks);

//        foreach ($webhooks->webhooks as $webhook){
//
//            $this->helper->getShop(session('shop_name'))->call([
//                'METHOD' => 'delete',
//                'URL' => 'admin/webhooks/'.$webhook->id.'.json',
//            ]);
//        }
    }

    public function webhook(Request $request)
    {

        $APP_URL = 'https://postdelay.shopifyapplications.com';
//        $APP_URL = 'https://4587c175.ngrok.io';

        $this->helper->getShop(session('shop_name'))->call([
            'METHOD' => 'POST',
            'URL' => 'admin/webhooks.json',
            "DATA" => [
                "webhook" => [
                    "topic" => "customers/create",
                    "address" => $APP_URL.'/webhook/create/customer',
                    "format" => "json"
                ]
            ]
        ]);

        $this->helper->getShop(session('shop_name'))->call([
            'METHOD' => 'POST',
            'URL' => 'admin/webhooks.json',
            "DATA" => [
                "webhook" => [
                    "topic" => "orders/create",
                    "address" => $APP_URL.'/webhook/create/order',
                    "format" => "json"
                ]
            ]
        ]);


    }

    public function webhook_customer_create(Request $request)
    {
        $customer = new CustomersController();
        $customer->get_customers();
    }

    public function webhook_order_create(Request $request)
    {

        $orders = new OrdersController();
        $orders->get_order();

    }


    public function script_tag(Request $request){
        $this->helper->getShop(env('WEB_URL'))->call([
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
        $scripts = $this->helper->getShop(session('shop_name'))->call([
            'METHOD' => 'get',
            'URL' => 'admin/script_tags.json',
        ]);
//        dd($scripts);

        foreach ($scripts->script_tags as $script){

            $this->helper->getShop(session('shop_name'))->call([
                'METHOD' => 'delete',
                'URL' => 'admin/script_tags/'.$script->id.'.json',
            ]);
        }
    }



}

