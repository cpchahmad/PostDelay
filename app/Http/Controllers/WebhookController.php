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
        $webhooks = $this->helper->getShopify()->call([
            'METHOD' => 'get',
            'URL' => 'admin/webhooks.json',
        ]);
        dd($webhooks);

//        foreach ($webhooks->webhooks as $webhook){
//
//            $this->helper->getShopify()->call([
//                'METHOD' => 'delete',
//                'URL' => 'admin/webhooks/'.$webhook->id.'.json',
//            ]);
//        }
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

    public function webhook_customer_delete($data) {
//        $customer = $this->helper->getShopify()->call([
//            'METHOD' => 'DELETE',
//            'URL' => '/admin/customers/'.$data->id.'.json',
//        ]);
//
//        $customers = Customer::where('shopify_customer_id', $data->id)->delete();
    }

    public function CustomerDateProcessing($data){
        $data = json_decode($data, true);

        $customer = Customer::find(50);
        $customer->status = $data['email'];
        $customer->save();

//
//        $customer = Customer::where('shopify_customer_id', $data['id'])->first();
//        if($customer){
//                $customer->status = $data['status'];
//                $customer->save();
//        }
    }

    public function webhook_order_create(Request $request)
    {

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



}

