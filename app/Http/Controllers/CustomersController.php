<?php

namespace App\Http\Controllers;

use App\Address;
use App\Customer;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Oseintow\Shopify\Facades\Shopify;

class CustomersController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper =new HelperController();
    }

    public function customer_create(Request $request){
        $validate_data =  Validator::make($request->toArray(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'business' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
//           'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:255'],
            'shop' => ['required', 'string', 'max:255'],
        ]);

        if ($validate_data->fails()) {
            return response()->json($validate_data->messages(), 200);
        } else{
            $shop = Shop::where('shop_name',$request->input('shop'))->value('id');
            if($shop != null){

//dd($request);
                $customer = $this->helper->getShop($request->input('shop'))->call([
                    'METHOD' => 'POST',
                    'URL' => '/admin/customers.json',
                    'DATA' => [
                        "customer"  => [
                            "first_name" => $request->input("first_name"),
                            "last_name" => $request->input("last_name"),
                            "email"  =>$request->input("email"),
                            "phone"  => $request->input('phone'),
                            "send_email_welcome"=> false,
                            "verified_email" => false,
                            "send_email_invite" => true,

                        ]
                    ]
                ]);

                if($customer != null){


                    Customer::create([
                        'first_name' => $request->input("first_name"),
                        'last_name' => $request->input("last_name"),
                        'email' => $request->input("email"),
                        'business' => $request->input("business"),
                        'phone' => $request->input('phone'),
                        'address1' => $request->input('address1'),
                        'address2' => $request->input('address2'),
                        'city' => $request->input('city'),
                        'state' => $request->input('state'),
                        'country' => $request->input('country'),
                        'postcode' => $request->input('postecode'),
                        'shop_id' => $shop,
                        'shopify_customer_id' => $customer->customer->id,
                    ]);
                }

                return response()->json(['msg'=>'created','customer_id'=>$customer->customer->id], 200);
            }
            else{
                return response()->json('Shop Not Registered', 200);
            }

        }


    }

    public function sendactivationlink(Request $request){

        $invite_send = $this->helper->getShop($request->input('shop'))->call([
            'METHOD' => 'post',
            'URL' => 'admin/customers/'.$request->input('customer_id').'/send_invite.json',
        ]);

        return response()->json(['invite_send'=>'created'], 200);
    }

    public function index(){
        return view('customers.index');
    }
    public function add_customer_addresses(Request $request){
        $shop = Shop::where('shop_name',$request->input('shop'))->value('id');
        $customer = Customer::where('shopify_customer_id',$request->input('customer_id'))->first();
        if($shop != null && $customer != null){

            $address = $this->helper->getShop($request->input('shop'))->call([
                'METHOD' => 'POST',
                'URL' => '/admin/customers/'. $customer->shopify_customer_id.'/addresses.json',
                'DATA' => [
                    "address"  => [
                        "address1"=>$request->input('address1'),
                        "address2"=> $request->input('address2'),
                        "city"=>$request->input('city'),
                        "company"=> $request->input('business'),
                        "first_name"=> $request->input('first_name'),
                        "last_name"=> $request->input('last_name'),
                        "province"=> $request->input('province'),
                        "country"=> $request->input('country'),
                        "phone" => $request->input('phone'),
                        "zip"=> $request->input('postecode'),
                        "name"=> $request->input('first_name').' '.$request->input('last_name'),
                    ]
                ]
            ]);

            if($address != null){
                Address::create([
                    'first_name' => $request->input("first_name"),
                    'last_name' => $request->input("last_name"),
                    'email' => $request->input("email"),
                    'address_type' => $request->input('address_type'),
                    'business' => $request->input("business"),
                    'phone' => $request->input('phone'),
                    'address1' => $request->input('address1'),
                    'address2' => $request->input('address2'),
                    'city' => $request->input('city'),
                    'state' => $request->input('province'),
                    'country' => $request->input('country'),
                    'postcode' => $request->input('postecode'),
                    'shop_id' => $shop,
                    'shopify_customer_id' => $customer->shopify_customer_id,
                    'customer_id' =>$customer->id,
                    'shopify_address_id' => $address->customer_address->id

                ]);
            }


            return response()->json(['msg'=>'address_created'], 200);
        }
        else{
            return response()->json(['msg'=>'shop or customer not exists'], 200);
        }

    }

    public function get_customer_details(Request $request){
        $shop = Shop::where('shop_name',$request->input('shop'))->value('id');
        $customer = Customer::where('shopify_customer_id',$request->input('customer_id'))
            ->where('shop_id',$shop)->first();
        $customer_addresses = Address::where('shopify_customer_id',$request->input('customer_id'))
            ->where('shop_id',$shop)->get();
        $returnHTML = view('customers.customer_detail',['customer'=> $customer,'addresses'=>$customer_addresses])->render();
        return response()->json([
            "html" => $returnHTML,
        ]);

    }

    public function update_customer_details(Request $request){
        $customer = Customer::where('shopify_customer_id',$request->input('customer_id'))->first();
        $validate_data =  Validator::make($request->toArray(), [
            'email' => ['required', 'string', 'email', 'max:255',  'unique:customers,email,'.$customer->id],
        ]);

        if ($validate_data->fails()) {
            return response()->json($validate_data->messages(), 200);
        } else{
            $shop = Shop::where('shop_name',$request->input('shop'))->value('id');

            if($shop != null){
                $updated_customer = $this->helper->getShop($request->input('shop'))->call([
                    'METHOD' => 'PUT',
                    'URL' => '/admin/customers/'.$request->input('customer_id').'.json',
                    'DATA' => [
                        "customer"  => [
                            "first_name" => $request->input("first_name"),
                            "last_name" => $request->input("last_name"),
                            "email"  =>$request->input("email"),
                            "phone"  => $request->input('phone'),
                            "send_email_welcome"=> false,
                            "verified_email" => false,
                            "send_email_invite" => true,

                        ]
                    ]
                ]);

                if($updated_customer != null){
                    Customer::where('shopify_customer_id',$updated_customer->customer->id)->update([
                        'first_name' => $request->input("first_name"),
                        'last_name' => $request->input("last_name"),
                        'email' => $request->input("email"),
                        'business' => $request->input("business"),
                        'phone' => $request->input('phone'),
                        'address1' => $request->input('address1'),
                        'address2' => $request->input('address2'),
                        'city' => $request->input('city'),
                        'state' => $request->input('state'),
                        'country' => $request->input('country'),
                        'postcode' => $request->input('postecode'),
                        'shop_id' => $shop,
                        'shopify_customer_id' => $updated_customer->customer->id,
                    ]);
                }


                return response()->json(['msg'=>'Updated'], 200);
            }
            else{
                return response()->json(['msg'=>'Shop Not Registered'], 200);
            }

        }
    }

    public function update_address_details(Request $request){

      $new_default_address =  Address::find($request->input('address_id'));
//        $default_address = $this->helper->getShop($request->input('shop'))->call([
//            'METHOD' => 'PUT',
//            'URL' => '/admin/customers/'.$new_default_address->shopify_customer_id.'/addresses/'.$new_default_address->shopify_address_id.'json',
//        ]);

//        if($default_address){
            Address::where('address_type',$new_default_address->address_type)
                ->where('customer_id',$new_default_address->customer_id)->update(['default'=>0]);

            Address::find($request->input('address_id'))->update(['default'=>1]);
//        }
    }

    public function delete_address(Request $request){
        $address =  Address::find($request->input('address_id'));

        $address_json = $this->helper->getShop($address->has_Shop->shop_name)->call([

            'METHOD' => 'GET',
            'URL' => '/admin/customers/'.$address->shopify_customer_id.'/addresses/'.$address->shopify_address_id.'json',
        ]);

        if($address_json->customer_address->default == false){
             $this->helper->getShop($address->has_Shop->shop_name)->call([

                'METHOD' => 'DELETE',
                'URL' => '/admin/customers/'.$address->shopify_customer_id.'/addresses/'.$address->shopify_address_id.'json',
            ]);
             Address::find($request->input('address_id'))->delete();
        }

    }
}

