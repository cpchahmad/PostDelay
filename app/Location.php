<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'address1','address2','city','state','postcode'
        ,'country','phone','shopify_location_id','shop_id','status','shop_name'
    ];

    public function has_shop(){
        return $this->belongsTo('App\Shop','shop_id');
    }
}
