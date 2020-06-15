<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'draft_order_id','checkout_token','ship_out_date','checkout_completed','shopify_order_id',
        'shopify_customer_id','order_name','order_total','payment_gateway','shipping_method_title','shipping_method_id',
        'shipping_method_price','shipping_method_source','status_id','customer_id','package_detail_id','billing_address_id',
        'sender_address_id','recipient_address_id','token','ship_to_postdelay_date','ship_method','tracking_id','outbound_tracking_id'
    ];

    public function has_status(){
        return $this->belongsTo('App\Status','status_id');
    }

    public function has_sender(){
        return $this->belongsTo('App\SenderAddress','sender_address_id');
    }
    public function has_package_detail(){
        return $this->belongsTo('App\PackageDetail','package_detail_id');
    }

    public function has_billing(){
        return $this->belongsTo('App\BillingAddress','billing_address_id');
    }

    public function has_recepient(){
        return $this->belongsTo('App\RecipientAddress','recipient_address_id');

    }
    public function has_customer(){
        return $this->belongsTo('App\Customer','customer_id');
    }
    public function has_additional_payments(){
        return $this->hasMany('App\Order','order_id');
    }

    public function has_order(){
        return $this->belongsTo('App\Order','order_id');
    }

    public function has_key_dates(){
        return $this->hasOne('App\KeyDate','order_id');
    }
    public function has_logs(){
        return $this->hasMany('App\OrderLog','order_id');
    }
}
