<?php


namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Oseintow\Shopify\Facades\Shopify;
use Session;
use App\Shop;

class ShopsController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new HelperController();
    }
    public function index(Request $request){

        $shopUrl = $request->input('shop');
        $accessToken = Shopify::setShopUrl($shopUrl)->getAccessToken($request->code);
        if (Shop::where('shop_name', '=', $shopUrl)->exists()) {
            $shop = Shop::where('shop_name', $shopUrl)
                ->update([
                    'access_token'=>$accessToken
                ]);
        }else{
            $shop = Shop::create([
                'shop_name'=> $shopUrl,
                'access_token'=>$accessToken
            ]);
        }
        session(['shop_name' => $shopUrl]);
        session(['access_token' => $accessToken]);

        return redirect()->route('shop.dashboard');
    }

    public function Dashboard(){
        $orders_count = count(App\Order::where('checkout_completed',1)->where('additional_payment',0)->get());
        $orders = App\Order::all();
        $revenue = $orders->sum('order_total');
        if($revenue){
            $average = $revenue / $orders_count;
        }else{
            $average = 0;
        }
        $customers_count = count(App\Customer::all());
        return view('dashboard')->with([
            'orders' => $orders_count,
            'revenue' => $revenue,
            'average' => $average,
            'customers' => $customers_count
        ]);
    }




}
