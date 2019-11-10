<?php

namespace App\Http\Controllers;
use App;
use Oseintow\Shopify\Facades\Shopify;
use OhMyBrew\ShopifyApp\Facades\ShopifyApp;


class HelperController extends Controller
{

    public $shopify;
    public $shop;

    public function getShop(){
        $shop = App\Shop::Where('shopify_domain', 'postdelay.myshopify.com')->first();
        return $this->shop;
    }

    public function getShopify(){
        $shop = App\Shop::Where('shopify_domain', 'postdelay.myshopify.com')->first();
        $this->shopify = App::make('ShopifyAPI', [
            'API_KEY' => env('SHOPIFY_APIKEY'),
            'API_SECRET' => env('SHOPIFY_SECRET'),
            'SHOP_DOMAIN' => $shop->shopify_domain,
            'ACCESS_TOKEN' => $shop->access_token
        ]);
        return $this->shopify;
    }
}
