<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new HelperController();
    }

    public function getWebhooks(){
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

    public function webhook(Request $request){

         $this->helper->getShop(session('shop_name'))->call([
            'METHOD' => 'POST',
            'URL' => 'admin/webhooks.json',
            "DATA" => [
                "webhook" => [
                    "topic" =>"customers/create",
//                    "address" =>env('APP_URL').'/webhook/create/customer',
                    "address" =>' https://a1922723.ngrok.io/webhook/create/customer',
                    "format" => "json"
                ]
            ]
        ]);
          $this->helper->getShop(session('shop_name'))->call([
            'METHOD' => 'POST',
            'URL' => 'admin/webhooks.json',
            "DATA" => [
                "webhook" => [
                    "topic" =>"customers/update",
                    "address" =>/*env('APP_URL').*/'https://a1922723.ngrok.io/webhook/update/customer',
                    "format" => "json"
                ]
            ]
        ]);
          $this->helper->getShop(session('shop_name'))->call([
            'METHOD' => 'POST',
            'URL' => 'admin/webhooks.json',
            "DATA" => [
                "webhook" => [
                    "topic" =>"customers/delete",
                    "address" => /*env('APP_URL').*/'https://a1922723.ngrok.io/webhook/delete/customer',
                    "format" => "json"
                ]
            ]
        ]);
          $this->helper->getShop(session('shop_name'))->call([
            'METHOD' => 'POST',
            'URL' => 'admin/webhooks.json',
            "DATA" => [
                "webhook" => [
                    "topic" =>"orders/create",
                    "address" => /*env('APP_URL').*/'https://a1922723.ngrok.io/webhook/create/order',
                    "format" => "json"
                ]
            ]
        ]);
          $this->helper->getShop(session('shop_name'))->call([
            'METHOD' => 'POST',
            'URL' => 'admin/webhooks.json',
            "DATA" => [
                "webhook" => [
                    "topic" =>"orders/updated",
                    "address" => /*env('APP_URL').*/'https://a1922723.ngrok.io/webhook/update/order',
                    "format" => "json"
                ]
            ]
        ]);
          $this->helper->getShop(session('shop_name'))->call([
            'METHOD' => 'POST',
            'URL' => 'admin/webhooks.json',
            "DATA" => [
                "webhook" => [
                    "topic" =>"orders/delete",
                    "address" => /*env('APP_URL').*/'https://a1922723.ngrok.io/webhook/delete/order',
                    "format" => "json"
                ]
            ]
        ]);

    }

    public function webhook_customer_create(Request $request){
        $shop = $_SERVER['X-Shopify-Shop-Domain'];
        if($shop != null){
            $shopify_customer_id =  $request['id'];
            $customer = Customer::where('shopify_customer_id',$shopify_customer_id)->first();
            if($customer != null){

                dd($customer);
            }
            else{

            }

        }
    }
    public function webhook_customer_update(Request $request){
        dd($request);
    }
    public function webhook_customer_delete(Request $request){
        dd($request);
    }
    public function webhook_order_create(Request $request){
        dd($request);
    }
    public function webhook_order_update(Request $request){
        dd($request);
    }
    public function webhook_order_delete(Request $request){
        dd($request);
    }
}
