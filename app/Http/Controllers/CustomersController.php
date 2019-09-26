<?php

namespace App\Http\Controllers;

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
                            "send_email_invite" => true
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
                        'country' => $request->input('coutry'),
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
}
