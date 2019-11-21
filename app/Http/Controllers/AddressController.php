<?php

namespace App\Http\Controllers;

use App\Address;
use App\Customer;
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
        $this->helper->getShopify()->call([
                'METHOD' => 'PUT',
                'URL' => 'admin/customers/' . $address->shopify_customer_id . '/addresses/'.$address->shopify_address_id.'.json',
                'DATA' => [
                    "address" => [
                        "id" => $address->shopify_address_id,
                        "address1" => $request->input('address1'),
                        "address2" => $request->input('address2'),
                        "city" => $request->input('city'),
                        "company" => $request->input('business'),
                        "first_name" => $request->input('first_name'),
                        "last_name" => $request->input('last_name'),
                        "province" => $request->input('province'),
                        "country" => $request->input('country'),
                        "phone" => $request->input('phone'),
                        "zip" => $request->input('postcode'),
                    ]
                ]
            ]);

        $address_update = $address->update([
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
            'postcode' => $request->input('postecode')
        ]);

        $address = Address::find($request->input('address_id'));
        $returnHTML = view('customers.addresses', ['address' => $address])->render();


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
        $address = Address::find($request->input('address_id'));

        $address_json = $this->helper->getShopify()->call([
            'METHOD' => 'GET',
            'URL' => '/admin/customers/' . $address->shopify_customer_id . '/addresses/' . $address->shopify_address_id . 'json',
        ]);

         $this->helper->getShopify()->call([
                'METHOD' => 'DELETE',
                'URL' => '/admin/customers/' . $address->shopify_customer_id . '/addresses/' . $address->shopify_address_id . 'json',
         ]);
            Address::find($request->input('address_id'))->delete();

//        return redirect()->back();
    }
    public function get_billing_addresses (Request $request){
        $billing_addresses = Address::where('address_type','Billing')->where('shopify_customer_id',$request->input('customer_id'))->get();
        $returnHTML = view('customers.inc.request_form_billing', ['addresses' => $billing_addresses])->render();
        return response()->json([
            "html" => $returnHTML,
        ]);
    }

    public function get_billing_form(Request $request)
    {
        $address = Address::find($request->input('address'));
        $returnHTML = view('customers.request_form_billing_address', ['address' => $address])->render();
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
                "shopify_address_id"=> $address->shopify_address_id,
            ]);
        }

    }

}
