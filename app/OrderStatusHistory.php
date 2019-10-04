<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    protected $fillable=[
        'order_id','order_status_id','change_at',
    ];

    public function has_order(){
        return $this->belongsTo('App\Order','order_id');
    }
    public function has_status(){
        return $this->belongsTo('App\Status','order_status_id');
    }
}
