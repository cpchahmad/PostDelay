<?php

namespace App\Http\Controllers;
use App;
use Oseintow\Shopify\Facades\Shopify;

class HelperController extends Controller
{

    public $shopify;

    public function getShop($shop){
            $shop = App\Shop::Where('shop_name', $shop)->first();
            return $this->getShopify($shop->shop_name, $shop->access_token);
   }

    public function getShopify($shop_name,$access_token){
        $this->shopify = App::make('ShopifyAPI', [
            'API_KEY' => env('SHOPIFY_APIKEY'),
            'API_SECRET' => env('SHOPIFY_SECRET'),
            'SHOP_DOMAIN' => $shop_name,
            'ACCESS_TOKEN' => $access_token
        ]);
        return $this->shopify;
    }

}
