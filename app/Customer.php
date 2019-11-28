<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'first_name','last_name', 'email', 'password','business','address1','address2','city','state','postcode'
        ,'country','phone','email_verified_at','shopify_customer_id','shop_id','accept_marketing'
    ];

    public function has_Shop(){
        return $this->belongsTo('App\Shop','shop_id');
    }

    public function has_addresses(){
        return $this->hasMany('App\Address','customer_id');
    }

    public function has_orders(){
        return $this->hasMany('App\Order','customer_id');
    }
}
