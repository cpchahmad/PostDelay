<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function has_cities(){
        return $this->hasMany('App\Country','state_id');
    }

}
