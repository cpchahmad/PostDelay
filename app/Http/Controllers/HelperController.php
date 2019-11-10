<?php

namespace App\Http\Controllers;
use App;
use Oseintow\Shopify\Facades\Shopify;

class HelperController extends Controller
{

    public $shopify;

    public function getShop($shop){
            $shop = App\Shop::Where('shopify_domain', $shop)->first();
            return $this->getShopify($shop->shopify_domain, $shop->access_token);
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
