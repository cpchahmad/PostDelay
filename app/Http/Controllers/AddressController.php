<?php

namespace App\Http\Controllers;

use App\Address;
use App\Customer;
use App\Order;
use App\Shop;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new HelperController();
    }

    public function get_address(Request $request)
    {
        $addresses = Address::where('address_type', $request->input('type'))
            ->where('shopify_customer_id', $request->input('customer_id'))->get();
        return response()->json([
            "addresses" => $addresses,
        ]);
    }

    public function get_address_form(Request $request)
    {

        $address = Address::find($request->input('address'));
        $returnHTML = view('customers.addresses', ['address' => $address])->render();
        return response()->json([
            "html" => $returnHTML,
        ]);
    }

    public function update_address(Request $request)
    {
        Address::find($request->input('address_id'))->update($request->all());
        $address = Address::find($request->input('address_id'));
        $returnHTML = view('customers.addresses', ['address' => $address])->render();

//     $this->helper->getShopify()->call([
//                'METHOD' => 'PUT',
//                'URL' => 'admin/customers/' . $address->shopify_customer_id . '/addresses/'.$address->shopify_address_id.'.json',
//                'DATA' => [
//                    "address" => [
//                        "id" => $address->shopify_address_id,
//                        "address1" => $request->input('address1'),
//                        "address2" => $request->input('address2'),
//                        "city" => $request->input('city'),
//                        "company" => $request->input('business'),
//                        "first_name" => $request->input('first_name'),
//                        "last_name" => $request->input('last_name'),
//                        "province" => $request->input('state'),
//                        "country" => $request->input('country'),
//                        "phone" => $request->input('phone'),
//                        "zip" => $request->input('postcode'),
//                    ]
//                ]
//            ]);
        if($request->input('source') == 'admin'){
            return redirect()->back();
        }else {
            return response()->json([
                "html" => $returnHTML,
            ]);
        }
    }

    public function set_default_address(Request $request)
    {
        $new_default_address = Address::find($request->input('address_id'));
        Address::where('address_type', $new_default_address->address_type)
            ->where('customer_id', $new_default_address->customer_id)->update(['default' => 0]);

        Address::find($request->input('address_id'))->update(['default' => 1]);
    }

    public function delete_address(Request $request)
    {
//        $address = Address::find($request->input('address_id'));
        Address::find($request->input('address_id'))->delete();
      /*  if($address->shopify_address_id != null){
            $address_json = $this->helper->getShopify()->call([
                'METHOD' => 'GET',
                'URL' => '/admin/customers/' . $address->shopify_customer_id . '/addresses/' . $address->shopify_address_id . 'json',
            ]);
            if($address_json->customer_address->default != true){
                $this->helper->getShopify()->call([
                    'METHOD' => 'DELETE',
                    'URL' => '/admin/customers/' . $address->shopify_customer_id . '/addresses/' . $address->shopify_address_id . 'json',
                ]);
            }

            Address::find($request->input('address_id'))->delete();
        }
        else{
            Address::find($request->input('address_id'))->delete();
        }*/
        if($request->ajax()){
            return 0;
        }
        else{
            return redirect()->back();

        }


//        return redirect()->back();
    }

    public function delete_customer_address(Request $request){
        Address::find($request->input('address_id'))->delete();
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function get_billing_addresses (Request $request){
        $order = Order::where('shopify_order_id',$request->input('order'))->first();
        if($request->input('type') == 'additional-fee'){
            if($request->input('response') == '20'){
                $response = '20';
                $address = $order->has_recepient;
                $billing_addresses = Address::where('address_type','Recipients')->where('shopify_customer_id',$request->input('customer_id'))->get();
            }
            elseif ($request->input('response') == '16'){
                $response = '16';
                $address = $order->has_billing;
                $billing_addresses = Address::where('address_type','Billing')->where('shopify_customer_id',$request->input('customer_id'))->get();
            }
            elseif ($request->input('response') == '17'){
                $response = '17';
                $address = $order->has_sender;
                $billing_addresses = Address::where('address_type','Sender')->where('shopify_customer_id',$request->input('customer_id'))->get();
            }
            elseif ($request->input('response') == '9'){
                $response = '9';
                $address = $order->has_sender;
                $billing_addresses = [];
            }
            elseif ($request->input('response') == '21'){
                $response = '21';
                $address = $order->has_sender;
                $billing_addresses = Address::where('address_type','Sender')->where('shopify_customer_id',$request->input('customer_id'))->get();
            }


        }else{
            $response = null;
            $address = $order->has_sender;
            $billing_addresses = Address::where('address_type','Sender')->where('shopify_customer_id',$request->input('customer_id'))->get();
        }

        $fill_address = view('customers.request_form_billing_address', ['address' => $address,'response' => $response])->render();
        if($response != "9"){
            $returnHTML = view('customers.inc.request_form_billing', ['addresses' => $billing_addresses])->render();

        }
        else{
            $returnHTML = '';

        }
        return response()->json([
            "html" => $returnHTML,
            "fill_address" => $fill_address,
        ]);
    }

    public function get_billing_form(Request $request)
    {
        $address = Address::find($request->input('address'));
        if($request->input('response') != null){
            $response = $request->input('response');
        }
        else{
            $response = null;
        }
        $returnHTML = view('customers.request_form_billing_address', ['address' => $address,'response' => $response])->render();

        return response()->json([
            "html" => $returnHTML,
        ]);
    }

    public function set_all(Request $request){

       $address =  Address::find($request->input('address_id'));
       $types = array();
       if($address->address_type == "Billing"){
           array_push($types,'Recipients','Sender');
       }
        if($address->address_type == "Sender"){
            array_push($types,'Recipients','Billing');
        }
        if($address->address_type == "Recipients"){
            array_push($types,'Billing','Sender');
        }
        foreach ($types as $type){
            Address::create([
                "address_type" =>$type,
                "address1" => $address->address1,
                "address2" => $address->address2,
                "city" => $address->city,
                "business" => $address->business,
                "first_name" => $address->first_name,
                "last_name" => $address->last_name,
                "state" => $address->state,
                "country" => $address->country,
                "phone" => $address->phone,
                "postcode" => $address->postcode,
                "email" => $address->email,
                "shopify_customer_id" => $address->shopify_customer_id,
                "shop_id" => $address->shop_id,
                "customer_id" => $address->customer_id,
//                "shopify_address_id"=> $address->shopify_address_id,
            ]);
        }

    }

}
