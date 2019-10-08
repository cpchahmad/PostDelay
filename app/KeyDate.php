<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeyDate extends Model
{
    protected $fillable = [
      'order_id','received_post_date','completion_date'
    ];
}
