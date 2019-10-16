<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostDelayFee extends Model
{
    protected $fillable =  [
        'name','price','default','type'
    ];
}
