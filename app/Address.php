<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'first_name','last_name', 'email','business','address1','address2','city','state','postcode'
        ,'country','phone','shopify_customer_id','shop_id','customer_id','shopify_address_id','address_type','default'
    ];

    public function has_Shop(){
        return $this->belongsTo('App\Shop','shop_id');
    }
}
