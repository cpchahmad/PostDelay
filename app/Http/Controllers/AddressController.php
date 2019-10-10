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
        $returnHTML = view('customers.addresses', ['address' => $address])->render();

        $this->helper->getShop($request->input('shop'))->call([
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
                        "province" => $request->input('state'),
                        "country" => $request->input('country'),
                        "phone" => $request->input('phone'),
                        "zip" => $request->input('postcode'),
                    ]
                ]
            ]);
            return response()->json([
                "html" => $returnHTML,
            ]);

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

        $address_json = $this->helper->getShop($address->has_Shop->shop_name)->call([

            'METHOD' => 'GET',
            'URL' => '/admin/customers/' . $address->shopify_customer_id . '/addresses/' . $address->shopify_address_id . 'json',
        ]);

        dd($address_json);
        if ($address_json->customer_address->default == false) {
            $this->helper->getShop($address->has_Shop->shop_name)->call([

                'METHOD' => 'DELETE',
                'URL' => '/admin/customers/' . $address->shopify_customer_id . '/addresses/' . $address->shopify_address_id . 'json',
            ]);
            Address::find($request->input('address_id'))->delete();
        }
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

}
