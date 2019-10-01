<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    protected $fillable = [
        'first_name','last_name', 'email','business','address1','address2','city','state','postcode'
        ,'country','phone'
    ];
}
